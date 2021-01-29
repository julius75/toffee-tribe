<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_number','user_id', 'package_id', 'amount', 'expires_at' ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function package(){
        return $this->belongsTo(Package::class);
    }

    public function promocode(){
        return $this->hasOne(PromoCode::class);
    }
}
