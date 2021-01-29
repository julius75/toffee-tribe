<?php

namespace App\Http\Controllers;


use App\Day;
use App\Event;
use App\Invitation;
use App\LocationVisit;
use App\Mail\Invite;
use App\Map;
use App\MpesaPayment;
use App\Order;
use App\Package;
use App\PaypalPayment;
use App\PromoCode;
use App\Restaurant;
use App\Subscriber;
use App\Jobs\OrderEmail;
use App\RestaurantImage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cors');
        $this->middleware('verified');
    }
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
        return (int)$total;

    }
    public function member_index(){
        $user_id = Auth::user()->id;
        $user = DB::table('users')->find($user_id);
        $subscriber = Subscriber::where('email', $user->email)->first();
        $orders = Order::where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get();
        $subscription = Order::where('user_id', '=', $user_id)->where('expires_at', '>',Carbon::now())->first();
        if ($subscription != null){
            $current_package = Package::where('id', $subscription->package_id)->first();
            $current_package = $current_package->name;
        }else{
            $current_package = "You do not have an active subscription";
        }
        $mpesa_sum = MpesaPayment::where('user_id', '=', $user_id)->sum('amount');
        $pp_sum = PaypalPayment::where('user_id', '=', $user_id)->sum('payment_gross');
        try{
            $converted = $this->convertCurrency($pp_sum, 'USD', 'KES');
        }
        catch(\Exception $exception)
        {
            $rate = 101.49;
            $converted = $pp_sum * $rate;
        }
        $revenue = $mpesa_sum + $converted;
        return view('Users.member-dashboard', compact('user', 'orders', 'current_package', 'subscription','revenue', 'subscriber'));
    }

    public function member_profile($username){
        $user = User::where('username','=', $username)->firstOrFail();
        return view('Users.user-profile', compact('user'));
    }

    public function member_profile_update(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required|max:30',
            'full_name' => 'required|max:100',
            'email' => 'required|email|string|max:100',
            'phone_number' => 'required|max:100|',
            'message' => 'max:100',
            'company' => 'max:100',
            'industry' => 'max:100',
            'location' => 'max:100',
            'grind' => 'max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $username = $request->input('username');
        $name = $request->get('full_name');
        $email = $request->get('email');
        $phonenumber = $request->get('phone_number');
        $bio = $request->get('message');
        $company = $request->get('company');
        $industry = $request->get('industry');
        $location = $request->get('location');
        $grind = $request->get('grind');

        $user = User::where('username', '=' ,$username)->firstOrFail();

        $user->full_name = $name;
        $user->email = $email;
        $user->phone_number =$phonenumber;
        $user->bio = $bio;
        $user->industry = $industry;
        $user->company = $company;
        $user->location = $location;
        $user->grind = $grind;

        $user->save();

        return redirect()->back()->with('info', 'Profile Saved!');
    }

    public function referrals()
    {
        $user = Auth::user();
        $text = urlencode("Hiya [Friends_Name], Take a look at this new company, I think you'll like it! I’ve been using Toffee Tribe, a kick-start that helps the coworking tribe access coworking spaces in restaurants and cafes. There is plenty of coffee, tea, blazing-fast wifi, community connections, and monthly fun activities and events to help you take a break from work. You honestly can't get all these cool necessities working from home or coffee shops. The first three days are free for everyone but if you become a member afterward with my code [ENTER_INVITE_CODE] you’ll get 50% off your first month and guess what, I get a credit too if you join 😊. You can start your three days free trial on their website https://www.toffeetribe.com/. Let's Grind!-[Your_Name]");
        return view('Users.Referrals.invite-user', compact('user', 'text'));
    }

    public function mail_form()
    {
        $user = Auth::user();
        return view('Users.Referrals.mail', compact('user'));
    }

    public function invite_mail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:20',
            'email'=>'required|email|string|'
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

//        $sender_id = Auth::user()->id;
//        $invitee_email = $request->input('email');
//        $invitation = new Invitation(['user_id'=>$sender_id ,'email' =>$invitee_email]);
//        $invitation->save();

        //send invite email
        $invite_code = Auth::user()->invite_code;
        $invitee_name = $request->input('name');
        $invitee_email = $request->input('email');
        $message = $request->input('message');
        $sender = $request->user()->email;
        $sender_name = $request->user()->full_name;

        Mail::send(new Invite($invite_code,  $invitee_name, $invitee_email, $sender,  $sender_name, $message));
        return redirect()->route('member.invite')->with('info', 'An invite mail has been sent successfully!');
    }

    public function account_info(){
        $user = Auth::user();
        $day = Package::where('id', '=', 1)->firstOrFail();
        $weekly = Package::where('id', '=', 2)->firstOrFail();
        $monthly = Package::where('id', '=', 3)->firstOrFail();
        return view('Users.Accounts.accounts', compact('user', 'day', 'weekly', 'monthly'));
    }

    public function checkout_form($slug){

        $user = Auth::user();
        $package = Package::where('slug', '=', $slug)->firstOrFail();
        $total = $package->amount;
        $discount = $package->discounted_amount;

        if (Session::has('promo_code'))
        {
            $value=1;
        }
        else
            {
            $value=0;
        }

        return view('Users.Accounts.checkout', compact('user', 'package', 'total', 'discount', 'value'));
    }
    public function purchase_form($slug){

        $user = Auth::user();
        $event = Event::where('slug', '=', $slug)->firstOrFail();
        $total = $event->price;

        return view('Users.Accounts.purchase', compact('event','user','total'));
    }

    public function verify_promo_code(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'invite_code'=>'required|max:20|string',
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect()->back()->with('success','Promotions are currently unavailable, we will contact you as soon as they are active!');

//        $user = Auth::user();
//        $user_code = $request->input('invite_code');
//        $invite_code = PromoCode::where('code','=' ,$user_code)->first();
//        if (!$user_code = $invite_code){
//            return redirect()->back()->with('error','Invalid Promo Code');
//        }elseif($invite_code->status == 0){
//            return redirect()->back()->with('error','Promo Code has already been used');
//        }else {
//            Session::put('promo_code', $invite_code);
//            Session::put('user_details', $user);
//            return redirect()->back()->with('success', 'Valid Code! You now get 50% off!', compact('user'));
//        }
    }
    public function events(){
        $user = Auth::user();
        $events = Event::where('status', '=', 1)->orderBy('id', 'desc')->get();
        return view('Users.Events.index', compact('user','events'));
    }

    public function shows($id){
        $user = Auth::user();
        $event = Event::where('slug', '=' ,$id)->firstOrFail();
        $location = Restaurant::where('restaurant_name', '=' ,$event->location)->firstOrFail();
        $map = Map::where('restaurant_id', '=', $location->id)->firstOrFail();
        return view('Users.Events.show', compact('user','event','map','location'));
    }

    public function locations(){
        $user = Auth::user();
        $locations = Restaurant::where('status', '=', 1)->orderBy('created_at', 'desc')->with('days')->get();
        $latest_entry = Restaurant::where('status', '=', 1)->latest('created_at')->first();
        $location_map = Map::where('restaurant_id', '=', $latest_entry->id)->first();
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
        return view('Users.Locations.location-index', compact('user', 'locations', 'weekday', 'location_map'));
    }

    public function view_location($slug){
        $user = Auth::user();
        $location = Restaurant::where('slug', '=', $slug)->firstOrFail();
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
        $images = RestaurantImage::where('restaurant_id', '=', $location->id)->get();
        $days = Day::where('restaurant_id', '=', $location->id)->get();
//        dd($days->pluck('day_of_week'));
//        dd($location->days->implode('day_of_week', ','));
//        $days = json_decode($location->day_available);
        $location_map = Map::where('restaurant_id', '=', $location->id)->firstOrFail();
//        $test = Session::get('promo_code');
//        $test2 = PromoCode::find($test->id);
//        dd($test2);
//        dd(json_decode($location->day_available));
        return view('Users.Locations.location', compact('location', 'user', 'days','images', 'location_map', 'weekday'));
    }

    public function order($orderId)
    {
        $user = Auth::user();
        $order = Order::where('order_number', '=', $orderId)->first();
        $mpesa = MpesaPayment::where('order_number', '=', $orderId)->first();
        $paypal = PaypalPayment::where('order_id', '=', $orderId)->first();
        $start_date = $order->created_at;
        if ($order->package_id == 1)
        {
            $exp_date = $start_date->addDays(1);
        }elseif ($order->package_id == 2)
        {
            $exp_date = $start_date->addDays(7);
        }else
            {
            $exp_date = $start_date->addDays(31);
        }
        return view('Users.Accounts.order', compact('user', 'order', 'paypal', 'exp_date', 'mpesa'));
    }
    public function member_visits()
    {
        $user = Auth::user();
        $visits = LocationVisit::where('user_id', '=', Auth::user()->id)->orderBy('arrival_time', 'desc')->get();

        return view('Users.Locations.visited-locations', compact('visits', 'user'));
    }

    public function pdf($orderId){
        $user = Auth::user();
        $order = Order::where('order_number', '=', $orderId)->first();

        $paypal = PaypalPayment::where('order_id', '=', $orderId)->first();

        $mpesa = MpesaPayment::where('order_number', '=', $orderId)->first();

        $start_date = $order->created_at;
        if ($order->package_id == 1)
        {
            $exp_date = $start_date->addDays(1);
        }elseif ($order->package_id == 2)
        {
            $exp_date = $start_date->addDays(7);
        }else
        {
            $exp_date = $start_date->addDays(31);
        }
        return view('Users.Accounts.invoice-pdf', compact('user', 'order', 'paypal', 'exp_date', 'mpesa'));
    }

    public function downloadpdf($orderId)
    {
        $user = Auth::user();
        $order = Order::where('order_number', '=', $orderId)->first();

        $paypal = PaypalPayment::where('order_id', '=', $orderId)->first();

        $mpesa = MpesaPayment::where('order_number', '=', $orderId)->first();

        $start_date = $order->created_at;
        if ($order->package_id == 1)
        {
            $exp_date = $start_date->addDays(1);
        }elseif ($order->package_id == 2)
        {
            $exp_date = $start_date->addDays(7);
        }else
        {
            $exp_date = $start_date->addDays(31);
        }
        $pdf = PDF::loadView('Users.Accounts.invoice-pdf', ['user'=>$user, 'order'=>$order, 'paypal'=>$paypal, 'exp_date'=>$exp_date, 'mpesa'=>$mpesa]);
        return $pdf->download('ToffeeTribe-invoice-'.$order->order_number.'.pdf');
    }

    public function subscriber_update(Request $request, $id) {
        $sub = Subscriber::find($id);
        $user = Auth::user();
        $new_status = 1;
        $sub->status = $new_status;
        $sub->save();
        $package = Package::where('id', '=', 1)->first();
        $purchase_id = rand(1000,99999);
        $exp_date = Carbon::now()->addDays(1);
            $order = new Order([
                'order_number'=> $purchase_id,
                'user_id'=>$user->id,
                'package_id'=>$package->id,
                'amount'=>0 ,
                'expires_at'=>$exp_date ,
            ]);
//            dd($order);
            $order->save();
            $fnd = dispatch(new OrderEmail($order));

        return redirect()->back()->with('success', 'Day Pass Activated Successfully, a ticket has been sent to your email address!');
    }
}
