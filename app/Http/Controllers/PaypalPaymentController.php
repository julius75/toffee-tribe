<?php

namespace App\Http\Controllers;

use App\Jobs\OrderEmail;
use App\Mail\PaypalOrder;
use App\Order;
use App\Package;
use App\PaypalPayment;
use Carbon\Carbon;
use Exception;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
//use Symfony\Component\HttpFoundation\Session\Session;
//use Session;


use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\InputFields;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\WebProfile;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;


class PaypalPaymentController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
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
        //return number_format($total, 2, '.', '');
        return (int)$total;

    }

    public function create_payment(Request $request)
    {

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $package_id = decrypt($request->get('pkg'));
        $package = Package::where('id', '=', $package_id)->firstOrFail();
        $package_desc = $package->details;
        $package_name = $package->name;
        $discount = decrypt($request->get('toffeetribe'));
        if($discount == 1)
        {
            $package_amount_KES = $package->discounted_amount;

            try{
            $package_amount = $this->convertCurrency($package_amount_KES, 'KES', 'USD');
            }
            catch(\Exception $exception)
            {
                $rate = 100;
                $package_amount = $package_amount_KES / $rate;
            }
        }
        elseif($discount == 0)
        {
            $package_amount_KES = $package->amount;
            try{
            $package_amount = $this->convertCurrency($package_amount_KES, 'KES', 'USD');
            }
            catch(\Exception $exception)
            {
                $rate = 100;
                $package_amount = $package_amount_KES / $rate;
            }

        }elseif($discount!=1 and $discount!=0){
            return Redirect::to('/account')->with('error', 'Sorry something went wrong, refresh page and try again');
        }

        $item1 = new Item();
        $item1->setName($package_name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku('ToffeeTribe '.$package_name.' pass')
            ->setPrice($package_amount);

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $amount = new Amount();
        $amount->setCurrency('USD')->setTotal($package_amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($package_desc)
            ->setInvoiceNumber(strtoupper(uniqid()));

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(URL::to('status/'.$package_id))
            ->setCancelUrl(URL::to('/account'));

        $inputFields = new InputFields();
        $inputFields->setNoShipping(1);

        $webProfile = new WebProfile();
        $webProfile->setName('Toffee' . strtoupper(uniqid()))->setInputFields($inputFields);

        $webProfileId = $webProfile->create($this->_api_context)->getId();

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setExperienceProfileId($webProfileId)
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


        try {

            $payment->create($this->_api_context);

        } catch (PayPalConnectionException $ex) {
//            echo $ex->getCode(); // Prints the Error Code
//            echo $ex->getData(); // Prints the detailed error message
//            die($ex);
            if (Config::get('app.debug')) {

                Session::put('error', 'Connection TimeOut, check your internet connection!');

                return Redirect::to('/account');
            }
            else
            {

//                Session::put('error', 'Something Went Wrong, contact admin for support');

                return Redirect::to('/account')->with('error', 'Something Went Wrong, contact admin for support');
            }
        }
//        catch (Exception $ex) {
//            die($ex);
//        }

        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirectUrls = $link->getHref();

                break;
            }
        }

        Session::put('paypal_paymentId', $payment->getId());


        if (isset($redirectUrls)) {

            return Redirect::away($redirectUrls);
        }

        return Redirect::to('/account')->with('error', 'Sorry, something went wrong, Please restart the transaction');

    }

    public function execute_payment($package_id)
    {
        $paymentId = request('paymentId');

        if (empty(Input::get('PayerID')) || empty(Input::get('paymentId')) || empty(Input::get('token'))) {
            return Redirect::to('/account')->with('error', 'Payment did not process');
        }

        $payment = Payment::get($paymentId, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            $txn_id = $result->id;
            $state = $result->state;
            $payerFirstName = $result->payer->payer_info->first_name;
            $payerLastName = $result->payer->payer_info->last_name;
            $payerName = $payerFirstName.' '.$payerLastName;
            $payerID = $result->payer->payer_info->payer_id;
            $payerEmail = $result->payer->payer_info->email;
            $payerCountryCode = $result->payer->payer_info->country_code;
            $paidAmount = $result->transactions[0]->amount->total;
            $currency = $result->transactions[0]->amount->currency;


            $purchase_id = rand(1000,999999);
            $user_id = Auth::user()->id;

            if ($package_id == 1){
                $days = 1;
            }elseif ($package_id == 2){
                $days = 7;
            }elseif ($package_id == 3){
                $days = 31;
            }

            $exp_date = Carbon::now()->addDays($days);
            $order = new Order([
                'order_number'=> $purchase_id,
                'user_id'=>$user_id,
                'package_id'=>$package_id,
                'amount'=>$paidAmount ,
                'expires_at'=>$exp_date ,
            ]);

            $fnd = dispatch(new OrderEmail($order));
            if ($fnd){
                $order->save();

                $paymentdata=new PaypalPayment(array(
                    'user_id'=>$user_id,
                    'order_id'=>$purchase_id,
                    'package_id' =>$package_id,
                    'txn_id'=>$txn_id,
                    'payment_gross'=>$paidAmount,
                    'currency_code'=>$currency,
                    'payer_id'=>$payerID,
                    'payer_name'=>$payerName,
                    'payer_email'=>$payerEmail,
                    'payer_country'=>$payerCountryCode,
                    'payment_status'=>$state
                ));
                $paymentdata->save();
            }
            else{
                return Redirect::to('account')->with('error', 'Payment Failed');
            }
            //                Mail::send(new PaypalOrder($order));

//            Session::put('status', 'Payment was successful');
            return Redirect::to('/account/payment-success')->with('status', 'Payment made successfully!');
        }
        else
            {
//            Session::put('error', 'Payment Failed');
            return Redirect::to('account')->with('error', 'Payment Failed');
        }
    }

    public function payments_success()
    {
        return view('Users.Accounts.payments-success');
    }

    public function payment_success()
    {
        return view('Users.Accounts.payment-success');
    }
}
