<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\DB;

class ChatRepository extends ModuleRepository
{
    public function __construct(Chat $model)
    {
        $this->model = $model;
    }

    public function filter($query, array $scopes = []) {
        $filter_status = '';
        $filter = (array_key_exists('filter', request()->input())) ? json_decode(request()->input()['filter'], true) : null;

        if(is_array($filter) && array_key_exists('status', $filter)){
            $filter_status = $filter['status'];
        }

        if($filter_status === 'can-reply')
        {
            $query->where(function ($query) {
                $query->where('sender_id', 0)
                    ->orWhereNull('sender_id');
            })->orWhere(function ($query) {
                $query->where('recipient_id', 0)
                    ->orWhereNull('recipient_id');
            });
        }

        //search
        if (isset($scopes['%id'])) {
            $query->where(function($q) use($scopes){
                $q->where('booking_id', 'like', '%'.$scopes['%id'].'%')->orWhere('id', 'like', '%'.$scopes['%id'].'%');
            });

            unset($scopes['%id']);
        }

        return parent::filter($query, $scopes);
    }

    public function order($query, array $orders = []) {
        foreach(['senderFullNameWithLink' => 'name', 'recipientFullNameWithLink' => 'name'] as $field_key => $field)
        {
            if (array_key_exists($field_key, $orders)){
                $sort_method = $orders[$field_key];
                unset($orders[$field_key]);

                if($field_key === 'senderFullNameWithLink')
                {
                    $query = $this->orderSender($query, $field, $sort_method);
                }
                else
                {
                    $query = $this->orderRecipient($query, $field, $sort_method);
                }
            }
        }

        if (array_key_exists('bookingIdPaddedWithLink', $orders)){
            $sort_method = $orders['bookingIdPaddedWithLink'];
            unset($orders['bookingIdPaddedWithLink']);
            $query = $query->orderBy('booking_id', $sort_method);
        }

        if (array_key_exists('lastMessageDate', $orders)){
            $sort_method = $orders['lastMessageDate'];
            unset($orders['lastMessageDate']);
            $query = $this->orderLastMessageDate($query, $sort_method);
        }

        return parent::order($query, $orders);
    }

    private function orderRecipient($query, $field_name, $sort_method)
    {
        return $query->leftJoin('users', 'users.id', '=', 'chats.recipient_id')->select('chats.*', 'users.name', 'users.surname', 'users.email')->orderBy($field_name, $sort_method);
    }

    private function orderSender($query, $field_name, $sort_method)
    {
        return $query->leftJoin('users', 'users.id', '=', 'chats.sender_id')->select('chats.*', 'users.name', 'users.surname', 'users.email')->orderBy($field_name, $sort_method);
    }

    private function orderLastMessageDate($query, $sort_method)
    {
        return $query
            ->leftJoin('chat_messages', 'chat_messages.id', '=', 'chats.id')
            ->select('chats.*', DB::raw('(SELECT max(created_at) from chat_messages where chat_id = chats.id) as max'))
            ->orderBy('max', $sort_method);
    }

    public function getFormFields($object) {
        $fields = parent::getFormFields($object);

        $fields['messages'] = $object->messages->sortByDesc('created_at');
        $fields['sender'] = $object->sender;
        $fields['recipient'] = $object->recipient;

        return $fields;
    }

    public function afterSave($object, $fields)
    {
        $message = new ChatMessage();
        $message->message = $fields['message'];
        $message->added_by = 0;
        $message->chat_id = $object->id;
        $message->save();

        return $fields;
    }

    public function getCountForAdminChats()
    {
        return $this->model->where(function ($query) {
            $query->where('sender_id', 0)
                ->orWhereNull('sender_id');
            })->orWhere(function ($query) {
            $query->where('recipient_id', 0)
                ->orWhereNull('recipient_id');
        })->count();
    }
}
