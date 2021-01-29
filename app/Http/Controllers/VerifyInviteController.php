<?php

namespace App\Http\Controllers;

use App\Day;
use App\Event;
use App\Invitation;
use App\Jobs\MPesaOrderEmail;
use App\Jobs\OrderEmail;
use App\Map;
use App\MpesaPayment;
use App\Order;
use App\Package;
use App\PaypalPayment;
use App\PromoCode;
use App\Restaurant;
use App\RestaurantImage;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class VerifyInviteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

//    public function verify_form(){
//        return view('Users.verify-invite-code');
//    }
    public function convertCurrency($amount,$from_currency,$to_currency){
        $apikey = '6eda332db987f102aafd';

        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}", false, stream_context_create($arrContextOptions));
        $obj = json_decode($json, true);

        $val = floatval($obj["$query"]);


        $total = $val * $amount;
        //return number_format($total, 2, '.', '');
        return (int)$total;

    }

    public function admin_home(){

        $users = User::orderBy('id', 'asc')->with('roles')->get();
        $locations = Restaurant::orderBy('id', 'asc')->limit(10)->get();
        $active_locations = Restaurant::where('status', '=', 1)->get();
        $inactive_locations = Restaurant::where('status', '=', 0)->get();
        $packages = Package::orderBy('id', 'asc')->get();
        $orders = Order::orderBy('id', 'asc')->get();
        $revenue = PaypalPayment::sum('payment_gross');
        $mpesarevenue = MpesaPayment::sum('amount');
        try{
            $rate = $this->convertCurrency('USD', 'KES', 1);
            $converted_rev = $this->convertCurrency('USD', 'KES', $revenue);
        }
        catch(\Exception $exception)
        {
            $rate = 101.49;
            $converted_rev = $revenue * $rate;
        }


        $day_pass = Order::where('package_id', '=', 1)->get();
        $weekly_pass = Order::where('package_id', '=', 2)->get();
        $monthly_pass = Order::where('package_id', '=', 3)->get();
        $orders_count = Order::all()->count();
        $day_pass = round(count($day_pass)/$orders_count,4)*100;
        $weekly_pass = round(count($weekly_pass)/$orders_count, 4)*100;
        $monthly_pass = round(count($monthly_pass)/$orders_count, 4)*100;

        $referral = User::where('info_source', '=', "Referral / Word of Mouth")->get(); $referral = count($referral);
        $google = User::where('info_source', '=', "Google Search")->get(); $google = count($google);
        $press = User::where('info_source', '=', "Press")->get(); $press = count($press);
        $ads = User::where('info_source', '=', "Online Ads")->get(); $ads = count($ads);
        $socials = User::where('info_source', '=', "Social Media")->get(); $socials = count($socials);
        return view('Admin.admin-home', compact('users','revenue','mpesarevenue', 'locations','active_locations','inactive_locations', 'packages', 'orders', 'day_pass', 'weekly_pass', 'monthly_pass', 'google', 'press', 'ads', 'socials', 'referral', 'converted_rev','rate'));
    }

    public function list_users()
    {
        $users = User::with('roles')->get();
        return view('Admin.Users.registered', compact('users'));
    }

    function action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = User::with('roles')
                    ->where('full_name', 'like', '%'.$query.'%')
                    ->orWhere('email', 'like', '%'.$query.'%')
                    ->orWhere('phone_number', 'like', '%'.$query.'%')
                    ->orWhere('username', 'like', '%'.$query.'%')
                    ->orWhere('invite_code', 'like', '%'.$query.'%')
                    ->orWhere('id', 'like', '%'.$query.'%')
                    ->orWhere('created_at', 'like', '%'.$query.'%')
                    ->orderBy('id', 'asc')
                    ->get();

            }
            else
            {
                $data = User::with('roles')
                    ->orderBy('id', 'asc')
                    ->get();

            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {

                    $output .= '
        <tr>
         <td>'.$row->id.'</td>
         <td>'.$row->full_name.'</td>
         <td>'.$row->username.'</td>
         <td>'.$row->invite_code.'</td>
         <td>'.$row->email.'</td>
         <td>'.$row->phone_number.'</td>
         <td>'.$row->created_at.'</td>
        </tr>
        ';
                }

            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="7">No Record Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function manage_users()
    {
        $users = User::with('roles')->paginate(20);
        return view('Admin.Users.manage-users', compact('users'));
    }

    public function view_user($username)
    {
        $user = User::where('username', '=', $username)->firstOrFail();
        $orders = Order::where('user_id', '=', $user->id)->get();
        return view('Admin.Users.view-user', compact('user', 'orders'));
    }

    public function list_locations()
    {
        $locations = Restaurant::orderBy('id', 'asc')->paginate(20);
        return view('Admin.Restaurants.registered-restaurants', compact('locations'));
    }
    public function list_events()
    {
        $locations = Restaurant::orderBy('id', 'asc')->paginate(20);
        return view('Admin.Events.registered-events', compact('locations'));
    }

    public function makeAdmin($userId)
    {
        $user = User::where('id', $userId)->firstOrFail();
        if ($user->id == Auth::user()->id){
            return redirect()->back()->with('error','Permission Denied!');
        }
        $role = Role::where('name', 'admin')->firstOrFail();
        if ($user->hasRole('admin')){
            return redirect()->back()->with('info', $user->full_name.' is already an Admin');
        }elseif ($user->hasRole('host')){
            return redirect()->back()->with('info', $user->full_name.' is already a Host, to make this user an Admin, remove host privileges first and try again');
        }
        $user->roles()->attach($role->id);
        return redirect()->back()->with('info', $user->full_name.' has successfully been assigned Admin privileges');
    }

    public function makeHost($userId)
    {
        $user = User::where('id', $userId)->firstOrFail();

        if ($user->id == Auth::user()->id){
            return redirect()->back()->with('error','Permission Denied!');
        }

        $role = Role::where('name', 'host')->firstOrFail();

        if ($user->hasRole('host')){
            return redirect()->back()->with('info', $user->full_name.' is already a Host');
        }elseif ($user->hasRole('admin')){
            return redirect()->back()->with('info', $user->full_name.' is already an Admin, to make this user a Host, remove admin privileges first and try again');
        }

        $user->roles()->attach($role->id);

        return redirect()->back()->with('info', $user->full_name.' has successfully been assigned Host privileges');
    }

    public function removeAdmin($userId)
    {
        $user = User::where('id', $userId)->firstOrFail();
        if ($user->id == Auth::user()->id){
            return redirect()->back()->with('error','Permission Denied!');
        }
        $role = Role::where('name', 'admin')->firstOrFail();
        if (!$user->hasRole('admin')){
            return redirect()->back()->with('info', $user->full_name.' not an Admin');
        }
        $user->roles()->detach($role->id);
        return redirect()->back()->with('info', $user->full_name.' no longer has Admin privileges');
    }

    public function removeHost($userId)
    {
        $user = User::where('id', $userId)->firstOrFail();

        if ($user->id == Auth::user()->id){
            return redirect()->back()->with('error','Permission Denied!');
        }

        $role = Role::where('name', 'host')->firstOrFail();
        if (!$user->hasRole('host')){
            return redirect()->back()->with('info', $user->full_name.' is not a Host');
        }
        $user->roles()->detach($role->id);
        return redirect()->back()->with('info', $user->full_name.' no longer has Host privileges');
    }

    public function verify_invite(Request $request)
    {
        $this->validate($request, [
            'invite_code' => 'required',
        ]);

        $user_code = $request->input('invite_code');
        $invite_code = User::where('invite_code', $user_code)->first();

        Session::put('invitation_code', $invite_code);

        if ($user_code != session('invitation_code')){
            return redirect()->back();
        } else {
           return redirect()->route('verify.sign-up')->with(['invite_code'=>$invite_code]);
        }
    }


/******------------------ADMIN REGISTER USER------------------------*********/
    public function sign_up_form()
    {
       return view('Admin.Users.referral-signup-form');
    }

    public function sign_up(Request $request){
        $this->validate($request, [
            'full_name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:20'],
            'location' => ['nullable', 'max:50'],
            'grind' => ['nullable', 'max:50'],
            'info_source' => ['string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:13', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $full_name = $request->input('full_name');
        $username = $request->input('username');
        $email = $request->input('email');
        $phone_number = $request->input('phone_number');
        $invite_code = strtoupper($username.substr($phone_number, -3));
        $location = $request->input('location');
        $grind = $request->input('grind');
        $info_source= $request->input('info_source');
        $password = Hash::make($request->input('password'));
        $user = new User([
            'full_name' => $full_name,
            'username' => $username,
            'email' => $email,
            'invite_code' => $invite_code,
            'phone_number' => $phone_number,
            'location' => $location,
            'grind' => $grind,
            'info_source' => $info_source,
            'password' => $password,
        ]);
        $user->save();
        return redirect()->route('manage.users')->with('info', 'User Registered Successfully');
    }

    public function get_assign_host($slug){
        $location = Restaurant::where('slug', '=', $slug)->first();

        return view('Admin.Hosts.assign-host', compact('location'));
    }

    public function post_assign_host(Request $request)
    {
        $location = Restaurant::find($request->restaurant_id);
        $user = User::where('email', '=', $request->email)->first();
        if ($user == null){
            return redirect()->back()->withInput()->with('info', 'No user matches with the entered email, please confirm and try again');
        }
        else{
            $location->host_id = $user->id;
            $location->host_name = $user->full_name;
            $location->phone_number = $user->phone_number;
            $location->host_role = $request->role;
            $location->save();
            return redirect()->back()->with('info', 'Host has been successfully assigned!');
        }
    }


/******----------------------------LOCATIONS / RESTAURANTS-----------------------************/
    public function host_signup_form()
    {
        return view('Admin.Restaurants.signup-form');
    }
    public function event_add_form()
    {
        $items = Restaurant::all();
        return view('Admin.Events.event-form',compact('items'));
    }
    public function store_event(Request $request)
    {
      //  dd($request->all());
        $this->validate($request, [
            'name'=>'required|string|max:50',
            'location'=>'required|string|max:50|',
            'date'=>'required|',
            'price'=>'required|',
            'status'=>'required|',
            'category'=>'required|',
            'starting_time'=>'required|',
            'ending_time'=>'required|after:starting_time',
            'description'=>'required|string|max:500',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $event = new Event();
        $name = $request->input('name');
        $event->name = $name;
        $event->slug = str_slug($name, '-');
        $event->location = $request->input('location');
        $event->date = $request->input('date');
        $event->price = $request->input('price');
        $event->starting_time = $request->input('starting_time');
        $event->ending_time = $request->input('ending_time');
        $event->description = $request->input('description');
        $event->category = $request->input('category');

        $event->status = $request->input('status');

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/location-images', $filename);
            $event->image = $filename;
        }
        $event->save();


        Session::put('event', $event);
        Session::put('event_id', $event->id);
        return redirect()->route('list.events')->with('success', 'Events created successfully.');
    }

    public function store_host(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'restaurant_name'=>'required|string|max:50',
            'social_link'=>'required|string|max:50',
            'location_link'=>'required|string|',
            'street'=>'required|string|',
            'location'=>'required|string|max:50|',
            'total_capacity'=>'required|integer|',
            'tribe_capacity'=>'required|integer|',
//            'day_available'=>'required',
//            'opening_time'=>'required|',
//            'closing_time'=>'required|after:opening_time',
//            'host_name'=>'required|string|max:50',
//            'host_role'=>'required|string|max:50',
//            'phone_number'=>'required|',
            'amenities'=>'required|string|max:100',
            'description'=>'required|string|max:500',
            'food_beverage'=>'required|string|max:50',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // if ($validator->fails())
        // {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        $restaurant = new Restaurant();
        $restaurant_name = $request->input('restaurant_name');
        $restaurant->restaurant_name = $restaurant_name;
        $restaurant->slug = str_slug($restaurant_name, '-');
        $restaurant->social_link = $request->input('social_link');
        $restaurant->location = $request->input('location');
        $restaurant->location_link = $request->input('location_link');
        $restaurant->street = $request->input('street');
        $restaurant->total_capacity = $request->input('total_capacity');
        $restaurant->tribe_capacity = $request->input('tribe_capacity');
//        $restaurant->day_available = json_encode($request->input('day_available', true));
//        $restaurant->opening_time = $request->input('opening_time');
//        $restaurant->closing_time = $request->input('closing_time');
//        $restaurant->host_name = $request->input('host_name');
//        $restaurant->host_role = $request->input('host_role');
//        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->amenities = $request->input('amenities');
        $restaurant->description = $request->input('description');
        $restaurant->food_beverage = $request->input('food_beverage');

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/location-images', $filename);
            $restaurant->image = $filename;
        }
        $restaurant->save();

        if ($request->day) {
            $day = count($request->day);
            for ($i = 0; $i < $day; $i++) {
                if (!$dayCreate = Day::create([
                        'restaurant_id' => $restaurant->id,
                        'day_of_week' => $request->day[$i],
                        'opening_time' => $request->open_time[$i],
                        'closing_time' => $request->close_time[$i],
                    ]
                )){
                    DB::rollback();
                    return false;
                }
            }
        }

        Session::put('restaurant', $restaurant);
        Session::put('restaurant_id', $restaurant->id);
        return redirect()->route('host.images')->with('status', 'location created successfully, upload selector images.');
    }

    public function get_days_available($slug)
    {
        $restaurant = Restaurant::where('slug', '=', $slug)->first();
        $days = Day::where('restaurant_id', '=', $restaurant->id)->get();

        return view('Admin.Restaurants.days-available', compact('restaurant', 'days'));
    }

    public function get_day_edit($id)
    {
        $day = Day::where('id', '=', $id)->first();

        return view('Admin.Restaurants.edit-day-available', compact('day'));
    }

    public function day_create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required',
            'day'=>'required',
            'open_time'=>'required',
            'close_time'=>'required|after:open_time',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Oops! Failed to create record.')->withInput();
        }
        $restaurant_id = $request->get('restaurant_id');
        $pp = new Day();
        $pp->restaurant_id = $restaurant_id;
        $pp->day_of_week = $request->day;
        $pp->opening_time = $request->open_time;
        $pp->closing_time = $request->close_time;
        $pp->save();
        if ($pp->save()) {
            return back()->with('success', 'successfully created record');
        }
        return back()->with('error', 'Oops! Failed to create record.');

    }

    public function day_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'open_time'=>'required',
            'close_time'=>'required|after:open_time',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Oops! Failed refresh and try again.')->withInput();
        }
        $id = $request->id;
        $fday = Day::find($id);
        $day = Day::find($id)->update(['opening_time' => $request->open_time,'closing_time'=>$request->close_time ]);

        $restaurant = Restaurant::find($fday->restaurant_id);
        if ($day) {
            return redirect()->route('get.days.available', ['slug'=>$restaurant->slug])->with('success', 'successfully updated record');
        }
        return back()->with('error', 'Oops! Failed to updated record.');
    }

    public function day_delete($id){
        $day = Day::where('id', '=', $id)->firstOrFail();
        $day->delete();
        return redirect()->back()->with('success', 'successfully deleted record');

    }

    public function host_images(){
        $restaurant = Session::get('restaurant');
        $restaurant_id = Session::get('restaurant_id');
        $images = RestaurantImage::where('restaurant_id','=',$restaurant_id)->get();
        return view('Admin.Restaurants.images-upload', compact('restaurant','restaurant_id', 'images'));
    }

    public function store_host_images(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'file' => 'required',
            'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $restaurant =Session::get('restaurant');
        $restaurant_id = $restaurant->id;

        if ($request->hasFile('file')) {
            foreach ($request->file as $file){
                $extension = $file->getClientOriginalExtension();
                $filename = Str::random() . '.' . $extension;
                $filesize = $file->getClientSize();
                $file->move('storage/app/location-images', $filename);
                $restaurantImages = new RestaurantImage();
                $restaurantImages->restaurant_id = $restaurant_id;
                $restaurantImages->image_path = 'storage/app/location-images/' . $filename;
                $restaurantImages->image = $filename;
                $restaurantImages->size = $filesize;
                $restaurantImages->save();
            }
        }
        return redirect()->back();
    }

    public function edit_host_images($slug){
        $restaurant = Restaurant::where('slug', '=', $slug)->firstOrFail();
        $images = RestaurantImage::where('restaurant_id','=',$restaurant->id)->get();
        return view('Admin.Restaurants.edit-slider-images', compact('restaurant','images'));
    }

    public function update_host_images(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'file' => 'required',
            'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $restaurant_id = $request->get('id');

        if ($request->hasFile('file')) {
            foreach ($request->file as $file){
                $extension = $file->getClientOriginalExtension();
                $filename = Str::random() . '.' . $extension;
                $filesize = $file->getClientSize();
                $file->move('storage/app/location-images', $filename);

                $restaurantImages = new RestaurantImage();
                $restaurantImages->restaurant_id = $restaurant_id;
                $restaurantImages->image_path = 'storage/app/location-images/' . $filename;
                $restaurantImages->image = $filename;
                $restaurantImages->size = $filesize;
                $restaurantImages->save();
            }
        }
        return redirect()->back();
    }

    public function delete_host_image($imageUpload)
    {
        $image = RestaurantImage::where('id','=',$imageUpload)->firstOrFail();

        unlink(public_path('storage/app/location-images/'.$image->image));

        $image->delete();

       return redirect()->back();
    }

    public function view_location($slug)
    {
        //
        $location = Restaurant::where('slug', '=', $slug)->firstOrFail();
        $images = RestaurantImage::where('restaurant_id', '=', $location->id)->get();
        $map = Map::where('restaurant_id', '=', $location->id)->firstOrFail();
//        dd($map->iframe);
        $days = json_decode($location->day_available);
        return view('Admin.Restaurants.view-location', compact('location','days','images', 'map'));
    }
    public function view_event($slug)
    {
        $event = Event::where('slug', '=', $slug)->firstOrFail();

        return view('Admin.Events.view-event', compact('event'));
    }

    public function edit_host_form($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->firstOrFail();
        $day_available = json_decode($location->day_available);
        $foodnbev = $location->food_beverage;
//        dd($day_available);

        return view('Admin.Restaurants.edit-restaurants-form', compact('location', 'day_available', 'foodnbev'));
    }
    public function edit_event_form($slug)
    {
        $items = Restaurant::all();
        $event = Event::where('slug', '=', $slug)->firstOrFail();
//        dd($day_available);

        return view('Admin.Events.edit-events-form', compact('event','items'));
    }

    public function update_host(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'restaurant_name'=>'required|string|max:50',
            'social_link'=>'required|string|max:50',
            'location'=>'required|string|max:50',
            'location_link'=>'required|string',
            'street'=>'required|string|',
            'total_capacity'=>'required|integer|',
            'tribe_capacity'=>'required|integer|',
            // 'day_available'=>'required',
            // 'opening_time'=>'required|',
            // 'closing_time'=>'required|after:opening_time',
            // 'host_name'=>'required|string|max:50',
            // 'host_role'=>'required|string|max:50',
            // 'phone_number'=>'required|max:15',
            'amenities'=>'required|string|max:100',
            'description'=>'required|string|max:500',
            'food_beverage'=>'required|string|max:50',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput()->with('info', 'location details failed to update');
        }

        $restaurant = Restaurant::find($request->input('id'));
        $restaurant_name = $request->input('restaurant_name');
        $restaurant->restaurant_name = $restaurant_name;
        $restaurant->slug = str_slug($restaurant_name, '-');
        $restaurant->social_link = $request->input('social_link');
        $restaurant->location_link = $request->input('location_link');
        $restaurant->location = $request->input('location');
        $restaurant->street = $request->input('street');
        $restaurant->total_capacity = $request->input('total_capacity');
        $restaurant->tribe_capacity = $request->input('tribe_capacity');
        // $restaurant->day_available = json_encode($request->input('day_available', true));
        // $restaurant->opening_time = $request->input('opening_time');
        // $restaurant->closing_time = $request->input('closing_time');
        // $restaurant->host_name = $request->input('host_name');
        // $restaurant->host_role = $request->input('host_role');
        // $restaurant->phone_number = $request->input('phone_number');
        $restaurant->amenities = $request->input('amenities');
        $restaurant->description = $request->input('description');
        $restaurant->food_beverage = $request->input('food_beverage');

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/location-images', $filename);
            $restaurant->image = $filename;
        }
        $restaurant->save();

        return redirect()->route('list.locations')->with('info', 'location details updated successfully');
    }
    public function update_event(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:50',
            'location'=>'required|string|max:50|',
            'date'=>'required|',
            'price'=>'required|',
            'status'=>'required|',
            'category'=>'required|',
            'starting_time'=>'required|',
            'ending_time'=>'required|after:starting_time',
            'description'=>'required|string|max:500',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput()->with('info', 'Event details failed to update');
        }

        $event = Event::find($request->input('id'));
        $name = $request->input('name');
        $event->name = $name;
        $event->slug = str_slug($name, '-');
        $event->location = $request->input('location');
        $event->date = $request->input('date');
        $event->price = $request->input('price');
        $event->category = $request->input('category');
        $event->starting_time = $request->input('starting_time');
        $event->ending_time = $request->input('ending_time');
        $event->description = $request->input('description');
        $event->status = $request->input('status');

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/location-images', $filename);
            $event->image = $filename;
        }
        $event->save();

        return redirect()->route('list.events')->with('info', 'Events details updated successfully');
    }

    public function deactivateLocation($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->first();
        $location->status = 0;
        $location->save();
        return redirect()->back()->with('info', 'Location is now inactive therefore not viewable to the users');
    }

    public function closeLocation($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->first();
        $location->set_closed = true;
        $location->save();
        return redirect()->back()->with('info', 'Location has been set as closed');
    }

    public function activateLocation($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->first();
        $location->status = 1;
        $location->save();
        return redirect()->back()->with('info', 'Location is now active therefore viewable to the users');

    }

    public function openLocation($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->first();
        $location->set_closed = false;
        $location->save();
        return redirect()->back()->with('info', 'Location has been set as open');

    }

    public function create_map($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->firstOrFail();
        $map = Map::where('restaurant_id', '=', $location->id)->first();
        return view('Admin.Restaurants.create-map', compact('location', 'map'));
    }

    public function store_map(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required',
            'iframe'=>'required|string|'
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $map = new Map();
        $map->restaurant_id = $request->get('id');
        $map->iframe = $request->get('iframe');
        $map->save();
        return redirect()->route('list.locations')->with('info', 'map location has been saved successfully');
    }

    public function edit_map($slug)
    {
        $location = Restaurant::where('slug', '=', $slug)->firstOrFail();
        $location_map = Map::where('restaurant_id', '=', $location->id)->first();
        return view('Admin.Restaurants.edit-map', compact('location', 'location_map'));
    }

    public function update_map(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required',
            'iframe'=>'required|string|'
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $location_map = Map::find($request->get('id'));
        $encoded_map =$request->get('iframe');
        $location_map->iframe = $encoded_map;
        $location_map->save();
        return redirect()->back()->with('info', 'map location has been updated successfully');
    }

/***-----------------TOFFEE TRIBE PACKAGES-------------------***/
    public function create_package()
    {
        return view('Admin.Packages.create-package');
    }

    public function store_package(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:20',
            'period'=>'required|string|max:20',
            'amount'=>'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'discounted_amount'=>'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'details'=>'required|string|max:200'
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $name = $request->input('name');
        //
        $slug = str_slug($name, '-');
        $period = $request->input('period');
        $amount = $request->input('amount');
        $details = $request->input('details');
        $disc_amount = $request->input('discounted_amount');
        $package = new Package([
            'name' => $name,
            'slug'=> $slug,
            'period' => $period,
            'amount' => $amount,
            'discounted_amount' => $disc_amount,
            'details' => $details,
        ]);
//        dd($package);
        $package->save();
        return redirect()->back();
    }

    public function list_packages()
    {
        $packages = Package::orderBy('id', 'asc')->paginate(20);
        return view('Admin.Packages.listed-packages', compact('packages'));
    }

    public function edit_package($slug)
    {
        $package = Package::where('slug', '=', $slug)->firstOrFail();
        return view('Admin.Packages.edit-package', compact('package'));
    }

    public function update_package(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:20',
            'period'=>'required|string|max:20',
            'amount'=>'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'discounted_amount'=>'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'details'=>'required|string|max:200'
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $package = Package::find($request->get('id'));

        $package->name = $request->get('name');
        $package->period = $request->get('period');
        $package->amount = $request->get('amount');
        $package->discounted_amount = $request->get('discounted_amount');
        $package->details = $request->get('details');
//        dd($package);
        $package->save();
        return redirect()->route('list.packages')->with('info', 'Package Updated Successfully');
    }



    /***-----------------TOFFEE TRIBE PAYPAL PAYMENTS-------------------***/

    public function list_paypalPayments()
    {
        $payments = PaypalPayment::orderBy('id', 'asc')->get();
        return view('Admin.Payments.paypal-payments', compact('payments'));
    }

    public function list_mpesaPayments()
    {
        $payments = MpesaPayment::orderBy('id', 'asc')->get();
        return view('Admin.Payments.mpesa-payments', compact('payments'));
    }

    function pp_action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = PaypalPayment::where('order_id', 'like', '%'.$query.'%')
                    ->orWhere('txn_id', 'like', '%'.$query.'%')
                    ->orWhere('payment_gross', 'like', '%'.$query.'%')
                    ->orWhere('payer_id', 'like', '%'.$query.'%')
                    ->orWhere('payer_name', 'like', '%'.$query.'%')
                    ->orWhere('user_id', 'like', '%'.$query.'%')
                    ->orWhere('package_id', 'like', '%'.$query.'%')
                    ->orWhere('created_at', 'like', '%'.$query.'%')
                    ->orWhereHas('user', function($q) use ($query) {
                        return $q->where('full_name', 'LIKE', '%' . $query . '%');
                    })
                    ->orWhereHas('package', function($q) use ($query) {
                        return $q->where('name', 'LIKE', '%' . $query . '%');
                    })
                    ->orderBy('id', 'asc')
                    ->get();

            }
            else
            {
                $data = PaypalPayment::orderBy('id', 'asc')->with('user')->with('package')->get();

            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {

                    $output .= '
        <tr>
         <td>'.$row->user->full_name.'</td>
         <td>'.$row->order_id.'</td>
         <td>'.$row->package->name.'</td>
         <td>'.$row->txn_id.'</td>
         <td>'.$row->payment_gross.'</td>
         <td>'.$row->payer_id.'</td>
         <td>'.$row->payer_name.'</td>
         <td>'.$row->payment_status.'</td>
         <td>'.$row->created_at.'</td>
        </tr>
        ';
                }

            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="7">No Record Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }
/***---------------------------ORDERS-----------------=-----------------*/
    public function list_orders()
    {
        $orders = Order::orderBy('id', 'asc')->paginate(20);
        return view('Admin.Payments.list-orders', compact('orders'));
    }

    public function list_tickets()
    {
        $orders = Event::orderBy('id', 'asc')->paginate(20);
        return view('Admin.Payments.list-tickets', compact('orders'));
    }

    public function view_order($orderId)
    {
        $order = Order::where('order_number', '=', $orderId)->first();
        $user = User::where('id', '=', $order->user_id)->first();
        $paypal = PaypalPayment::where('order_id', '=', $orderId)->first();
        $mpesa = MpesaPayment::where('order_number', '=', $orderId)->first();

        return view('Admin.Payments.view-order', compact('user', 'order', 'paypal', 'mpesa'));
    }

    public function get_manual_tickets()
    {
        $packages = Package::all();
        return view('Admin.Payments.manual-ticket', compact('packages'));
    }
    public function post_manual_tickets(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:50',
            'email'=>'required|string|max:50',
            'package'=>'required|string|max:50',
            'free_pass' => 'required|string|in:yes,no',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::where('email', '=', $request->get('email'))->first();
        if ($user == null){
            return redirect()->back()->with('info', 'Sorry, No User found with that email')->withInput();
        }else{
            $package = Package::find($request->get('package'));
            if ($package == null) {
                return redirect()->back()->with('info', 'Something Went wrong!')->withInput();
            }
            $purchase_id = rand(1000,999999);
            $package_id = $package->id;
            if ($package_id == 1){
                $days = 1;
            }elseif ($package_id == 2){
                $days = 7;
            }elseif ($package_id == 3){
                $days = 31;
            }
            $exp_date = Carbon::now()->addDays($days);
            $order_amount = $package->amount;
            if($request->free_pass == "yes"){
                $order_amount = 0;
            }
            $order = new Order([
                'order_number'=> $purchase_id,
                'user_id'=>$user->id,
                'package_id'=>$package->id,
                'amount'=>$order_amount,
                'expires_at'=>$exp_date ,
            ]);

            $order->save();
            dispatch(new OrderEmail($order));
            if ($order){
                return redirect()->back()->with('success', 'Order has been created successfully');
            }else{
                return redirect()->back()->with('info', 'Something went wrong, retry with better internet connection');
            }

        }

    }

/***---------------------------PROMOTIONS-----------------------------------------*/
    public function list_promoCodes()
    {
        $codes = PromoCode::where('status', '=', 0)->orderBy('created_at', 'asc')->get();
        $unused_codes = PromoCode::where('status', '=', 1)->orderBy('created_at', 'asc')->get();

        return view('Admin.Payments.promotions', compact('codes', 'unused_codes'));
    }
}
