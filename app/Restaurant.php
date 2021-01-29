<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'restaurant_name', 'slug', 'image','social_link', 'location', 'location_link','street', 'total_capacity','tribe_capacity' , 'day_available', 'opening_time', 'closing_time', 'amenities', 'food_beverage', 'host_name', 'host_role', 'phone_number','info_source'
    ];

    public function restaurantimage(){
        return $this->hasMany('App\RestaurantImage');
    }

    public function map(){
        return $this->hasOne(Map::class);
    }
    public function days(){
        return $this->hasMany('App\Day');
    }
    public function visits(){
        return $this->hasMany(LocationVisit::class);
    }
}