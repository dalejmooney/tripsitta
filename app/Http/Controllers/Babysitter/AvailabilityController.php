<?php

namespace App\Http\Controllers\Babysitter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Babysitter\UpdateAvailabilityRequest;
use App\Models\BabysitterAvailability;
use App\User;


class AvailabilityController extends Controller
{
    public function show(){
        $user = User::with(['babysitter'])->find($this->user_id);

        $availability_babysitter = BabysitterAvailability::selectRaw('date, GROUP_CONCAT(type) as note')->where('babysitter_id', $this->user_id)->where('type', '<>', 'holiday_nanny')->groupBy('date')->get()
            ->map(function ($item, $key) {
                return ['date' => $item->date, 'note' => explode(',', $item->note)];
        });

        $availability_holiday_nanny = BabysitterAvailability::selectRaw('date, GROUP_CONCAT(type) as note')->where('babysitter_id', $this->user_id)->where('type', 'holiday_nanny')->groupBy('date')->get()->map(function ($item, $key) {
            return ['date' => $item->date, 'note' => explode(',', $item->note)];
        });

        return view('babysitter.availability')->with([
            'user' => $user,
            'availability' => [
                'babysitter' => $availability_babysitter,
                'holiday_nanny' => $availability_holiday_nanny,
            ]
        ]);
    }

    public function store(UpdateAvailabilityRequest $request){
        $user = User::with(['babysitter', 'babysitter.availability', 'babysitter.bookings'])->findOrFail($this->user_id);

        $user->babysitter->jobs_babysitter = $request->get('jobs_babysitter');
        $user->babysitter->jobs_holiday_nanny = $request->get('jobs_holiday_nanny');

        // update availability
        $user->babysitter->availability()->delete();
        foreach($request->input('availability_babysitter_array') as $i => $availability)
        {
            foreach($availability['note'] as $type)
            {
                $new = new BabysitterAvailability();
                $new->date = $availability['date'];
                $new->type = $type;
                $new->babysitter_id = $this->user_id;
                $new->save();
            }
        }

        foreach($request->input('availability_holiday_nanny_array') as $i => $availability)
        {
            foreach($availability['note'] as $type)
            {
                $new = new BabysitterAvailability();
                $new->date = $availability['date'];
                $new->type = $type;
                $new->babysitter_id = $this->user_id;
                $new->save();
            }
        }

        $update = $user->push();

        return $this->returnStatus($update);
    }

    private function returnStatus($update)
    {
        $status['status'] = ['type' => 'success', 'message' => 'Profile updated!'];
        if($update == 0) $status['status'] = ['type' => 'error', 'message' => 'Profile update failed! Please try again. If problem repeats please contact us'];

        return redirect()->back()->with($status);
    }
}
