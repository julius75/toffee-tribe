<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = ['restaurant_id','iframe'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
