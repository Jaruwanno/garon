<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $fillable = [
    'zone_id', 'headline', 'des'
  ];

  public function zone()
  {
    return $this->belongsTo('App\Zone');
  }

  public function visit()
  {
      return $this->hasMany('App\Visitor', 'id');
  }
}
