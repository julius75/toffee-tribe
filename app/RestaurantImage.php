<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantImage extends Model
{
    protected $fillable = ['restaurant_id', 'image', 'size'];

    public function restaurant(){
        return $this->belongsTo('App\Restaurant');
    }
}
