<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationVisit extends Model
{
    protected $fillable = ['restaurant_id', 'user_id', 'order_number', 'approved_by', 'arrival_time', 'departure_time'];
    public $timestamps = false;

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
