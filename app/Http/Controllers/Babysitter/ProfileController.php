<?php

namespace App\Http\Controllers\Babysitter;

use App\Extensions\ExtCountries;
use App\Http\Requests\Babysitter\profileSavePart1Request;
use App\Http\Requests\Babysitter\profileSavePart2Request;
use App\Http\Requests\Babysitter\profileSavePart3Request;

use App\Http\Requests\Babysitter\profileSavePart4Request;
use App\Http\Requests\Babysitter\profileSavePart5Request;
use App\Mail\NewRegistrationBabysitter;
use App\Models\Babysitter;
use App\Models\BabysitterExperienceAgeGroup;
use App\Models\BabysitterJoinReason;
use App\Models\BabysitterLanguage;
use App\Models\BabysitterSkill;
use App\Models\InterviewAvailability;
use App\Traits\UploadFiles;
use App\User;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    use UploadFiles;

    public function showFormPart1(){
        $user = User::with('babysitter')->findOrFail($this->user_id);

        return view('babysitter.my-profile')->with([
            'user' => $user
        ]);
    }

    public function savePart1(profileSavePart1Request $request)
    {
        $update = User::where('id', $this->user_id)->update($request->only(
            ['name', 'surname', 'dob']
        ));

        $user = User::find($this->user_id);
        if(!$user->babysitter->hasCompletedRegistration()) {
            $babysitter_update = Babysitter::where('id', $this->user_id)->update([
                'reg_step_1_completed' => 1
            ]);
        }

        return $this->returnStatus($update);
    }

    public function showFormPart2()
    {
        $user = User::with('babysitter.mainAddress')->find($this->user_id);
        $countries = \Countries::getList();

        return view('babysitter.my-profile-addresses')->with([
            'user' => $user,
            'countries' => $countries,
        ]);
    }

    public function savePart2(profileSavePart2Request $request)
    {
        $user = User::with(['babysitter.mainAddress', 'babysitter.temporaryAddress'])->findOrFail($this->user_id);

        $user->fill($request->only(['phone_number', 'home_phone_number', 'emergency_name', 'emergency_relationship', 'emergency_phone_number']));

        $user->babysitter->mainAddress->fill(array_merge($request->input('mainAddress'), ['home_address' => 1]));

        if($request->input('temporaryAddress.address1') != '')
        {
            $user->babysitter->temporaryAddress->fill(array_merge($request->input('temporaryAddress'), ['home_address' => 0]));
        }
        else
        {
            if($user->babysitter->temporaryAddress !== null) $user->babysitter->temporaryAddress->delete();
        }

        if(!$user->babysitter->hasCompletedRegistration())
        {
            $user->babysitter->reg_step_1_completed = 1;
            $user->babysitter->reg_step_2_completed = 1;
        }

        $update = $user->push();

        return $this->returnStatus($update);
    }

    public function showFormPart3()
    {
        $user = User::with('babysitter.joinReasons')->find($this->user_id);

        return view('babysitter.my-profile-about-me')->with([
            'user' => $user,
        ]);
    }

    public function savePart3(profileSavePart3Request $request)
    {
        $user = User::with(['babysitter.joinReasons'])->findOrFail($this->user_id);

        if(!$user->babysitter->hasCompletedRegistration())
        {
            if($user->babysitter->joinReasons !== null) $user->babysitter->joinReasons()->delete();
            foreach($request->input('reasons') as $reason)
            {
                $new = new BabysitterJoinReason();
                $new->reason = $reason;
                $new->babysitter_id = $this->user_id;
                $new->save();
            }

            if($request->hasFile('cv'))
            {
                $this->removeExistingFiles($user, 'cv');
                $this->saveFileAndAttach($request->file('cv'), $user, 'cv');
            }

            $user->babysitter->fill($request->only(['join_reason_text']));
            $user->babysitter->reg_step_3_completed = 1;
        }
        else
        {
            if($request->hasFile('profile_image'))
            {
                $this->removeExistingMediaFiles($user, 'profile_image');
                $this->saveMediaFileAndAttach($request->file('profile_image'), $user, 'profile_image');
            }

            $user->babysitter->skills()->delete();
            if(!empty($request->input('babysitter_skills')))
            {
                foreach($request->input('babysitter_skills') as $i => $skill_code)
                {
                    $new = new BabysitterSkill();
                    $new->skill_code = $skill_code;
                    $new->babysitter_id = $this->user_id;
                    $new->save();
                }
            }

            $user->babysitter->fill($request->only(['profile_content', 'profile_background']));
        }

        $update = $user->push();

        return $this->returnStatus($update);
    }

    public function showFormPart4()
    {
        $user = User::with(['babysitter.languages', 'babysitter.experienceAgeGroups'])->find($this->user_id);

        return view('babysitter.my-profile-experience')->with([
            'user' => $user,
            'languages' => ExtCountries::getSelectLanguagesList(),
        ]);
    }

    public function savePart4(profileSavePart4Request $request)
    {
        $user = User::with(['babysitter'])->findOrFail($this->user_id);

        $user->babysitter->experience_years = $request->get('experience_years');

        $user->babysitter->experienceAgeGroups()->delete();
        foreach($request->input('experience_age_groups') as $i => $experience_age_groups)
        {
            $new = new BabysitterExperienceAgeGroup();
            $new->age_group = $experience_age_groups;
            $new->babysitter_id = $this->user_id;
            $new->save();
        }

        $user->babysitter->languages()->delete();
        foreach($request->get('languages') as $language)
        {
            $new = new BabysitterLanguage();
            $new->language_name = $language['lang'];
            $new->language_level = $language['level'];
            $new->babysitter_id = $this->user_id;
            $new->save();
        }

        if($request->hasFile('qualifications'))
        {
            $this->removeExistingFiles($user, 'qualifications');
            $this->saveManyFilesAndAttach($request->file('qualifications'), $user, 'qualifications');
        }

        if(!$user->babysitter->hasCompletedRegistration())
        {
            if($request->hasFile('identity_verification'))
            {
                $this->removeExistingFiles($user, 'identity_verification');
                $this->saveFileAndAttach($request->file('identity_verification'), $user, 'identity_verification');
            }

            $user->babysitter->reg_step_4_completed = 1;
        }
        else
        {
            $user->babysitter->first_aid_passed = $request->get('first_aid_passed');
            $user->babysitter->first_aid_expiry = $request->get('first_aid_expiry');
            if($request->hasFile('first_aid_certificate'))
            {
                $this->removeExistingFiles($user, 'first_aid_certificate');
                $this->saveFileAndAttach($request->file('first_aid_certificate'), $user, 'first_aid_certificate');
            }

            $user->babysitter->criminal_record_check_expiry = $request->get('criminal_record_check_expiry');
            if($request->hasFile('criminal_record_check'))
            {
                $this->removeExistingFiles($user, 'criminal_record_check');
                $this->saveFileAndAttach($request->file('criminal_record_check'), $user, 'criminal_record_check');
            }
        }

        $update = $user->push();

        return $this->returnStatus($update);
    }

    public function showFormPart5()
    {
        $user = User::with(['babysitter.languages', 'babysitter.experienceAgeGroups'])->findOrFail($this->user_id);

        // get availability between now and +2 months
        $available_dates = InterviewAvailability::where('date', '>=', today())->where('date', '<=', today()->modify('+2 months'))->get('date')->pluck('date')->toArray();
        $unavailable_dates = [];
        $begin = today();
        $end = today()->modify('+2 months');
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            if(in_array($i->format("Y-m-d"), $available_dates)) continue;
            $unavailable_dates[] = $i->format("Y-m-d");
        }

        return view('babysitter.my-profile-submit-application')->with([
            'calendar' => [
                'max_date' => (new \DateTime())->modify('+2 months')->format('Y-m-d'),
                'blocked_dates' => $unavailable_dates,
            ],
            'user' => $user,
        ]);
    }

    public function savePart5(profileSavePart5Request $request)
    {
        $user = User::with(['babysitter'])->find($this->user_id);

        if($user->babysitter->reg_step_1_completed != true || $user->babysitter->reg_step_2_completed != true || $user->babysitter->reg_step_3_completed != true || $user->babysitter->reg_step_4_completed != true)
        {
            return redirect()->back()->with([
                'status' => ['type' => 'error', 'message' => 'Please fill in all other steps first before booking interview and submitting the application']
            ]);
        }

        $user->babysitter->interview_date = new \DateTime($request->get('interview_date'));
        $user->babysitter->interview_time = $request->get('interview_time');
        $user->babysitter->found_source = $request->get('found_source');
        $user->babysitter->reg_form_submitted = 1;

        $update = $user->push();

        if($update == 0)
        {
            return $this->returnStatus($update);
        }

        // babysitter registration successful
        \Mail::to($user->email)->send(new NewRegistrationBabysitter(
            $user->name,
            (new \DateTime($request->get('interview_date')))->format('d M Y'),
            $request->get('interview_time')
        ));
        return redirect('babysitter/overview');
    }

    private function returnStatus($update)
    {
        $status['status'] = ['type' => 'success', 'message' => 'Profile updated!'];
        if($update == 0) $status['status'] = ['type' => 'error', 'message' => 'Profile update failed! Please try again. If problem repeats please contact us'];

        return redirect()->back()->with($status);
    }
}
