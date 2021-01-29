<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['user_id', 'location', 'grind', 'info_source'];

    public function user(){
        return $this->belongsTo('App/User');
    }
}
