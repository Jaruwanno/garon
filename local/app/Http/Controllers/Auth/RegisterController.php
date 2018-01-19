<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UamRole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;



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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function index()
    {
      $users = User::all();

      $aScript = array(
        'js/backend/users/js.js'
      );

      return view('backend.register.home', [
        'users' => $users,
        'js' => $aScript
      ]);
    }

    public function assignRoles(Request $request)
    {
      $user = User::find($request->id);
      $user->roles()->delete();

      if( $request['role_user'] ){
        $insertRole = $user->roles()->create([
            'role_name' => 'admin',
            'access_name' => 'users'
        ]);
      }

      if( $request['role_match'] ){
        $insertRole = $user->roles()->create([
            'role_name' => 'admin',
            'access_name' => 'match'
        ]);
      }

      if( $request['role_table'] ){
        $insertRole = $user->roles()->create([
            'role_name' => 'admin',
            'access_name' => 'table'
        ]);
      }

      if( $request['role_category'] ){
        $insertRole = $user->roles()->create([
            'role_name' => 'admin',
            'access_name' => 'category'
        ]);
      }

      if( $request['role_news'] ){
        $insertRole = $user->roles()->create([
            'role_name' => 'admin',
            'access_name' => 'news'
        ]);
      }

      if( $request['role_highlight'] ){
        $insertRole = $user->roles()->create([
            'role_name' => 'admin',
            'access_name' => 'highlight'
        ]);
      }

      if( $request['role_webboard'] ){
        $insertRole = $user->roles()->create([
            'role_name' => 'admin',
            'access_name' => 'webboard'
        ]);
      }

      return redirect()->back();
    }
}
