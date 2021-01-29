<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'category','slug','location', 'image','date', 'starting_time', 'ending_time','image_path', 'status','price'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
