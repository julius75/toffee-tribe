<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
//use Codedge\Fpdf\Facades\Fpdf;
use App\FPDF\FPDF;

Route::get('/', function () {
    $user = Auth::user();
    if (Auth::check()){
        $assignedLocation = \App\Restaurant::where('host_id', '=', Auth::user()->id)->first();
    }
    if ($user){
        if ($user->hasRole('admin')){
            return redirect()->to('/toffee-admin');
        }
        elseif ($user->hasRole('host') && $assignedLocation)
        {
            return redirect()->to('/toffee-host');
        }
        else{
            return redirect()->to('/member_dashboard');
        }
    }else{
        return redirect()->to('/login');
    }
    // return view('welcome');
});

// Route::get('/subscriber-seeder', function () {
    // $data = [
    //     "nyakerario86@gmail.com",
    //     "danisheskimo@gmail.com",
    //     "jireh@vibeproductions.co.ke",
    //     "agneswyna@gmail.com",
    //     "amondivalerie@gmail.com",
    //     "chandniratilalshah@gmail.com",
    //     "omambia.n@gmail.com",
    //     "david@kretiva.com",
    //     "anneronoh13@gmail.com",
    //     "martin@azafinance.com",
    //     "hobsoneden@gmail.com",
    //     "thechecklist254@gmail.com",
    //     "mungaijamesss@gmail.com",
    //     "michaelkeya@gmail.com",
    //     "abdulsaidi81@gmail.com",
    //     "munyala@dti4i.com",
    //     "eunicekkilonzo@gmail.com",
    //     "omulotessie@gmail.com",
    //     "claritabourassa@agent.variots.com",
    //     "anneww39@gmail.com",
    //     "tony@miles.co.ke",
    //     "abigailkomu@gmail.com",
    //     "kimmburu@gmail.com",
    //     "nelly@finitybind.com",
    //     "nginas@gmail.com",
    //     "eugenetolbert1@gmail.com",
    //     "muema@outlook.com",
    //     "developersmartke@gmail.com",
    //     "nwchege@gmail.com",
    //     "ashaakimay@gmail.com",
    //   "boscomutunga@gmail.com",
    //     "mwaragichanga@gmail.com",
    //     "jakinereah@icloud.com",
    //     "bryan@jabotech.co.ke",
    //     "dmngaie@gmail.com",
    //     "gngumba@gmail.com",
    //   "arjunpaj@yahoo.com",
    //     "jmbarani@gmail.com",
    //     "lisawairimu99@gmail.com",
    //     "michael@growth.co.ke",
    //     "i.mohabdulrahman@gmail.com",
    //     "kobyndungu@gmail.com",
    //     "ijaaba.yusuf@gmail.com",
    //     "celia.sikunjemakesho@gmail.com",
    //     "fazal.nafisa@gmail.com",
    //     "wannmercy254@gmail.com",
    //     "kevinbet6@gmail.com"
    //     ];
    //     $existing = [];
    //     $created = [];
    //     foreach($data as $email){
    //         $check = \App\Subscriber::where('email', '=', $email)->first();
    //         if($check){
    //             array_push($existing, ['id'=>$check->id, 'email'=>$check->email]);
    //         }else{
    //           $new =  \App\Subscriber::create([
    //               'email'=> $email,
    //               'status'=>false,
    //               'created_at'=> \Carbon\Carbon::now()
    //               ]);
    //               array_push($created , ['id'=>$new->id, 'email'=>$new->email]);
    //         }

    //     }
    // return ['existing'=>$existing, 'created'=>$created];
// });

Route::get('qrcode', function () {
    $location = \App\Restaurant::find(13);
    $image = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
        ->color(26,144,130)
        ->size(500)
        ->generate("mukhami@deveint.com");

    $output_file = '/order-tickets/qr-'.$location->id.'-' . time() . '.png';

    \Illuminate\Support\Facades\Storage::disk('local')->put($output_file, $image);

    return response($image)->header('Content-type','image/png');
});

Route::get('/fpdf', function () {
    $order = \App\Order::find(2);
//    dd($order);
    $fpdf = new FPDF('L', 'mm', array(150, 200));
    $fpdf->AddPage();
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->Image(public_path('logo.png'), 120, 3, 50, 25);
    $qrname = 'toffeeTicket-'.$order->order_number;
    $path = public_path('qr-codes/qr2-'.$qrname . '.png');
    $image = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
        ->color(26,144,130)
        ->size(500)
        ->generate($order->order_number, $path);
    //QR CODE
    $fpdf->setXY(29, 56);
    $fpdf->Cell(0, 0, 'ORDER NUMBER: ' . $order->order_number);
    $fpdf->Image($path , 31, 58, 50 ,50);
    $fpdf->setXY(29, 22);
    //Package Name
    $fpdf->Cell(0, 0,'Package Type: ' . $order->package->name);

    //Ticket Owner
    $fpdf->setXY(29, 26);
    $fpdf->Cell(0, 0, 'Ticket Owner: ' . $order->user->full_name .' '.'(' .$order->user->phone_number.').');
    $fpdf->setXY(29, 30);
    $fpdf->Cell(0, 0, 'Email: ' . $order->user->email);

    //Dates
    $fpdf->setXY(29, 38);
    $fpdf->Cell(0, 0, 'Valid From:'.\Illuminate\Support\Carbon::parse($order->created_at)->format('d M Y, h:i') .' Expires at:' . \Illuminate\Support\Carbon::parse($order->expires_at)->format('d M Y, h:i'));
    $fpdf->setXY(29 , 50);
    $fpdf->Cell(0, 0, 'Paid Amount: KSH' .": ". number_format($order->amount));
//    $fpdf->setXY(108, 53);
//    $fpdf->Cell(0, 0, $order->amount);
    $fpdf->SetFont('Courier', 'B', 12);
    $fpdf->setXY(80, 68);
    $fpdf->Cell(0, 0, 'PAID');
    $fpdf->SetFont('Courier', '',11);
    $fpdf->setXY(80, 75);
    $fpdf->Cell(0, 0, 'YOU MAY PRINT OR DISPLAY THIS TICKET AT');
    $fpdf->setXY(80, 80);
    $fpdf->Cell(0, 0, 'THE LOCATION. DUBLICATES');
    $fpdf->setXY(80, 85);
    $fpdf->Cell(0, 0, 'WILL BE DETECTED AND REJECTED. ');
    $fpdf->setXY(80, 90);
    $fpdf->Cell(0, 0, 'ANY QUESTION ABOUT YOUR TICKET? ');
    $fpdf->setXY(80, 95);
    $fpdf->Cell(0, 0, 'EMAIL US AT info@toffetribe.com');
    $fpdf->setXY(80, 100);
    $fpdf->Cell(0, 0, 'DO NOT SHARE YOUR QR-CODE.');
    $file_name = $qrname. '.pdf';
    $file_dir = public_path('qr-codes/'.$file_name);

    $fpdf->Output($file_dir, 'F');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/complete_user_profile', 'HomeController@complete_user_profile')->name('create.profile')->middleware('auth');
Route::post('/complete_user_profile', 'HomeController@store_user_profile')->name('create.profile')->middleware('auth');

Route::get('/checkin-qr/karel-t-lounge', 'HomeController@karel');
Route::get('/checkin-qr/lava-latte', 'HomeController@lava');
Route::get('/checkin-qr/zion-restaurant', 'HomeController@zion');
Route::get('/checkin-qr/connect-coffee', 'HomeController@connect');
Route::get('/checkin-qr/chez-sonia', 'HomeController@chez');
Route::get('/checkin-qr/toffee-breakfast', 'HomeController@toffeebreakfast');
Route::get('/checkin-qr/chekafe', 'HomeController@chekafe');
Route::get('/checkin-qr/ate', 'HomeController@ate');
Route::get('/checkin-qr/coffee-casa', 'HomeController@coffee_casa');

Route::get('/{username}/visited-locations', 'MemberController@member_visits')->name('member.visits');

Route::get('/member_dashboard', 'MemberController@member_index')->name('member.index');
Route::get('/order/{orderId}', 'MemberController@order')->name('order');

Route::get('/pdf/{orderId}', 'MemberController@pdf')->name('pdf');
Route::get('/download-pdf/{orderId}', 'MemberController@downloadpdf')->name('download.pdf');

Route::get('invite', 'MemberController@referrals')->name('member.invite');
Route::get('invite/send-mail', 'MemberController@mail_form')->name('email');
Route::post('invite', 'MemberController@invite_mail')->name('member.invite');
Route::get('profile/{username}', 'MemberController@member_profile')->name('member.profile');
Route::post('profile', 'MemberController@member_profile_update')->name('member.update.profile');

Route::get('account', 'MemberController@account_info')->name('member.account');

Route::get('events', 'MemberController@events')->name('member.events');
Route::get('event/{slug}', 'MemberController@shows')->name('event.show');
Route::get('purchase/{slug}', 'MemberController@purchase_form')->name('purchase_form');

Route::get('create', 'EventController@create')->name('member.create');


Route::get('account/purchase-plan/{slug}', 'MemberController@checkout_form')->name('checkout');

Route::get('status/{package_id}', 'PaypalPaymentController@execute_payment')->name('payment.success');
Route::get('account/payment-success', 'PaypalPaymentController@payment_success')->name('payment.success');
Route::get('ticket/payment-success', 'PaypalPaymentController@payments_success')->name('payments.success');

Route::post('account/purchase-plan/', 'MemberController@verify_promo_code')->name('promo');

Route::get('locations', 'MemberController@locations')->name('member.locations');
Route::get('locations/{slug}', 'MemberController@view_location')->name('location');

Route::prefix('toffee-admin')->group(function () {
    Route::get('', 'VerifyInviteController@admin_home')->name('admin.home');

    Route::get('users-data', 'AdminController@usersData')->name('users.data');
    Route::get('manage-users-data', 'AdminController@manageUsersData')->name('manage.users.data');
    Route::get('orders-data', 'AdminController@ordersData')->name('orders.data');
    Route::get('tickets-events-data', 'AdminController@ordersEventData')->name('orders.events.data');

    Route::get('locations-data', 'AdminController@locationsData')->name('locations.data');
    Route::get('events-data', 'AdminController@eventsData')->name('events.data');

    Route::get('paypal-data', 'AdminController@paypalData')->name('paypal.data');
    Route::get('mpesa-data', 'AdminController@mpesaData')->name('mpesa.data');

     Route::get('location-visits-data/{slug}', 'AdminController@visitsData')->name('loc.visits.data');

    Route::get('/registered-users', 'VerifyInviteController@list_users')->name('reg.users');
    Route::get('/registered-users/action', 'VerifyInviteController@action')->name('reg.users.search');

    Route::get('/manage-users', 'VerifyInviteController@manage_users')->name('manage.users');
    Route::get('/manage-users/view/{username}', 'VerifyInviteController@view_user')->name('view.user');

    Route::get('/manage-users/make-admin/{userId}', 'VerifyInviteController@makeAdmin')->name('make.admin');
    Route::get('/manage-users/remove-admin/{userId}', 'VerifyInviteController@removeAdmin')->name('remove.admin');

    Route::get('/manage-users/make-host/{userId}', 'VerifyInviteController@makeHost')->name('make.host');
    Route::get('/manage-users/remove-host/{userId}', 'VerifyInviteController@removeHost')->name('remove.host');

    Route::get('/registered-hosts', 'VerifyInviteController@list_locations')->name('list.locations');
    Route::get('/registered-events', 'VerifyInviteController@list_events')->name('list.events');

    Route::post('/register-host', 'VerifyInviteController@store_host')->name('host.signup');
    Route::post('/register-event', 'VerifyInviteController@store_event')->name('event.create');

    Route::get('/registered-hosts/view-days-available/{slug}', 'VerifyInviteController@get_days_available')->name('get.days.available');
    Route::get('/registered-hosts/view-days-available/edit-day/{id}', 'VerifyInviteController@get_day_edit')->name('get.day.edit');
    Route::post('/registered-hosts/create-new-day', 'VerifyInviteController@day_create')->name('day.create.new');
    Route::post('/registered-hosts/update-day', 'VerifyInviteController@day_update')->name('day.update');
    Route::get('/registered-hosts/delete-day/{id}', 'VerifyInviteController@day_delete')->name('day.delete');


    Route::get('/registered-hosts/view/{slug}', 'VerifyInviteController@view_location')->name('admin.view.location');
    Route::get('/registered-event/view/{id}', 'VerifyInviteController@view_event')->name('admin.view.event');

    Route::get('/edit-registered-hosts/{slug}', 'VerifyInviteController@edit_host_form')->name('edit.location');
    Route::get('/edit-event/{slug}', 'VerifyInviteController@edit_event_form')->name('edit.events');


    Route::get('/edit-slider-images/{slug}', 'VerifyInviteController@edit_host_images')->name('edit.slider.images');
    Route::post('/update-slider-images', 'VerifyInviteController@update_host_images')->name('update.slider.images');

    Route::get('/register-host', 'VerifyInviteController@host_signup_form')->name('host.signup');
    Route::get('/add-event', 'VerifyInviteController@event_add_form')->name('event.signup');

    Route::post('/edit-registered-hosts', 'VerifyInviteController@update_host')->name('host.update');
    Route::post('/edit-registered-events', 'VerifyInviteController@update_event')->name('event.update');

    Route::get('/register-host/upload-images', 'VerifyInviteController@host_images')->name('host.images');
    Route::post('/register-host/upload-images', 'VerifyInviteController@store_host_images')->name('multiple.images');
    Route::post('/register-host/upload-images/{imageUpload}', 'VerifyInviteController@delete_host_image')->name('delete.image');

    Route::get('/registered-host-map/{slug}', 'VerifyInviteController@create_map')->name('host.map');
    Route::post('/registered-host-map', 'VerifyInviteController@store_map')->name('post.host.map');
    Route::get('/edit-host-map/{slug}', 'VerifyInviteController@edit_map')->name('edit.host.map');
    Route::post('/update-host-map', 'VerifyInviteController@update_map')->name('update.host.map');

    Route::get('/activate-host/{slug}', 'VerifyInviteController@activateLocation')->name('activate');
    Route::get('/deactivate-host/{slug}', 'VerifyInviteController@deactivateLocation')->name('deactivate');


    Route::get('/assign-host/{slug}', 'VerifyInviteController@get_assign_host')->name('get.assign.host');
    Route::post('/assign-host', 'VerifyInviteController@post_assign_host')->name('assign.host.post');



    Route::get('/open-location/{slug}', 'VerifyInviteController@openLocation')->name('opened');
    Route::get('/close-location/{slug}', 'VerifyInviteController@closeLocation')->name('closed');

    Route::get('/listed-packages', 'VerifyInviteController@list_packages')->name('list.packages');
    Route::get('/create-package', 'VerifyInviteController@create_package')->name('package');
    Route::post('/create-package', 'VerifyInviteController@store_package')->name('package');
    Route::get('/edit-package/{slug}', 'VerifyInviteController@edit_package')->name('edit.package');
    Route::post('/update-package', 'VerifyInviteController@update_package')->name('update.package');

    Route::get('/register-user', 'VerifyInviteController@sign_up_form')->name('user.register');
    Route::post('/register-user', 'VerifyInviteController@sign_up')->name('user.register');

    Route::get('/completed-orders', 'VerifyInviteController@list_orders')->name('list.orders');
    Route::get('/completed-events', 'VerifyInviteController@list_tickets')->name('list.tickets');  //

    Route::get('/completed-orders/view/{orderId}', 'VerifyInviteController@view_order')->name('view.order');

    Route::get('/completed-orders/create-manual-ticket/', 'VerifyInviteController@get_manual_tickets')->name('get.manual.ticket');
    Route::post('/completed-orders/create-manual-ticket/', 'VerifyInviteController@post_manual_tickets')->name('post.manual.ticket');


    Route::get('/paypal-payments', 'VerifyInviteController@list_paypalPayments')->name('pp.payments');
    Route::get('/mpesa-payments', 'VerifyInviteController@list_mpesaPayments')->name('mpesa.payments');
    Route::get('/paypal-payments/pp_action', 'VerifyInviteController@pp_action')->name('pp.payments.search');

    Route::get('/user-invite-codes', 'VerifyInviteController@list_promoCodes')->name('promo.codes');

    Route::post('/get-user-order/{slug}', 'CheckInController@find_order')->name('find.order');
    Route::get('/check-in-users/{slug}', 'CheckInController@index')->name('checkIn.index');
    Route::get('/check-in-user/{slug}/{orderId}', 'CheckInController@checkinUser')->name('checkIn.user');
    Route::post('/check-in-user/record-visit', 'CheckInController@record_visit')->name('record.visit');
    Route::get('/checked-in-users/{slug}/visitors', 'CheckInController@list_visitors')->name('list.visitors');
    Route::get('/visitor-checkout/{id}/{slug}', 'CheckInController@checkout')->name('checkout.visitor');
});

Route::prefix('toffee-host')->group(function () {
    Route::get('', 'HostController@host_home')->name('host.home');
    Route::get('/check-in-users-data/', 'HostController@visits_data')->name('host.visits_data');
    Route::get('/check-in-users/{slug}', 'HostController@index')->name('host.checkIn.index');
    Route::post('/get-user-order/{slug}', 'HostController@find_order')->name('host.find.order');
    Route::get('/check-in-user/{slug}/{orderId}', 'HostController@checkinUser')->name('host.checkIn.user');
    Route::post('/check-in-user/record-visit', 'HostController@record_visit')->name('host.record.visit');
    Route::get('/monthly-visits-metrics/{slug}', 'HostController@monthly_visits')->name('host.monthly_visits');
    Route::get('/visitor-checkout/{id}/{slug}', 'HostController@checkout')->name('host.checkout.visitor');
});

//mpesa
Route::post('/mpesa/confirmation', 'C2BController@confirmation')->name('mpesa.confirmation');
Route::post('/mpesa/validation_url', 'C2BController@validation_url')->name('mpesa.validation_url');

Route::get('account/payment-pending/{orderId}', 'C2BController@payment_pending')->name('mpesa.payment.pending');
Route::get('accounts/payments-pendings/{orderId}', 'EventPaymentController@payments_pendings')->name('mpesaa.payments.pendings');//


Route::get('event/purchase-pending/{orderId}', 'EventPaymentController@payment_pending')->name('event.purchase.pending');

Route::get('mpesa/payment-checking/{orderId}', 'C2BController@check_payment_status')->name('check.mpesa');
Route::get('mpesaa/payments-checking/{orderId}', 'EventPaymentController@checks_payment_status')->name('checks.mpesa');


Route::get('checks-mpesa-completes/{orderId}', 'C2BController@checks_payment_complete')->name('check.mpesa.confirm');
Route::get('checks-mpesa-completes/{orderId}', 'EventPaymentController@checks_payment_complete')->name('checks.mpesa.confirms'); //


Route::post('/mpesa/payment', 'C2BController@payment')->name('mpesa.payment');
Route::post('/mpesaa/payments', 'EventPaymentController@payments')->name('mpesaa.payments'); //


Route::post('/pay/event', 'EventPaymentController@payments')->name('pay.event');

Route::post('/mpesa/callback', 'C2BController@callback')->name('callback');
Route::post('/mpesaa/callbacks', 'EventPaymentController@callbacks')->name('callbacks');//


Route::post('/event/purchase', 'EventPaymentController@purchase')->name('purchase');

Route::post('/complete', 'C2BController@complete')->name('mpesa.complete');
//Route::post('/complete', 'C2BController@complete')->name('mpesa.complete');

Route::post('/retry', 'C2BController@retry')->name('mpesa.retry');


Route::get('verify', 'VerifyInviteController@verify_form')->name('verify.invite');
Route::post('verify', 'VerifyInviteController@verify_invite')->name('verify.invite');

//test email view
Route::get('mailable', function () {
    $invite_code = Auth::user()->invite_code;
    $invitee_name = "ME";
    $invitee_email = "me@gmail.com";
    $sender = Auth::user()->email;
    $sender_name = Auth::user()->full_name;
    $message = "I’ve been using Toffee Tribe, a startup that turns excess space in beautiful restaurants into a network of super flexible & affordable coworking spaces.
All the necessities like coffee, tea, snacks, and fast wifi are included - it’s way better than working at home or in coffee shops.
The first three days are free for everyone but if you become a member afterwards with my code MUKHAMI055 you’ll get 50% off your first month. (Full disclosure: I get a credit too if you join 😉)";

    return new App\Mail\Invite($invite_code ,$invitee_name ,$invitee_email ,$sender ,$sender_name, $message);
});

Route::get('order-mailable', function () {
    $order = App\Order::find(49);

    return new App\Mail\PaypalOrder($order);
});

Route::get('/subscriber/update/{id}', 'MemberController@subscriber_update')->name('subscriber.update');
Route::get('/manual-payments', 'AdminController@manual')->name('manual.payments');
Route::post('/mpesa/manual', 'AdminController@manualPost')->name('manual');
