<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProviders extends Model 
{
    protected $fillable = [
      'user_id', 'avatar_url', 'provider_id', 'provider'
    ];
}
