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

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try{
          $fbProviders = Socialite::driver('facebook')->user();
        }catch(\Exception $e){
          return redirect('/');
        }

        dd($fbProviders);
        // $socialUser = SocialUsers::where('provider_id', $socialProviders->getId())
        //                               ->first();

        // if(!$socialUser){
        //   $user = new SocialUsers;
        //   $user->name = $socialProviders->getName();
        //   $user->email = $socialProviders->getEmail();
        //   // $user->password = ;
        //   $user->save();
        // }
        //
        // auth()->login($user);
        // return redirect('/');
    }
}
