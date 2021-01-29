<?php

namespace App\Http\Controllers;

use App\LocationVisit;
use App\Order;
use App\Package;
use App\Restaurant;
use App\User;
use Carbon\Carbon;
use function foo\func;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function __construct()
    {
        // $this->middleware('corsPackage');
         $this->middleware('cors');
    }
    
    public function login(Request $request)
    {
        $http = new Client();
        try{
            // change this to base url
            $response = $http->post('https://dashboard.toffeetribe.com/oauth/token',[
              'form_params' => [
                  'grant_type' => 'password',
                  'client_id' => 2,
                  'client_secret' => '6G1TH0jmGwQnR1y8FcRbhJlUgchIyq4tGQxF2zTL',
                  'username' => $request->get('username'),
                  'password' => $request->get('password'),
              ],

            ]);
            return $response->getBody();
            
           
        }
        catch(BadResponseException $ex)
        {
            if ($ex->getCode() == 400){
                return response()
                    ->json('Invalid Request, Please enter a valid email and password.', $ex->getCode());
            }
            elseif ($ex->getCode() == 401){
                return response()
                    ->json('Invalid Log-In Credentials', $ex->getCode());
            }
            else{
                return response()
                    ->json('Something went wrong on our side, please try again later', $ex->getCode());
            }
        }
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key){
            $token->delete();
        });
        return response()
            ->json('Logged Out Successfully!');
    }

    public function myOrders()
    {
        $array = array();
        $user_id = auth()->user()->id;
        $user = auth()->user();

        if ($user_id == null)
        {
            return response()
                ->json(['message'=>'User is not authenticated', 'status_code'=>404]);
        }

       $orders = Order::where('user_id', '=', $user_id)->with(['user', 'package'])->orderBy('id', 'DESC')->get();

       if ($orders == null){
           return response()
               ->json(['orders'=>'User is yet to make a purchase', 'status_code'=>404]);
       }
       else
           {
               foreach ($orders as $order) {
                   if(Carbon::parse($order->expires_at) < Carbon::now('Africa/Nairobi')){
                       $status = 'EXPIRED';
                   }else{
                       $status = 'ACTIVE';
                   }
                   array_push($array, array(
                       'id'=>$order->id,
                       'order_number'=>$order->order_number,
                       'package'=>$order->package->name,
                       'amount'=>$order->amount,
                       'order_status'=>$status,
                       'date_of_purchase'=>Carbon::parse($order->created_at)->format(' d M Y, h:i'),
                       'date_of_expiry'=>Carbon::parse($order->expires_at)->format(' d M Y, h:i'),
                       ));
               }
           return response()
               ->json([
               'status_code'=>200,
               'user'=>$user->full_name,
               'email'=>$user->email,
               'phone_number'=>$user->phone_number,
               'orders' => $array,
           ]);
       }
    }

    public function checkOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $order = Order::where('order_number', '=', $request->get('order_number'))->with(['user', 'package'])->first();
        if ($order == null)
        {
            return response()
                ->json([
                'order' => "No Order found",
                'message' => "No order found with that order number",
                'status_code'=>404
            ]);
        }
        elseif(Carbon::parse($order->expires_at) < Carbon::now('Africa/Nairobi'))
        {
            return response()
                ->json([
                'status_code'=>200,
                'message' => 'This Subscription has expired',
                'order_details'=>[
                    'user_name' =>$order->user->full_name,
                    'email' =>$order->user->email,
                    'order_number' => $order->order_number,
                    'package' => $order->package->name,
                    'order_status'=>'EXPIRED',
                    'date_of_purchase' => Carbon::parse($order->created_at)->format('d M Y, h:i'),
                    'date_of_expiry' =>Carbon::parse($order->expires_at)->format('d M Y, h:i'),
                    ],
            ]);
        }else{
            return response()
                ->json([
                'status_code'=>200,
                'message' => 'This Subscription has active',
                'order_details'=>[
                    'user_name' =>$order->user->full_name,
                    'email' =>$order->user->email,
                    'order_number' => $order->order_number,
                    'package' => $order->package->name,
                    'order_status'=>'ACTIVE',
                    'date_of_purchase' => Carbon::parse($order->created_at)->format('d M Y, h:i'),
                    'date_of_expiry' =>Carbon::parse($order->expires_at)->format('d M Y, h:i'),
                ],
            ]);
        }
    }

    public function userCheckIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $user = auth()->user();
        $subscription = Order::where('user_id', '=', $user->id)->where('expires_at', '>',Carbon::now())->first();
        if ($subscription != null){
            $current_package = Package::where('id', $subscription->package_id)->first();
            if($subscription->package_id == 1){
                $visit_today = LocationVisit::where('order_id','=', $subscription->id)->whereDate('arrival_time', '=', Carbon::now())->first();
                if($visit_today){
                    return response()
            ->json([
                'status_code'=>200,
                'message' => "Sorry, Your Day Pass Subscription is limited to one location visit per day",
            ]);
                }
            }
            $location = Restaurant::find($request->get('location'));
            if ($location == null){
                return response()
                    ->json([
                        'status_code'=>404,
                        'restaurant' => "No Restaurant Matched with your request",
                        'message' => "No Restaurant Matched with your request",
                    ]);
            }
            else
                {
                     if($location->tribe_capacity > 0){
                        $cap = $location->tribe_capacity;
                        $cap = $cap - 1 ;
                        $location->tribe_capacity = $cap;
                        $location->save();
                    }

                    $visit = new LocationVisit();
                    $visit->restaurant_id = $location->id;
                    $visit->user_id = auth()->user()->id;
                    $visit->order_id = $subscription->id;
                    $visit->order_number = $subscription->order_number;
                    $visit->approved_by = auth()->user()->id;
                    $visit->arrival_time = Carbon::now();
                    $visit->departure_time = null;
                    $visit->save();

                    return response()
                        ->json([
                        'status_code'=>200,
                        'restaurant' => $location->restaurant_name,
                        'message' => "Successfully checked-in to ".$location->restaurant_name,
                    ]);
                }

        }else
            {
            return response()
            ->json([
                'status_code'=>200,
                'message' => "Sorry, You do not have an active subscription",
            ]);
        }
    }

    public function myVisits()
    {
        $user = auth()->user();
        $array =array();
        $visits = LocationVisit::where('user_id', '=', $user->id)->orderBy('id', 'DESC')->get();
        if ($visits != null)
        {
            foreach ($visits as $visit){
                array_push($array, array(
                    'id'=>$visit->id,
                    'location'=>$visit->restaurant->restaurant_name,
                    'order_number'=>$visit->order->order_number,
                    'package'=>$visit->order->package->name,
                    'check_in_date'=>Carbon::parse($visit->arrival_time)->format('d M Y, h:i'),
                ));
            }
            return response()
                ->json([
                'status_code'=>200,
                'visit_details'=>$array,
            ]);

        }
        elseif($visits == null)
            {
                return response()
                    ->json([
                    'status_code'=>404,
                    'message' => "Sorry, You are yet to check yourself in at any of our locations",
                ]);
            }
        else{
            return response()
                ->json([
                'status_code'=>404,
                'message' => "Sorry, something went wrong.",
            ]);
        }
    }

    public function index()
    {
        $orders = Order::all();
        $users = User::select('id','full_name','email')->get();
        $packages = Package::select('id', 'name')->get();

        return response()
            ->json([
            'orders' => $orders,
            'users' => $users,
            'packages' => $packages,
        ]);
    }
    
    
    public function reset_capacities(){
        $karel = Restaurant::find(1);
        $karel->tribe_capacity = 15;
        $karel->save();

        $lava = Restaurant::find(2);
        $lava->tribe_capacity = 10;
        $lava->save();

        $zion = Restaurant::find(3);
        $zion->tribe_capacity = 6;
        $zion->save();

        $connect = Restaurant::find(6);
        $connect->tribe_capacity = 5;
        $connect->save();

        $chez = Restaurant::find(10);
        $chez->tribe_capacity = 10;
        $chez->save();
    }
}
