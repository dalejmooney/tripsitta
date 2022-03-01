<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Babysitter;
use App\Models\BabysitterAddress;
use App\Models\BabysitterAvailability;
use App\Models\BabysitterBankDetail;
use App\Models\BabysitterJoinReason;
use App\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class BabysitterRepository extends ModuleRepository
{
    use HandleMedias, HandleFiles, HandleRepeaters;

    public function __construct(Babysitter $model)
    {
        $this->model = $model;
    }

    public function getFormFields($object) {
        $fields = parent::getFormFields($object);

        $fields['user'] = $object->user->toArray();
        $fields['babysitter_join_reasons'] = ($object->joinReasons) ? $object->joinReasons->pluck('reason')->toArray() : [];
        $fields['babysitter_experience_age_groups'] = ($object->experienceAgeGroups) ? $object->experienceAgeGroups->pluck('age_group')->toArray() : [];
        $fields['babysitter_main_address'] = ($object->mainAddress) ? $object->mainAddress->toArray() : [];
        //if(isset($fields['babysitter_main_address']['country']))  $fields['babysitter_main_address']['country'] = "'" . $fields['babysitter_main_address']['country'] . "'"; // workaround twill error #175
        $fields['babysitter_temp_address'] = ($object->temporaryAddress) ? $object->temporaryAddress->toArray() : [];
        //if(isset($fields['babysitter_temp_address']['country'])) $fields['babysitter_temp_address']['country'] = "'" . $fields['babysitter_temp_address']['country'] . "'"; // workaround twill error #175
        $fields['babysitter_skills'] = ($object->skills) ? $object->skills->pluck('skill_code')->toArray() : [];

        $fields['availability'] = ['babysitter' => ['day' => [], 'night' => []], 'holiday_nanny' => []];

        if($object->availabilityBabysitterOnly)
        {
            list($day, $night) = $object->availabilityBabysitterOnly->partition(function ($el) {
                return $el->type == 'babysitter-day';
            });

            $fields['availability']['babysitter']['day'] = $day->pluck('date')->toArray();
            $fields['availability']['babysitter']['night'] = $night->pluck('date')->toArray();
        }

        if($object->availabilityHolidayNannyOnly)
        {
            $fields['availability']['holiday_nanny'] = $object->availabilityHolidayNannyOnly->pluck('date')->toArray();
        }

        if($object->bookings)
        {
            $bookings = $object->bookings;
            $bookings_arr = [];
            foreach($bookings as $booking)
            {
                $dates = CarbonPeriod::create($booking->start, $booking->end);
                $dates_arr = [];

                foreach ($dates as $date) {
                    $dates_arr[] = $date->format('Y-m-d');
                }

                if($booking->type == 'babysitter')
                {
                    $bookings_arr[] = [
                        'color' => 'orange',
                        'dates' => $dates_arr,
                        'description' => 'Booking ID '.$booking->id
                    ];
                    continue;
                }

                $bookings_arr[] = [
                    'color' => 'blue',
                    'dates' => $dates_arr,
                    'description' => 'Booking ID '.$booking->id
                ];
            }

            $fields['bookings'] = $bookings_arr;
        }

        $fields['fullname'] = $object->user->fullname;
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'languages', 'BabysitterLanguage', 'language');

        $fields['review_score'] = $object->reviewsAverage;
        $fields['review_count'] = $object->reviewsNumber;

        $fields['bank'] = [];
        if($object->bank)
        {
            $fields['bank'] = $object->bank->toArray();
        }

        return $fields;
    }


    public function order($query, array $orders = []) {
        foreach(['userFullname' => 'name', 'userEmail' => 'email'] as $field_key => $field)
        {
            if (array_key_exists($field_key, $orders)){
                $sort_method = $orders[$field_key];
                unset($orders[$field_key]);
                $query = $this->orderUser($query, $field, $sort_method);
            }
        }

        if (array_key_exists('reviewsAverage', $orders)){
            $sort_method = $orders['reviewsAverage'];
            unset($orders['reviewsAverage']);
            $query = $this->orderScore($query, $sort_method);
        }

        if (array_key_exists('reviewsNumber', $orders)){
            $sort_method = $orders['reviewsNumber'];
            unset($orders['reviewsNumber']);
            $query = $this->orderScoreCount($query, $sort_method);
        }

        if (array_key_exists('validIdAsIcon', $orders)){
            $sort_method = $orders['validIdAsIcon'];
            unset($orders['validIdAsIcon']);
            $query = $query->orderBy('has_valid_id', $sort_method);
        }

        return parent::order($query, $orders);
    }

    private function orderUser($query, $field_name, $sort_method)
    {
        return $query->leftJoin('users', 'users.id', '=', 'babysitters.id')->select('babysitters.*', 'users.name', 'users.surname', 'users.email')->orderBy($field_name, $sort_method);
    }

    private function orderScore($query, $sort_method){
        return $query
            ->selectRaw('babysitters.* ,(SELECT AVG(score) as avg FROM babysitter_reviews WHERE babysitter_id = babysitters.id && published = 1) as rating')
            ->orderByRaw('rating '. $sort_method);
    }

    private function orderScoreCount($query, $sort_method){
        return $query
            ->selectRaw('babysitters.* ,(SELECT COUNT(score) as avg FROM babysitter_reviews WHERE babysitter_id = babysitters.id && published = 1) as rating')
            ->orderByRaw('rating '. $sort_method);
    }

    public function prepareFieldsBeforeCreate($fields) {
        $user = new User;
        $user->name = $fields['user.name'];
        $user->surname = $fields['user.surname'];
        $user->password = Hash::make('babysitter');
        $user->email = $fields['user.email'];
        $user->dob = null;
        $user->role = 'babysitter';
        $user->save();

        $fields['id'] = $user->id;
        $this->user_object = $user;

        return parent::prepareFieldsBeforeCreate($fields);
    }

    public function filter($query, array $scopes = []) {
        $filter_status = '';
        $filter = (array_key_exists('filter', request()->input())) ? json_decode(request()->input()['filter'], true) : null;

        if(is_array($filter) && array_key_exists('status', $filter)){
            $filter_status = $filter['status'];
        }

        if($filter_status !== '')
        {
            if($filter_status === 'new')
            {
                $query->whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime('-7 days')));
            }
        }

        if(array_key_exists('%userFullname', $scopes))
        {
            $query->whereHas('user', function ($query) use ($scopes){
                $query->where('name', 'like', '%'.$scopes['%userFullname'].'%');
            });

            unset($scopes['%userFullname']);
        }

        return parent::filter($query, $scopes);
    }

    public function afterSave($object, $fields)
    {
        $user = $object->user;

        if($user)
        {
            $user->name = $fields['user.name'] ?? '';
            $user->surname = $fields['user.surname'] ?? '';
            $user->email = $fields['user.email'] ?? '';
            $user->emergency_name = $fields['user.emergency_name'] ?? '';
            $user->emergency_relationship = $fields['user.emergency_relationship'] ?? '';
            $user->emergency_phone_number = $fields['user.emergency_phone_number'] ?? '';
            $user->phone_number = $fields['user.phone_number'] ?? '';
            $user->home_phone_number = $fields['user.home_phone_number'] ?? '';
            $user->dob = (isset($fields['user.dob'])) ? Carbon::parse($fields['user.dob']) : null;
            $user->save();
        }
        else
        {
            $object->id = $fields['id'];  // update id so redirect works correctly for create
            $object->user = $this->user_object;
            $user = $object->user;
        }

        $main_address = $object->mainAddress;

        if(!$main_address)
        {
            $main_address = new BabysitterAddress;
        }

        $main_address->address1 = $fields['babysitter_main_address.address1'] ?? '';
        $main_address->address2 = $fields['babysitter_main_address.address2'] ?? '';
        $main_address->town = $fields['babysitter_main_address.town'] ?? '';
        $main_address->postcode = $fields['babysitter_main_address.postcode'] ?? '';
        $main_address->country = $fields['babysitter_main_address.country'] ?? '';
        $object->mainAddress()->save($main_address);

        $temp_address = $object->temporaryAddress;

        if(!$temp_address)
        {
            $temp_address = new BabysitterAddress;
        }

        $temp_address->address1 = $fields['babysitter_temp_address.address1'] ?? '';
        $temp_address->address2 = $fields['babysitter_temp_address.address2'] ?? '';
        $temp_address->town = $fields['babysitter_temp_address.town'] ?? '';
        $temp_address->postcode = $fields['babysitter_temp_address.postcode'] ?? '';
        $temp_address->country = $fields['babysitter_temp_address.country'] ?? '';
        $temp_address->home_address = 0;
        $object->temporaryAddress()->save($temp_address);

        $this->updateOneToMany($object, $fields, 'joinReasons', 'babysitter_join_reasons', 'reason');
        $this->updateOneToMany($object, $fields, 'experienceAgeGroups', 'babysitter_experience_age_groups', 'age_group');
        $this->updateOneToMany($object, $fields, 'skills', 'babysitter_skills', 'skill_code');
        $this->updateRepeater($object, $fields, 'languages', 'BabysitterLanguage', 'language');

        // update availability
        if(array_key_exists('availability_babysitter', $fields) && !empty($fields['availability_babysitter']) &&
            array_key_exists('availability_holiday_nanny', $fields) && !empty($fields['availability_holiday_nanny']))
        {
            $user->babysitter->availability()->delete();
            $availability_babysitter_day = json_decode($fields['availability_babysitter'], true)[0];
            foreach($availability_babysitter_day['dates'] as $i => $availability) {
                $new = new BabysitterAvailability();
                $new->date = $availability;
                $new->type = 'babysitter-day';
                $new->babysitter_id = $user->id;
                $new->save();
            }

            $availability_babysitter_night = json_decode($fields['availability_babysitter'], true)[1];
            foreach($availability_babysitter_night['dates'] as $i => $availability) {
                $new = new BabysitterAvailability();
                $new->date = $availability;
                $new->type = 'babysitter-night';
                $new->babysitter_id = $user->id;
                $new->save();
            }

            $availability_holiday_nanny = json_decode($fields['availability_holiday_nanny'], true)[0];
            foreach($availability_holiday_nanny['dates'] as $i => $availability) {
                $new = new BabysitterAvailability();
                $new->date = $availability;
                $new->type = 'holiday_nanny';
                $new->babysitter_id = $user->id;
                $new->save();
            }
        }

        // update bank details
        if($object->bank) $object->bank->delete();

        $new_bank = new BabysitterBankDetail();
        $new_bank->babysitter_id = $user->id;
        $new_bank->currency = $fields['bank.currency'] ?? '';
        $new_bank->name = $fields['bank.name'] ?? '';
        $new_bank->transferwise_type = BabysitterBankDetail::getTransferwiseTypeFromCurrency($new_bank->currency);
        $new_bank->sort_code = $fields['bank.sort_code'] ?? '';
        $new_bank->account_number = $fields['bank.account_number'] ?? '';
        $new_bank->iban = $fields['bank.iban'] ?? '';
        $new_bank->address1 = $fields['bank.address1'] ?? '';
        $new_bank->address2 = $fields['bank.address2'] ?? '';
        $new_bank->town = $fields['bank.town'] ?? '';
        $new_bank->postcode = $fields['bank.postcode'] ?? '';
        $new_bank->state = $fields['bank.state'] ?? '';
        $new_bank->country = $fields['bank.country'] ?? '';
        $new_bank->account_type = $fields['bank.account_type'] ?? '';
        $new_bank->save();

        parent::afterSave($object, $fields);
    }

    public function getCountForPublished()
    {
        return $this->model->active()->count();
    }

    /**
     * @return int
     */
    public function getCountForDraft()
    {
        return $this->model->disabled()->count();
    }

    /**
     * @return int
     */
    public function getCountForNew()
    {
        return $this->model->whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime('-7 days')) )->count();
    }

    /**
     * @return int
     */
    public function getCountForTrash()
    {
        return $this->model->onlyTrashed()->count();
    }
}
