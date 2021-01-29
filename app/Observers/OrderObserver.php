<?php

namespace App\Observers;

use App\Order;
use App\PromoCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class OrderObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        if(Session::has('promo_code')){
            $user = Session::get('user_details');
            $invite_code = Session::get('promo_code');

            $promo_code = PromoCode::find($invite_code->id);
            $promo_code->order_id = $order->id;
            $promo_code->user_id = $user->id;
            $promo_code->used_at = Carbon::now();
            $promo_code->status = 0;
            $promo_code->save();
            Session::forget('promo_code');
            Session::forget('user_details');
        }
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
