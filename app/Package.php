<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 'slug','period', 'details', 'discounted_amount', 'amount',
    ];

    public function order(){
        return $this->hasMany(Order::class);
    }
}
