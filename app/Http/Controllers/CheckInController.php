<?php

namespace App\Http\Controllers;

use App\LocationVisit;
use App\Order;
use App\PaypalPayment;
use App\Restaurant;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->first();
        return view('Hosts.check-in-users', compact('location'));
    }

    public function find_order(Request $request, $slug)
    {
        $order = Order::where('order_number', '=', $request->get('order_number'))->first();
        $location = Restaurant::where('slug', '=', $slug)->first();
        if (!$order){
            return redirect()->back()->with('error', 'No Record Found, with that order number');
        }else{
            return redirect()->route('host.checkIn.user', ['slug'=>$location->slug,'orderId'=>$order->order_number]);
        }
    }

    public function checkinUser($slug, $orderId){
        $location = Restaurant::where('slug', '=', $slug)->first();
        $order = Order::where('order_number', '=', $orderId)->first();
        $paypal = PaypalPayment::where('order_id', '=',$order->order_number)->first();
        $user = User::where('id', '=', $order->user_id)->first();

        return view('Hosts.check-in-user', compact('paypal', 'user', 'order','location'));
    }

    public function record_visit(Request $request)
    {
        $order = Order::find($request->get('order_id'));

        if (Carbon::parse($order->expires_at) < Carbon::now()){
            return redirect()->back()->with('error', 'User cannot be checked in as the given subscription has expired');
        }
        $location = Restaurant::where('id', '=', $request->get('restaurant_id'))->first();

        DB::table('restaurants')
            ->where('id', '=', $request->get('restaurant_id'))
            ->decrement('tribe_capacity', 1);

        $visit = new LocationVisit();
        $visit->restaurant_id = $request->get('restaurant_id');
        $visit->user_id = $request->get('user_id');
        $visit->order_id = $request->get('order_id');
        $visit->order_number = $request->get('order_number');
        $visit->approved_by = Auth::user()->id;
        $visit->arrival_time = Carbon::now();
        $visit->departure_time = null;
        $visit->save();

       if ($visit->save()){
           return redirect()->route('host.list.visitors',['slug'=>$location->slug])->with('success', 'User has been checked-in successfully');
       }else{
           return redirect()->back()->with('error', 'Something Went Wrong!');
       }
    }

    public function list_visitors($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->first();
        $visits = LocationVisit::where('restaurant_id', '=', $location->id)->orderBy('id', 'desc')->get();
        $visits_today = LocationVisit::where('restaurant_id', '=', $location->id)->whereDate('arrival_time', '=', Carbon::now())->get();

        return view('Admin.Restaurants.list-visitors', compact('location', 'visits', 'visits_today'));

    }

    public function checkout($id, $slug)
    {
        $visit = LocationVisit::where('id', '=', $id)->first();
        $visit->update([
            'departure_time'=>Carbon::now(),
        ]);

        DB::table('restaurants')
            ->where('slug', '=', $slug)
            ->increment('tribe_capacity', 1);

        return redirect()->back()->with('info', 'Visitor has been checked-out');
    }
}
