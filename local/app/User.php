<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function hasAnyRole($roles){
      if( is_array( $roles ) ){
        foreach($roles as $role){
          if( $this->hasRole($role) ){
            return true;
          }
        }
      }else{
        if( $this->hasRole($role) ){
          return true;
        }
      }
      return false;
    }

    public function roles()
    {
      return $this->hasMany('App\UamRole');
    }

    public function hasRole($role)
    {
      if( $this->roles()->where( 'access_name', $role )->first() ){
        return true;
      }
      return false;
    }


    public function userProviders(){
      return $this->hasMany('App\UserProviders');
    }
}
