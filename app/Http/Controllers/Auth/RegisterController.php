<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Socialite;
use Validator;
use App\Http\Controllers\Controller;
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
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
            'name' => 'required|max:255',
            'email' => 'bail|required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => bcrypt($data['password']),
            'confirmation_code' => str_random(30),
        ]);
    }

    /**
     * Redirect the user to the Social authentication page.
     *
     * @param string $social
     * @return response
     */
    public function redirectToProvider($social)
    {
        return Socialite::driver($social)->redirect();
    }

    /**
     * Obtain the user information from Social.
     *
     * @param string $social
     * @return redirect response
     */
    public function handleProviderCallback($social)
    {
        try {
            $user = Socialite::driver($social)->user();
        } catch (Exception $e) {
            return redirect('login');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);
        //Fire event
        event('UserLoggedInWithSocial');

        return redirect()->intended('dashboard');
    }

    /**
     * Return user if exists; create and return if dose not.
     *
     * @param string $socialUser
     * @return resource User Information
     */
    private function findOrCreateUser($socialUser)
    {
        if ($authUser = User::where('email', $socialUser->email)->first()) {
            return $authUser;
        }
        return User::create([
            'name'      => $socialUser->name,
            'email'     => $socialUser->email,
            'password'  => bcrypt($socialUser->id),
            'social_id' => $socialUser->id,
            'avatar'    => $socialUser->avatar,
        ]);
    }

    public function confirm($confirmationCode)
    {
        if( ! $confirmationCode)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($confirmationCode)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        alert()->success('Congratulations', 'You have successfully verified your account.');

        return redirect()->route('login');
    }
}
