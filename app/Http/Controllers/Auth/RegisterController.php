<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Socialite;
use Validator;

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
            'name'      => 'required|max:255',
            'email'     => 'bail|required|email|max:255|unique:users',
            'password'  => 'required|min:6|confirmed',
            'avatar'    => 'required|image|max:1024',
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
    $path = $this->avatarUpload($data['avatar']);
    return User::create([
        'name'               => $data['name'],
        'email'              => $data['email'],
        'password'           => bcrypt($data['password']),
        'verification_token' => str_random(30),
        'avatar'             => $path,
    ]);
}

    /**
     * Upload user avatar.
     *
     * @param resource $avatar
     * @return string path
     */
    protected function avatarUpload($avatar)
    {
        return $avatar->store('avatars', 'public');
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
            'name'                  => $socialUser->name,
            'email'                 => $socialUser->email,
            'password'              => bcrypt($socialUser->id),
            'social_id'             => $socialUser->id,
            'avatar'                => $socialUser->avatar,
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

        //$this->guard()->login($user);
        alert()->info('Info', 'Thanks for signing up! Please check your email.');

        return redirect('/');
    }

    /**
     * Verify registered user with token.
     *
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->first();
        if (! $user) {
            alert()->error('Error!', 'Token invalid and verification failed.');
            return redirect('/');
        }
        //Verify user
        $user->verified = 1;
        $user->verification_token = null;
        $user->save();
        //response
        alert()->success('Success', 'You have successfully verified your account.');
        return redirect()->route('login');
    }

}
