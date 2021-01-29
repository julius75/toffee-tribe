<?php

namespace App;

use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable /*implements MustVerifyEmail*/
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'parent_id', 'username', 'email','phone_number' , 'invite_code', 'password', 'location', 'grind', 'info_source'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($identifier) {
        return $this->orWhere('email', $identifier)->orWhere('username', $identifier)->first();
}

    public function user_profile(){
        return $this->hasOne('App\UserProfile');
    }

    public function promocode(){
        return $this->hasOne('App\PromoCode');
    }

    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function hasRole($role){
        $roles = $this->roles()->where('name', $role)->count();
        if ($roles == 1){
            return true;
        }
        return false;
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function event()
    {
        return $this->hasMany('App\Event');
    }

    public function orderevent()
    {
        return $this->hasMany('App\OrderEvent');
    }

    public function paypalpayment()
    {
        return $this->hasMany(PaypalPayment::class, 'user_id');
    }

    public function visits()
    {
        return $this->hasMany(LocationVisit::class, 'user_id');
    }

}
