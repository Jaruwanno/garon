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
    |
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
    protected $redirectTo = '/admin';

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
        return Socialite::driver('facebook')->redirect();
    }
    public function handleProviderCallback(){
        try{
          $fbProviders = Socialite::driver('facebook')->user();
        }catch(\Exception $e){
          return redirect('/');
        }
        // dd($fbProviders->getAvatar());
        // $socialUser = SocialUsers::where('provider_id', $socialProviders->getId())
        //                               ->first();
        $user = new User;
        $user->name = $fbProviders->getName();
        $user->email = $fbProviders->getEmail();
        $user->password = bcrypt('abc456');
        $user->provider_id = $fbProviders->getId();
        $user->provider = 'facebook';
        $user->avatar_url = $fbProviders->getAvatar();
        $user->type = 'user';
        $user->save();
        Auth::login($user);
        return redirect('/');
    }
}
