<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    | https://www.tutsmake.com/laravel-5-facebook-login-with-socialite/
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	public function redirectToProvider(){
		return Socialite::driver('google')->redirect();
	}
	public function handleProviderCallback(){
		$user = Socialite::driver('google')->user();
		$this->createUser($user);
		return redirect()->to('/');
	}
	public function createUser($infoProvider){
		$user = User::create([
			'name' => $infoProvider->name,
			'email' => $infoProvider->email,
			'password' => 'test',
		]);
		return $user;
	}
}
