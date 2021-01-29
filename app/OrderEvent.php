<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderEvent extends Model
{
    protected $fillable = ['order_number','user_id', 'package_id', 'amount', 'expires_at' ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
