<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventPayment;
use App\Jobs\EventOrderEmail;
use App\Jobs\OrderEmail;
use App\Order;
use App\OrderEvent;
use App\Package;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

class EventPaymentController extends Controller

{
    public static function generateLiveToken()
    {
        $consumer_key = '2dP5CiVNMKlPViOYzQWgp5v0OxO94BNV';
        $consumer_secret = 'DmzYB6A9nTWGEjt9';

        if (!isset($consumer_key) || !isset($consumer_secret)) {
            die("please declare the consumer key and consumer secret as defined in the documentation");
        }
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        if (!isset($consumer_key) || !isset($consumer_secret)) {
            die("please declare the consumer key and consumer secret as defined in the documentation");
        }

        $client = new Client();
        $credentials = base64_encode($consumer_key.':'.$consumer_secret);

        $res = $client->request('get', $url, [
            'verify' => false,
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
            ]
        ]);

        $res2 = (string)$res->getBody();
        $obj = json_decode((string)$res->getBody());
        $token = $obj->access_token;
        return $token;


    }

    public static function generateSandBoxToken()
    {
        $consumer_key = 'KGGBIaoWBP6ixngnC3ngnAd94OK7LL2v';
        $consumer_secret = 'LFrL5I2XPb0VYD1P';
        if (!isset($consumer_key) || !isset($consumer_secret)) {
            die("please declare the consumer key and consumer secret as defined in the documentation");
        }

        $client = new Client();
        $credentials = base64_encode($consumer_key . ':' . $consumer_secret);

        $credentials2 = base64_encode('KGGBIaoWBP6ixngnC3ngnAd94OK7LL2v:LFrL5I2XPb0VYD1P');

        // dd($credentials, $credentials2);
        $res = $client->request('get', 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
            'verify' => false,
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
            ]
        ]);
        $res2 = (string)$res->getBody();
        $obj = json_decode((string)$res->getBody());
        $token = $obj->access_token;
        return $token;
    }

    /**************************************USED ON FORM*************************************************/
    public function payments(Request $request)
    {
        $slug = $request->get('id');

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|numeric|min:9',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Something Went Wrong, refresh page and try again')->withInput();
        }
        $id = $request->get('slug');
        $package = Event::where('id', '=', $id)->firstOrFail();
        //$package_id = decrypt($request->get('pkg'));
       // $package = Package::where('id', '=', $package_id)->firstOrFail();
       // $discount = decrypt($request->get('toffeetribe'));
        $amount = $package->price;

        $live = env("application_status");
        if ($live == "live") {
            $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $token = self::generateLiveToken();
            $BusinessShortCode = env('live_business_short_code');
            $PartyB = $BusinessShortCode;
            $LipaNaMpesaPasskey = env('lipa_mpesa_key');
        } elseif ($live == "sandbox") {
            $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $token = self::generateSandBoxToken();
            $BusinessShortCode = env('business_short_code');
            $PartyB = $BusinessShortCode;
            $LipaNaMpesaPasskey = env('lipa_mpesa_key')/*"bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"*/;

        } else {
            Session::put('error', 'invalid application status');
            return json_encode(["Message" => "invalid application status"]);
        }

        //set values
        $TransactionType = "CustomerPayBillOnline";
        $Amount = (int)$amount;
        $PartyA = '254' . substr($request->phone_number, -9);
        $PhoneNumber = '254' . substr($request->phone_number, -9);
      //$AccountReference = Package::where('id', '=', $package_id)->first()->account;
        $AccountReference = "toffeetribe";
        $Remark = "Toffee-Sub";

        $timestamp = '20' . date("ymdhis");
        $password = base64_encode($BusinessShortCode . $LipaNaMpesaPasskey . $timestamp);
        $CallBackURL = route('callbacks');
        //dd($BusinessShortCode, $LipaNaMpesaPasskey);

        //dd($password, $timestamp, $CallBackURL, $Amount, $PhoneNumber); exit();


        $client = new Client();

        try {

            $res = $client->request('post', $url, [
                'verify' => false,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode(
                    [
                        'BusinessShortCode' => $BusinessShortCode,
                        'Password' => $password,
                        'Timestamp' => $timestamp,
                        'TransactionType' => $TransactionType,
                        'Amount' => $Amount,
                        'PartyA' => $PartyA,
                        'PartyB' => $PartyB,
                        'PhoneNumber' => $PhoneNumber,
                        'CallBackURL' => $CallBackURL,
                        'AccountReference' => $AccountReference,
                        'TransactionDesc' => $Remark,
                        // 'Remark'=> $Remark
                    ]
                )
            ]);


            $obj = json_decode((string)$res->getBody());
            // dd($obj);


            if ($obj->ResponseCode == 0) {
                $result = DB::transaction(function () use ($request, $obj, $package, $PhoneNumber) {
                    $user = Auth::user();
                    $purchase_id = rand(1000 , 999999);
                    //MPESA TRANSACTION
                    $mpesa_transaction = EventPayment::create([
                        'user_id' => $user->id,
                        'package_id' => $package->id,
                        'event_name' => $package->name,
                        'order_number'=> $purchase_id,
                        'phoneNumber'=> $PhoneNumber,
                        'MerchantRequestID' => $obj->MerchantRequestID,
                        'CheckoutRequestID' => $obj->CheckoutRequestID,
                    ]);

                    if (!$mpesa_transaction->save()) {
                        DB::rollback();
                        return false;
                    }

                    //was returning order id
                    return $mpesa_transaction->id;
                });

                return  redirect()->route('mpesaa.payments.pendings', ['orderId'=>encrypt($result)])->with('status', 'An MPESA Prompt has been sent to your phone.');

            }
            else{
                return  redirect()->route('event.show',$slug)->with('error', 'We seem to be having a problem. please try again later');
            }
        }catch (\Exception $e){
           return  redirect()->route('event.show',$slug)->with('error', 'We seem to be having a problem. please try again later');
        }
    }

    public function callbacks(Request $request)
    {
//         Log::info((string) $data2); exit();
        $callbackJSONData = file_get_contents('php://input');
        $callbackData = json_decode($callbackJSONData);
        info((string)$callbackData->Body->stkCallback->ResultCode);

        /*if payment is done successfully*/
        if ($callbackData->Body->stkCallback->ResultCode == 0) {
            $resultCode = $callbackData->Body->stkCallback->ResultCode;
            $resultDesc = $callbackData->Body->stkCallback->ResultDesc;
            $merchantRequestID = $callbackData->Body->stkCallback->MerchantRequestID;
            $checkoutRequestID = $callbackData->Body->stkCallback->CheckoutRequestID;
            $amount = $callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $mpesaReceiptNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            $date = $callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $phoneNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;


            // Log::info($amount,$mpesaReceiptNumber,$date,$phoneNumber);
            $int = date_create($date);
            $transactionDate = Carbon::parse($date)->toDateTimeString();
            $mpesa_transaction = EventPayment::where('CheckoutRequestID', $checkoutRequestID)->first();
            $result = [
                "ResultDesc" => $resultDesc,
                "ResultCode" => $resultCode,
                "MerchantRequestID" => $merchantRequestID,
                "CheckoutRequestID" => $checkoutRequestID,
                "amount" => $amount,
                "mpesaReceiptNumber" => $mpesaReceiptNumber,
                "order_id" => $mpesa_transaction->id,
                "transactionDate" => $transactionDate,
                "phoneNumber" => $phoneNumber
            ];



            $mpesa = EventPayment::where('CheckoutRequestID', $checkoutRequestID)->update([
                'mpesaReceiptNumber' => $mpesaReceiptNumber,
                'completed' => true,
                'transactionDate' => Carbon::now(),
                'ResultCode'=>$resultCode,
                'ResultDesc' => $resultDesc,
                'amount' => $amount,
            ]);

            $mpesa_tran = EventPayment::where('CheckoutRequestID', $checkoutRequestID)->first();
            $package_id = $mpesa_tran->package_id;
            $order = new OrderEvent([
                'user_id' => $mpesa_tran->user_id,
                'package_id' => $package_id,
                'order_number' => $mpesa_tran->order_number,
                'amount' => $amount,
            ]);
            $order->save();

            //dispatch(new EventOrderEmail($order));

            return Redirect::to('/account/payment-success')->with('status', 'Mpesa payment made successfully!');
            //not

        }
        else
        {
            $resultCode = $callbackData->Body->stkCallback->ResultCode;
            $resultDesc = $callbackData->Body->stkCallback->ResultDesc;
            $merchantRequestID = $callbackData->Body->stkCallback->MerchantRequestID;
            $checkoutRequestID = $callbackData->Body->stkCallback->CheckoutRequestID;

            //Log::info($amount,$mpesaReceiptNumber,$date,$phoneNumber);exit();
            $mpesa_transaction = EventPayment::where('CheckoutRequestID', $checkoutRequestID)->first();
            $slug = Str::slug($mpesa_transaction->event_name);


            $result = [
                "ResultDesc" => $resultDesc,
                "ResultCode" => $resultCode,
                "MerchantRequestID" => $merchantRequestID,
                "CheckoutRequestID" => $checkoutRequestID,
                "order_id" => $mpesa_transaction->id,
                "amount" => null,
                "mpesaReceiptNumber" => null,
                "transactionDate" => null,
                "phoneNumber" => null
            ];

            $mpesa = EventPayment::where('CheckoutRequestID', $checkoutRequestID)->update([
                'mpesaReceiptNumber' => null,
                'completed' => false,
                'transactionDate' => Carbon::now(),
                'ResultCode'=>$resultCode,
                'ResultDesc' => $resultDesc,
            ]);
//
            //return Redirect::to('account')->with('error', 'Callback Failed, Payment was Unsuccessful');
            return  redirect()->route('event.show',$slug)->with('error', 'Callback Failed, Payment was Unsuccessful');
        }
    }

    public function completes(Request $request)
    {
        $order = EventPayment::where('id', (int)$request->order_id)->first();

        if ($order->completed) {
            Session::put('success', 'Successfully accepted payment');
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully completed payment',

            ]);
        } else {
            Session::put('error', 'Payment not completed');
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not completed',

            ]);
        }

    }

    //retry failed stk
    public  function retrys(Request $request){

        $ord = EventPayment::find($request->order);
        if ($ord->completed){
            return response()->json([
                'status' => 'Success',
                'message' => 'This ticket has been paid. Please click on complete button' ,
                'order_id' => $request->order

            ]);

        }
        $user = User::find($ord->user_id);
        $client = new Client();
        $live = env("application_status");
        if ($live == "live") {
//            $settings = Setting::first();
            /*$consumer_key = decrypt($settings->consumer_key);
            $consumer_secret = decrypt($settings->consumer_secret);
            dd($consumer_key, $consumer_secret);*/
            $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $token = self::generateLiveToken();
//            $BusinessShortCode = decrypt($settings->short_code);
//            $PartyB = $BusinessShortCode;
//            $LipaNaMpesaPasskey = decrypt($settings->lipa_mpesa_key);
            $BusinessShortCode = env('business_short_code');
            $PartyB = $BusinessShortCode;
            $LipaNaMpesaPasskey = env('lipa_mpesa_key');
        } elseif ($live == "sandbox") {
            $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $token = self::generateSandBoxToken();
            $BusinessShortCode = env('business_short_code');
            $PartyB = $BusinessShortCode;
            $LipaNaMpesaPasskey = env('lipa_mpesa_key')/*"bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"*/;

        } else {
            return json_encode(["Message" => "invalid application status"]);
        }
        //set values
        $TransactionType = "CustomerPayBillOnline";
        $Amount = (int)$ord->total;
        $PartyA = '254' . substr($user->phone, -9);
        $PhoneNumber = '254' . substr($user->phone, -9);
        $AccountReference = "retry";
        $Remark = "pay for the event";
        ;
        $timestamp = '20' . date("ymdhis");
        $password = base64_encode($BusinessShortCode . $LipaNaMpesaPasskey . $timestamp);
        $CallBackURL = route('callbacks');
        // $CallBackURL = 'https://www.etik.co.ke/index.php?route=extension/payment/mpesaonline/callback';

        // dd($BusinessShortCode, $LipaNaMpesaPasskey);

        //dd($password, $timestamp, $CallBackURL, $Amount, $PhoneNumber); exit();

        // try {
        $res = $client->request('post', $url, [
            'verify' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode(
                [
                    'BusinessShortCode' => $BusinessShortCode,
                    'Password' => $password,
                    'Timestamp' => $timestamp,
                    'TransactionType' => $TransactionType,
                    'Amount' => $Amount,
                    'PartyA' => $PhoneNumber,
                    'PartyB' => $PartyB,
                    'PhoneNumber' => $PhoneNumber,
                    'CallBackURL' => $CallBackURL,
                    'AccountReference' => $AccountReference,
                    'TransactionDesc' => $Remark,
                    // 'Remark'=> $Remark
                ]
            )
        ]);


        $obj = json_decode((string)$res->getBody());

        if ($obj->ResponseCode == 0) {
            $result = DB::transaction(function () use ($request, $obj) {




                $order1 = OrderEvent::where('id', $request->order)->first();
                $order = OrderEvent::create([
                    'total' => (int)$order1->total,
                    'user_id' => (int)$order1->user_id,
                    'ettype_id' => (int)$order1->ettype_id,
                    'quantity' => (int)$order1->quantity,
                    'MerchantRequestID' => $obj->MerchantRequestID,
                    'CheckoutRequestID' => $obj->CheckoutRequestID,
                ]);

                if (!$order) {
                    DB::rollback();
                    return false;
                }

                return $order->id;
            });


            return response()->json([
                'status' => 'Success',
                'message' => 'Resent the M-Pesa prompt to your phone',
                'order_id' => $result

            ]);
        }
    }

    public function payments_pendings($orderId)
    {
        $order = EventPayment::find(decrypt($orderId));
        return view('Users.Accounts.payments-pending', compact('order'));
    }

    public function checks_payment_status($orderId)
    {
        $order = EventPayment::find(decrypt($orderId));
        if ($order->completed == true)
        {
            return $order;
        }
        return false;
    }

    public function checks_payment_complete($orderId)
    {
        $order = EventPayment::find(decrypt($orderId));
        $slug = Str::slug($order->event_name);
        if ($order->completed == true)
        {
            //return  redirect()->route('event.show',$slug)->with('status', 'Mpesa Payment made successfully!');
           return Redirect::to('/ticket/payment-success')->with('status', 'Mpesa Payment made successfully!');
        }
        elseif($order->ResultCode == 1031 || $order->ResultCode == 1032)
        {
            //return  redirect()->route('event.show',$slug)->with('error', 'Payment Failed, Request Cancelled by User');
            return  redirect()->route('event.show',$slug)->with('error', 'Payment Failed, Request Cancelled by User');
           // return Redirect::to('event.show')->with('error', 'Payment Failed, Request Cancelled by User');

        }
        elseif($order->ResultCode == 1037)
        {
           // return Redirect::to('account')->with('error', 'Payment Failed, Connection Timed Out');
            return  redirect()->route('event.show',$slug)->with('error', 'Payment Failed, Connection Timed Out');
        }
        elseif($order->ResultCode == 1)
        {
//            return Redirect::to('account')->with('error', 'Payment Failed, Insufficient funds in your MPesa Account');
            return  redirect()->route('event.show',$slug)->with('error', 'Payment Failed, Insufficient funds in your MPesa Account');

        }
        elseif($order->ResultCode == null){
            //return  redirect()->route('event.show',$slug)->with('error', 'Payment not received, click finish once a confirmation text has been received.');
            return Redirect::back()->with('error', 'Payment not received, click finish once a confirmation text has been received.');

        }
        else{
            return  redirect()->route('event.show',$slug)->with('error', 'Sorry something went wrong, contact hello@toffeetribe.com for assistance.');
           // return Redirect::to('account')->with('error', 'Sorry something went wrong, contact hello@toffeetribe.com for assistance');
        }
    }

}
