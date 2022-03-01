<?php
namespace App\Http\Controllers\Admin;

use App\Models\InterviewAvailability;
use Illuminate\Http\Request;

class InterviewsCalendar
{
    public function index()
    {
        $interview_availability = InterviewAvailability::get(['date'])->pluck('date');

        return view('admin.interviews-calendar')->with([
            'interview_availability' => $interview_availability->toArray()
        ]);
    }

    public function store(Request $request)
    {
        $dates = $request->get('fields');
        $dates = json_decode($dates, true);

        foreach($dates as $i => $date)
        {
            unset($dates[$i]);
            $dates[$i]['date'] = (new \DateTime($date['dates']))->format('Y-m-d');
        }

        InterviewAvailability::truncate();
        InterviewAvailability::insert($dates);

        return redirect()->back()->with(['status' => 'Interview calendar updated']);
    }
}
