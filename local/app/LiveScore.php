<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveScore extends Model
{
    public $timestamps = false;

    protected $fillable = [
      'match_id', 'match_date', 'tded', 'link'
    ];
}
