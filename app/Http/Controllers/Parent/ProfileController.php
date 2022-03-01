<?php

namespace App\Http\Controllers\Parent;

use App\Http\Requests\Parent\profileSaveFinalRequest;
use App\Http\Requests\Parent\profileSavePart1Request;
use App\Http\Requests\Parent\profileSavePart2Request;
use App\Http\Requests\Parent\profileSavePart3Request;
use App\Mail\NewRegistrationParent;
use App\Models\Family;
use App\Models\FamilyAddress;
use App\Models\FamilyChild;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class ProfileController extends Controller
{
    public function showFormPart1(){
        $user = User::with('family')->findOrFail($this->user_id);

        return view('parent.my-profile')->with([
            'user' => $user
        ]);
    }

    public function savePart1(profileSavePart1Request $request)
    {
        $update = User::where('id', $this->user_id)->update($request->only(
            ['name', 'surname', 'dob', 'phone_number', 'emergency_phone_number']
        ));

        $family_update = Family::where('id', $this->user_id)->update([
            'reg_step_1_completed' => 1
        ]);

        return $this->returnStatus($update);
    }

    public function showFormPart2(){
        $user = User::with(['family.children'])->findOrFail($this->user_id);

        return view('parent.my-profile-children')->with([
            'user' => $user
        ]);
    }

    public function savePart2(profileSavePart2Request $request)
    {
        $user = User::with(['family'])->findOrFail($this->user_id);

        $user->family->children_health_problems = $request->get('children_health_problems');
        $user->family->reg_step_2_completed = 1;

        $user->family->children()->delete();

        foreach($request->get('child') as $child)
        {
            $new = new FamilyChild();
            $new->name = $child['name'];
            $new->dob = $child['dob'];
            $new->family_id = $this->user_id;
            $new->save();
        }

        $update = $user->push();

        return $this->returnStatus($update);
    }

    public function showFormPart3(){
        $user = User::with(['family.address'])->findOrFail($this->user_id);
        $countries = \Countries::getList();

        return view('parent.my-profile-addresses')->with([
            'user' => $user,
            'countries' => $countries,
        ]);
    }

    public function savePart3(profileSavePart3Request $request)
    {
        $user = User::with(['family'])->findOrFail($this->user_id);
        $address = FamilyAddress::updateOrCreate(['family_id' => $this->user_id], $request->validated());

        if($address->wasChanged())
        {
            $user->family->reg_step_3_completed = 1;
            $user->push();
        }

        return $this->returnStatus($address->wasChanged());
    }

    public function showFormFinal(){
        $user = User::with(['family'])->findOrFail($this->user_id);
        $countries = \Countries::getList();

        return view('parent.my-profile-submit')->with([
            'user' => $user,
            'countries' => $countries,
        ]);
    }

    public function saveFinal(profileSaveFinalRequest $request)
    {
        $user = User::with(['family'])->findOrFail($this->user_id);

        if($user->family->reg_step_1_completed != true || $user->family->reg_step_2_completed != true || $user->family->reg_step_3_completed != true) {
            return redirect()->back()->with([
                'status' => ['type' => 'error', 'message' => 'Please fill in all other "my profile" pages first before confirming your registration']
            ]);
        }

        $user->family->found_source = $request->get('found_source');
        $user->family->reg_form_submitted = 1;
        $user->family->published = 1;

        $update = $user->push();

        if($update == 0)
        {
            return $this->returnStatus($update);
        }

        // parent registration successful
        Mail::to($user->email)->send(new NewRegistrationParent($user->name));

        return redirect('parent/overview')->with(['status' => ['type' => 'success', 'message' => 'Registration completed. Account created successfully!']]);
    }


    private function returnStatus($update)
    {
        $status['status'] = ['type' => 'success', 'message' => 'Profile updated!'];
        if($update == 0) $status['status'] = ['type' => 'error', 'message' => 'Profile update failed! Please try again. If problem repeats please contact us'];

        return redirect()->back()->with($status);
    }
}
