<?php

namespace App\Http\Controllers;

use App\Event;
use App\LocationVisit;
use App\MpesaPayment;
use App\Order;
use App\PaidInstallment;
use App\PaypalPayment;
use App\Restaurant;
use App\User;
use Carbon\Carbon;
use App\Jobs\OrderEmail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function usersData()
    {
        $type = User::all();


        return Datatables::of($type)
            ->editColumn('full_name', function ($type) {
                return $type->full_name;
            })
            ->editColumn('email', function ($type) {
                return $type->email;
            })

            ->editColumn('username', function ($type) {
                return $type->username;
            })
            ->editColumn('phone_number', function ($type) {
                return $type->phone_number;
            })
            ->editColumn('date_registered', function ($type) {
                return $type->created_at;
            })
            ->addColumn('action', function ($type) {
                $data = $type->id;
                //return '<a href="'.route('events.edit',['id' => $events->id]).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                return '<div class="dropdown">
                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog" style="color: white"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="'. route('view.user',['username'=>$type->username]) . '" style="text-align: center"><i class="fas fa-info-circle" style="color: blue"></i> View</a>

                              </div>
                        </div>';
            })
            ->make(true);

    }

    public function manageUsersData()
    {
        $type = User::all();

        return Datatables::of($type)
            ->editColumn('full_name', function ($type) {
                return $type->full_name;
            })
            ->editColumn('email', function ($type) {
                return $type->email;
            })

            ->editColumn('username', function ($type) {
                return $type->username;
            })
            ->editColumn('phone_number', function ($type) {
                return $type->phone_number;
            })
            ->editColumn('date_registered', function ($type) {
                return $type->created_at;
            })
            ->editColumn('role', function ($type) {
                if ($type->hasRole('admin')){
                    return "Admin";
                }elseif($type->hasRole('host')){
                    return "Host";
                }else{
                    return"Normal User";
                }
            })
            ->addColumn('action', function ($type) {
                $data = $type->id;
                return '<div class="dropdown">
                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog" style="color: white"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="'. route('view.user',['username'=>$type->username]) . '" style="text-align: center"><i class="fas fa-info-circle" style="color: blue"></i> View User</a>

                                <a class="dropdown-item" href="'. route('make.admin',['id'=>$type->id]) . '" style="text-align: center"><i class="fas fa-user" style="color: #ffed4a"></i> Make Admin</a>
                                <a class="dropdown-item" href="'. route('remove.admin',['id'=>$type->id]) . '" style="text-align: center"><i class="fas fa-stop" style="color: firebrick"></i> Remove Admin</a>
                                <a class="dropdown-item" href="'. route('make.host',['id'=>$type->id]) . '" style="text-align: center"><i class="fas fa-user" style="color: #4aa0e6"></i> Make Host</a>
                                <a class="dropdown-item" href="'. route('remove.host',['id'=>$type->id]) . '" style="text-align: center"><i class="fas fa-stop" style="color: firebrick"></i> Remove Host</a>

                              </div>
                        </div>';
            })
            ->make(true);

    }

    public function ordersData()
    {
        $type = Order::all();

        return Datatables::of($type)
            ->editColumn('order_number', function ($type) {
                return $type->order_number;
            })
            ->editColumn('user', function ($type) {
                return $type->user->full_name;
            })
            ->editColumn('package', function ($type) {
                return $type->package->name;
            })
            ->editColumn('amount', function ($type) {
                return $type->amount;
            })
            ->editColumn('created_at', function ($type) {
                return Carbon::parse($type->created_at)->format('d M Y h:i');
            })
            ->editColumn('expires_at', function ($type) {
                return Carbon::parse($type->expires_at)->format('d M Y h:i');
            })
            ->editColumn('status', function ($type) {
                if(Carbon::now()>= Carbon::parse($type->expires_at)){
                    return '<h6><span class="badge badge-danger">EXPIRED</span></h6>';
                }else{
                   return '<h6><span class="badge badge-success">ACTIVE</span></h6>';
                }
            })
            ->addColumn('action', function ($type) {
                $data = $type->order_number;
                return '<a class="btn btn-warning btn-sm" href="'.route('view.order', ['orderId'=>$data]).'">View Details</a>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);

    }
    public function ordersEventData()
    {
        $type = Event::all();

        return Datatables::of($type)
            ->editColumn('order_number', function ($type) {
                return $type->order_number;
            })
            ->editColumn('user', function ($type) {
                return $type->user->full_name;
            })
            ->editColumn('amount', function ($type) {
                return $type->amount;
            })
            ->editColumn('created_at', function ($type) {
                return Carbon::parse($type->created_at)->format('d M Y h:i');
            })
            ->editColumn('expires_at', function ($type) {
                return Carbon::parse($type->expires_at)->format('d M Y h:i');
            })
            ->editColumn('status', function ($type) {
                if(Carbon::now()>= Carbon::parse($type->expires_at)){
                    return '<h6><span class="badge badge-danger">EXPIRED</span></h6>';
                }else{
                    return '<h6><span class="badge badge-success">ACTIVE</span></h6>';
                }
            })
            ->addColumn('action', function ($type) {
                $data = $type->order_number;
                return '<a class="btn btn-warning btn-sm" href="'.route('view.order', ['orderId'=>$data]).'">View Details</a>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);

    }

    public function locationsData()
    {
        $type = Restaurant::all();
// <a class="dropdown-item" href="'.route('checkIn.index',['slug'=>$type->slug]).'" style="text-align: center"><i class="fas fa-briefcase" style="color: saddlebrown"></i> Check-In Users</a>
        return Datatables::of($type)
            ->addColumn('main_image', function ($type) {
                return '<div><img src="'.asset('storage/app/location-images/'.$type->image).'" style= "object-fit: fill;  object-position: center;  height: 100px;  width: 200px;" alt="image could not load"></div>';
            })
            ->editColumn('restaurant_name', function ($type) {
                return $type->restaurant_name;
            })
            ->editColumn('location', function ($type) {
                return $type->location;
            })
            ->editColumn('available_seats', function ($type) {
                return $type->tribe_capacity;
            })
            ->editColumn('host', function ($type) {
                return '-' . $type->host_name . '<br>' . '-' .$type->phone_number;
            })
            ->editColumn('created_at', function ($type) {
                return Carbon::parse($type->created_at)->format('d M Y h:i');
            })
            ->addColumn('status', function ($type) {
                if($type->status == 1){
                    return '<b>Active</b><br>
                     <a class="btn btn-danger btn-sm" href="'.route('deactivate',['slug'=>$type->slug]).'"><small>Deactivate</small></a>';
                }else{
                    return '<b>Inactive</b><br>
                     <a class="btn btn-success btn-sm" href="'.route('activate',['slug'=>$type->slug]).'"><small>Activate</small></a>';
                }
            })
            ->addColumn('open_close', function ($type) {
                if($type->set_closed == 1){
                    return '<b style="color: red">Closed</b><br>
                     <a class="btn btn-danger btn-sm" href="'.route('opened',['slug'=>$type->slug]).'"><small>Open</small></a>';
                }else{
                    return '<b>Open</b><br>
                     <a class="btn btn-success btn-sm" href="'.route('closed',['slug'=>$type->slug]).'"><small>Close</small></a>';
                }
            })
            ->addColumn('action', function ($type) {
                $data = $type->slug;
                return '<div class="dropdown">
                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog" style="color: white"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="'. route('admin.view.location',['slug'=>$data]) . '" style="text-align: center"><i class="fas fa-info-circle" style="color: navy"></i> View in Detail</a>
                                <a class="dropdown-item" href="'. route('get.assign.host',['slug'=>$data]) . '" style="text-align: center"><i class="fas fa-user-check" style="color: #dda20a"></i> Assign Host</a>
                                <a class="dropdown-item" href="'. route('edit.location',['slug'=>$data]) . '" style="text-align: center"><i class="fas fa-edit" style="color: grey"></i> Edit Location Info</a>
                                <a class="dropdown-item" href="'. route('edit.slider.images',['slug'=>$type->slug]).'" style="text-align: center"><i class="fas fa-camera" style="color: #1b4b72"></i> Edit Slider Images</a>
                                <a class="dropdown-item" href="'.route('edit.host.map',['slug'=>$type->slug]).'" style="text-align: center"><i class="fas fa-map" style="color: red"></i> Edit Map Details</a>
                                <a class="dropdown-item" href="'.route('get.days.available',['slug'=>$type->slug]).'" style="text-align: center"><i class="fas fa-clock" style="color: #1c606a"></i> Edit Days Available</a>
                                <a class="dropdown-item" href="'.route('list.visitors',['slug'=>$type->slug]).'" style="text-align: center"><i class="fas fa-user-friends" style="color: skyblue"></i> List Visits</a>
                              </div>
                        </div>';
            })
            ->rawColumns(['status','main_image', 'host','open_close','action'])
            ->make(true);

    }
    public function eventsData()
    {
        $type = Event::all();
        return Datatables::of($type)
            ->addColumn('image', function ($type) {
                return '<div><img src="'.asset('storage/app/location-images/'.$type->image).'" style= "object-fit: fill;  object-position: center;  height: 100px;  width: 200px;" alt="image could not load"></div>';
            })
            ->editColumn('name', function ($type) {
                return $type->name;
            })
            ->editColumn('location', function ($type) {
                return $type->location;
            })

            ->editColumn('date', function ($type) {
                return Carbon::parse($type->date)->format('d M Y');
            })
            ->addColumn('status', function ($type) {
                if($type->status == 1){
                    return '<b><span class="badge badge-success">Active</span></b><br>
                    ';
                }else{
                    return '<b><span class="badge badge-danger">Inactive</span></b><br>';
                }
            })
            ->editColumn('starting_time', function ($type) {
                return Carbon::parse($type->starting_time)->format('h:i A');
            })
            ->editColumn('ending_time', function ($type) {
                return Carbon::parse($type->ending_time)->format('h:i A');
            })
            ->addColumn('action', function ($type) {
                $data = $type->slug;
                return '<div class="dropdown">
                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog" style="color: white"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="'.route('admin.view.event',['id'=>$type->slug]).'" style="text-align: center"><i class="fas fa-map" style="color: red"></i> View Event Details</a>
                                <a class="dropdown-item" href="'. route('edit.events',['id'=>$type->slug]) . '" style="text-align: center"><i class="fas fa-edit" style="color: grey"></i> Edit Event Info</a>
                                <a class="dropdown-item" href="'.route('get.days.available',['id'=>$type->slug]).'" style="text-align: center"><i class="fas fa-clock" style="color: #1c606a"></i> Delete Event</a>
                              </div>
                        </div>';
            })
            ->rawColumns(['status','image', 'location','date','action'])
            ->make(true);

    }

    public function paypalData()
    {
        $type = PaypalPayment::all();

        return Datatables::of($type)
            ->editColumn('user', function ($type) {
                return $type->user->full_name;
            })
            ->editColumn('order_id', function ($type) {
                return $type->order_id;
            })
            ->editColumn('package', function ($type) {
                return $type->package->name;
            })
            ->editColumn('txn_id', function ($type) {
                return $type->txn_id;
            })
            ->editColumn('payment_gross', function ($type) {
                return $type->payment_gross;
            })
            ->editColumn('payer_id', function ($type) {
                return $type->payer_id;
            })
            ->editColumn('payer_name', function ($type) {
                return $type->payer_name;
            })
            ->editColumn('payment_status', function ($type) {
                if($type->payment_status == "approved"){
                    return '<h6><span class="badge badge-success">APPROVED</span></h6>';
                }else{
                    return '<h6><span class="badge badge-danger">FAILED</span></h6>';
                }
            })
            ->editColumn('created_at', function ($type) {
                return Carbon::parse($type->created_at)->format('d M Y h:i');
            })
            ->rawColumns(['payment_status', 'action'])
            ->make(true);

    }

    public function mpesaData()
    {
        $type = MpesaPayment::where('completed', '=', true)->orderBy('id', 'desc')->get();

        return Datatables::of($type)
            ->editColumn('user', function ($type) {
                return $type->user->full_name;
            })
            ->editColumn('order_number', function ($type) {
                return $type->order_number;
            })
            ->editColumn('package', function ($type) {
                return $type->package->name;
            })
            ->editColumn('mpesaReceiptNumber', function ($type) {
                return $type->mpesaReceiptNumber;
            })
            ->editColumn('amount', function ($type) {
                return $type->amount;
            })
            ->editColumn('phoneNumber', function ($type) {
                return $type->phoneNumber;
            })
            ->editColumn('status', function ($type) {
                if($type->completed == true){
                    return '<h6><span class="badge badge-success">COMPLETE</span></h6>';
                }else{
                    return '<h6><span class="badge badge-danger">FAILED</span></h6>';
                }
            })
            ->editColumn('transactionDate', function ($type) {
                return Carbon::parse($type->transactionDate)->format('d M Y h:i');
            })
            ->rawColumns(['status'])
            ->make(true);

    }

    public function visitsData($slug){
        $location = Restaurant::where('slug', '=', $slug)->first();
        $type = LocationVisit::where('restaurant_id', '=', $location->id)->orderBy('id', 'desc')->get();

        return Datatables::of($type)
            ->editColumn('order_number', function ($type) {
                return $type->order_number;
            })
            ->editColumn('user', function ($type) {
                return $type->user->full_name;
            })
            ->editColumn('email', function ($type) {
                return $type->user->email;
            })
            ->editColumn('package', function ($type) {
                return $type->order->package->name;
            })
            ->editColumn('arrival_time', function ($type) {
              return Carbon::parse($type->arrival_time)->format('d M Y, h:i');
            })
            ->editColumn('departure', function ($type) {
                if ($type->departure_time == null){
                    return '--';
                }else{
                    return $type->departure_time;
                }
            })
            ->addColumn('action', function ($type) {
                $loc = Restaurant::find($type->restaurant_id);
                if ($type->departure_time == null){
                    return '<a class="btn btn-warning btn-sm" href="'.route('checkout.visitor',['id'=>$type->id, 'slug'=>$loc->slug]).'"><small>Check-Out</small></a>';
                }
                else{
                    return '';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function manual() {
        $users = User::get();
        return view('Admin/Payments/manual-payments', compact('users'));
    }

    public function manualPost(Request $request) {
        $check = MpesaPayment::orderBy('id', 'desc')
            ->where('user_id', $request->id)
            ->where('completed', 0)
            ->first();
        // dd($request->all());
        // dd($check);
        if($check) {
            $check->update([
                'amount' => $request->amount,
                'MpesaReceiptNumber' => $request->transaction_id,
                'completed' => true,
                'created_at' => $request->date_payed
            ]);
            $package = $check->package_id;
            if($package == 1) {
                $days = 1;
            } elseif($package == 2) {
                $days = 7;
            } elseif($package == 3) {
                $days = 31;
            }
            $exp_date = Carbon::now()->addDays($days);
            // dd($exp_date);
            $order = new Order([
                'order_number' => $check->order_number,
                'user_id' => $check->user_id,
                'package_id' => $check->package_id,
                'amount' => $request->amount,
                'expires_at' => $exp_date
            ]);
            $order->save();
            dispatch(new OrderEmail($order));
            return redirect()->back()->with('success', 'Payment added successfully!');
        } else {
            return redirect()->back()->with('error', 'No failed transactions for this user!');
        }
    }

}
