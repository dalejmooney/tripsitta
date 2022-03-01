<?php

namespace App\Http\Controllers\Babysitter;

use App\Http\Requests\Parent\StoreChatMessageRequest;
use App\Mail\AdminChatMessageReceived;
use App\Mail\ChatMessageReceived;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\User;

class ChatController extends Controller
{
    public function show(Booking $booking){
        $user = User::with('babysitter')->findOrFail($this->user_id);

        $chat = Chat::forBooking($booking)->with(['messages.addedBy', 'recipient', 'sender'])->first();

        return view('babysitter.booking-chat')->with([
            'user' => $user,
            'chat' => $chat,
            'chat_messages' => $chat ? $chat->messages->sortByDesc('created_at') : [],
            'booking' => $booking,
        ]);
    }

    public function showAdmin()
    {
        $user = User::with('babysitter')->findOrFail($this->user_id);

        $chat = Chat::forAdmin()->where('sender_id', $user->id)->with(['messages.addedBy', 'recipient', 'sender'])->first();

        return view('babysitter.admin-chat')->with([
            'user' => $user,
            'chat' => $chat,
            'chat_messages' => $chat ? $chat->messages->sortByDesc('created_at') : [],
        ]);
    }

    public function store(StoreChatMessageRequest $request, Booking $booking)
    {
        $chat = Chat::forBooking($booking)->first();

        if(!$chat)
        {
            $chat = new Chat();
            $chat->sender_id = $this->user_id;
            $chat->recipient_id = $booking->family_id;
            $chat->booking_id = $booking->id;
            $chat->save();
        }

        $chat->messages()->create([
            'message' => $request->input('new_message'),
            'added_by' => $this->user_id,
        ]);

        \Mail::to($booking->family->user->email)->send(new ChatMessageReceived(
            $booking->family->user->name,
            route('parent.booking-chat', $booking->id)
        ));

        return response()->json(['success' => 'Chat message sent']);
    }

    public function storeAdmin(StoreChatMessageRequest $request)
    {
        $chat = Chat::forAdmin()->where('sender_id', $this->user_id)->with(['messages.addedBy', 'recipient', 'sender'])->first();

        if(!$chat)
        {
            $chat = new Chat();
            $chat->sender_id = $this->user_id;
            $chat->recipient_id = 0;
            $chat->booking_id = 0;
            $chat->save();
        }

        $chat->messages()->create([
            'message' => $request->input('new_message'),
            'added_by' => $this->user_id,
        ]);

        \Mail::to(config('tripsitta.admin_email'))->send(new AdminChatMessageReceived());

        return response()->json(['success' => 'Chat message sent']);
    }
}
