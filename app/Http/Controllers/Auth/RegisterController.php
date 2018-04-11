<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
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

    use RegistersUsers,RedirectHelpers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/activities';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->setRefererUrlToView();
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
            'nickname' => 'required|string|max:30',
            'age' => 'required|numeric|min:1|max:100',
            'phone' => 'required|string|mobile|unique:users',
            'password' => 'required|string|min:6|max:16|confirmed',
            'city' => 'required|string|max:30',
            'is_our_users' => 'required|numeric|min:0|max:1',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $md = str_random(4);
        return User::create([
            'nickname' => trim($data['nickname']),
            'age'      => (int)$data['age'],
            'city'     => trim($data['city']),
            'phone'    => trim($data['phone']),
            'md'       => $md,
            'password' => make_password($data['password'], $md),
            'is_our_users' => $data['is_our_users'],
        ]);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return [];
    }
}
