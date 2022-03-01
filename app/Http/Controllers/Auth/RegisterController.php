<?php

namespace App\Http\Controllers\Auth;

use App\Models\Babysitter;
use App\Models\Family;
use App\Models\Page;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/parent/overview';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:500'],
            'dob' => ['required', 'string', 'date_format:Y-m-d'],
            'email' => ['bail', 'required_without:id', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['bail', 'required_without:id', 'string', 'min:8', 'confirmed'],
            'id' => ['bail', 'required_without:password', 'string', 'exists:users'],
            'accept_tnc' => ['required'],
            'account_type' => ['required', 'in:babysitter,parent'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['account_type'] == 'babysitter')
        {
            $this->redirectTo = '/babysitter/overview';
        }

        if(array_key_exists('id', $data))
        {
            User::findOrFail($data['id']);

            User::where('id', $data['id'])->update([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'dob' => (\DateTime::createFromFormat('Y-m-d', $data['dob'])),
                'role' => $data['account_type']
            ]);
            $user_id = $data['id'];
        }
        else
        {
            $new_user = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'dob' => (\DateTime::createFromFormat('Y-m-d', $data['dob'])),
                'email' => ($data['email']),
                'password' => Hash::make($data['password']),
                'role' => $data['account_type']
            ]);
            $user_id = $new_user->id;
        }

        if($data['account_type'] == 'babysitter')
        {
            Babysitter::create(['id' => $user_id]);
        }
        else
        {
            Family::create(['id' => $user_id]);
        }

        return User::find($user_id);
    }

    public function index()
    {
        $page = Page::forHook('register')->firstOrFail();

        return view('auth.register', [
            'page' => $page,
        ]);
    }

    public function show($account_type)
    {
        $page = Page::forHook('register')->firstOrFail();

        return view('auth.register-specific', [
            'account_type' => $account_type,
            'page' => $page,
        ]);
    }
}
