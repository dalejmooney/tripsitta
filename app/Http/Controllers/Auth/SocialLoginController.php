<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the authentication page.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    /**
     * Obtain the user information.
     */
    public function handleProviderCallback()
    {
        $user_social = Socialite::driver('facebook')->stateless()->fields([
                'name',
                'first_name',
                'last_name',
                'email',
            ])->user();

        $user = User::where(['email' => $user_social->getEmail()])->first();

        if($user){
            Auth::login($user);
            if($user->role == 'babysitter')
            {
                return redirect('/babysitter/overview');
            }
            else
            {
                return redirect('/parent/overview');
            }

        }

        $new_user = User::create([
            'name' => $user_social->user['first_name'],
            'surname' => $user_social->user['last_name'],
            'email' => $user_social->getEmail(),
            'provider_id' => $user_social->getId(),
            'role' => 'parent',
            'provider' => 'facebook',
        ]);

        return redirect()->route('register-specific', ['any'])->withInput([
            'name'          => $user_social->user['first_name'],
            'surname'       => $user_social->user['last_name'],
            'id'            => $new_user->id,
            'email'         => $user_social->getEmail(),
        ]);

    }
}
