<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $guarded = [];

    public function restaurants(){
        return $this->hasMany('App\Restaurant', 'restaurant_id');
    }
}
