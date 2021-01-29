<?php

namespace App\Http\Controllers;

use App\Day;
use App\LocationVisit;
use App\Map;
use App\MpesaPayment;
use App\Order;
use App\PaypalPayment;
use App\Restaurant;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class HostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('host');
    }

    public function host_home()
    {
        $location = Restaurant::where('host_id', '=', Auth::user()->id)->first();
        if ($location){
            //week day
            $weekMap = [
                0 => 'Sunday',
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
            ];
            $dayOfTheWeek = Carbon::now()->dayOfWeek;
            $weekday = $weekMap[$dayOfTheWeek];

            $location_map = Map::where('restaurant_id', '=', $location->id)->firstOrFail();
            $days = Day::where('restaurant_id', '=', $location->id)->get();

            //cards
            $visits['total'] =  $location->visits()->count();
            $visits['month'] = $location->visits()->whereMonth('arrival_time', '=', Carbon::now())->count();
            $visits['week'] = $location->visits()->whereBetween('arrival_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $visits['today'] = $location->visits()->whereDate('arrival_time', '=', Carbon::now())->count();

            return view('Hosts.host-home', compact('days','location', 'weekday', 'location_map', 'visits'));
        }
        else{
            return redirect()->to('/member_dashboard')->with('error', 'You are yet to be assigned a location to manage, kindly contact Admin for assistance.');
        }
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

    public function checkinUser($slug, $orderId)
    {
        $location = Restaurant::where('slug', '=', $slug)->first();
        $order = Order::where('order_number', '=', $orderId)->first();
        $paypal = PaypalPayment::where('order_id', '=',$order->order_number)->first();
        $mpesa = MpesaPayment::where('order_number', '=', $order->order_number)->first();
        $user = User::where('id', '=', $order->user_id)->first();
        return view('Hosts.check-in-user', compact('paypal', 'user', 'order','location', 'mpesa'));
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
            return redirect()->route('host.home')->with('success', 'User has been checked-in successfully');
        }else{
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }
    }

    public function monthly_visits($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->first();
        //visits chart
        $visits_dates = $location->visits()->whereMonth('arrival_time', Carbon::now())->whereYear('arrival_time', Carbon::now())->orderBy('arrival_time', 'ASC')->pluck('arrival_time');
        $month_array = array();
        $visits_dates = json_decode($visits_dates);

        if (!empty($visits_dates)) {
            foreach ($visits_dates as $unformatted_date) {
                $date = new \DateTime($unformatted_date);
                $day = $date->format('d');
                $month_name = $date->format('d-M');
                $month_array[$day] = $month_name;
            }
        }
        $monthly_visit_count_array = array();
        $month_name_array = array();
        if (!empty($month_array)) {
            foreach ($month_array as $day => $month_name) {
                if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('host')) {
                    $monthly_visit_count = $location->visits()->whereDay('arrival_time', $day)->whereMonth('arrival_time', Carbon::now())->whereYear('arrival_time', Carbon::now())->count();
                    array_push($monthly_visit_count_array, $monthly_visit_count);
                    array_push($month_name_array, $month_name);
                }
            }
            if (!empty($monthly_visit_count_array)) {
                $max_visit_no = max($monthly_visit_count_array);
                $max_visits = round(($max_visit_no + 10 / 2) / 10) * 10;
            } else {
                $max_visit_no = 0;
                $max_visits = 0;
            }


            $monthly_loan_data_array = array(
                'month' => $month_name_array,
                'visit_count_data' => $monthly_visit_count_array,
                'max_visits' => $max_visits,
            );

            $month_array = json_encode($monthly_loan_data_array);
        }

//        //frequent visitors
//        $guests = User::whereHas('visits', function ($q) use($location) {
//            $q->where('restaurant_id', '=', $location->id);
//        })->get();
//        $top_visitors = [];
//        foreach ($guests as $guest){
//            $count = $guest->visits()->where('restaurant_id', '=', $location->id)->count();
//            array_push($top_visitors, [$guest->full_name => $count]);
//        }
//        asort($top_visitors);
//        dd($top_visitors);

        return view('Hosts.list-visitors', compact('month_array'));
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

    public function visits_data()
    {
        $location = Restaurant::where('host_id', '=', Auth::user()->id)->first();
        $type = LocationVisit::where('restaurant_id', '=', $location->id)->orderBy('id', 'desc')->get();

        return DataTables::of($type)
            ->editColumn('order_number', function ($type) {
                return $type->order_number.'<br>'.'- '.$type->order->package->name;
            })
            ->editColumn('user', function ($type) {
                return '- ' . $type->user->full_name .'<br>'.'- '.$type->user->email;
            })
            ->editColumn('package', function ($type) {
                return $type->order->package->name;
            })
            ->editColumn('arrival_time', function ($type) {
                return Carbon::parse($type->arrival_time)->format('d-m-Y, H:i');
            })
            ->editColumn('departure', function ($type) {
                if ($type->departure_time == null){
                    return '--';
                }else{
                    return Carbon::parse($type->departure_time)->format('d-m-Y, H:i');
                }
            })
            ->addColumn('action', function ($type) {
                $loc = Restaurant::find($type->restaurant_id);
                if ($type->departure_time == null){
                    return '<a class="btn btn-warning btn-sm" href="'.route('host.checkout.visitor',['id'=>$type->id, 'slug'=>$loc->slug]).'"><small>Check-Out</small></a>';
                }
                else{
                    return '';
                }
            })
            ->rawColumns(['order_number','user','action'])
            ->make(true);
    }
}
