<?php

use Illuminate\Http\Request;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\WebProfile;
use PayPal\Api\InputFields;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/toffee-reset-capacities', 'ApiController@reset_capacities');


//Route::post('/user-login', 'ApiController@login');
Route::post('/user-login', 'ApiController@login');

Route::middleware('auth:api')->post('/user-logout', 'ApiController@logout');
Route::middleware('auth:api')->get('/user-orders', 'ApiController@myOrders');
Route::middleware('auth:api')->get('/user-visits', 'ApiController@myVisits');
Route::middleware('auth:api')->post('/check-order-status', 'ApiController@checkOrderStatus');
Route::middleware('auth:api')->post('/user-checkin', 'ApiController@userCheckIn');

Route::get('/all-orders', 'ApiController@index')->name('api.orders.all');


Route::post('create-paypal-payment', 'PaypalPaymentController@create_payment')->name('create-payment');

//Route::post('execute-paypal-payment', 'PaypalPaymentController@execute_payment')->name('execute-payment');

//Route::post('create-payment', function () {
//    $apiContext = new ApiContext(
//        new OAuthTokenCredential(
//            'AXeuYhOGeKYWNS-6zOOfh4e54RnWvPCte2uyPsK-v6-ZlOquofhmUER7wJIPAEUYJ3exOhKJv_jlTQT1',     // ClientID
//            'EClX-lKUHIsFkNSk8J9BBEz_e3MI96LL4HGRvpdad035PCwRnTRP5JLzeJ_zLX8WFCwstneA_hJ7Inn-'      // ClientSecret
//        )
//    );
//    $payer = new Payer();
//    $payer->setPaymentMethod("paypal");
//    $item1 = new Item();
//    $item1->setName('Ground Coffee 40 oz')
//        ->setCurrency('USD')
//        ->setQuantity(1)
//        ->setSku("123123") // Similar to `item_number` in Classic API
//        ->setPrice(7.5);
//    $item2 = new Item();
//    $item2->setName('Granola bars')
//        ->setCurrency('USD')
//        ->setQuantity(5)
//        ->setSku("321321") // Similar to `item_number` in Classic API
//        ->setPrice(2);
//    $itemList = new ItemList();
//    $itemList->setItems(array($item1, $item2));
//    $details = new Details();
//    $details->setShipping(1.2)
//        ->setTax(1.3)
//        ->setSubtotal(17.50);
//    $amount = new Amount();
//    $amount->setCurrency("USD")
//        ->setTotal(20)
//        ->setDetails($details);
//    $transaction = new Transaction();
//    $transaction->setAmount($amount)
//        ->setItemList($itemList)
//        ->setDescription("Payment description")
//        ->setInvoiceNumber(uniqid());
//    $redirectUrls = new RedirectUrls();
//    $redirectUrls->setReturnUrl("http://127.0.0.1:8000/account/payment-success")
//        ->setCancelUrl("http://127.0.0.1:8000/account/");
//    // Add NO SHIPPING OPTION
//    $inputFields = new InputFields();
//    $inputFields->setNoShipping(1);
//    $webProfile = new WebProfile();
//    $webProfile->setName('test' . uniqid())->setInputFields($inputFields);
//    $webProfileId = $webProfile->create($apiContext)->getId();
//    $payment = new Payment();
//    $payment->setExperienceProfileId($webProfileId); // no shipping
//    $payment->setIntent("sale")
//        ->setPayer($payer)
//        ->setRedirectUrls($redirectUrls)
//        ->setTransactions(array($transaction));
//    try {
//        $payment->create($apiContext);
//    } catch (Exception $ex) {
//        echo $ex;
//        exit(1);
//    }
//    return $payment;
//});
//Route::post('execute-payment', function (Request $request) {
//    $apiContext = new ApiContext(
//        new OAuthTokenCredential(
//            'AXeuYhOGeKYWNS-6zOOfh4e54RnWvPCte2uyPsK-v6-ZlOquofhmUER7wJIPAEUYJ3exOhKJv_jlTQT1',     // ClientID
//            'EClX-lKUHIsFkNSk8J9BBEz_e3MI96LL4HGRvpdad035PCwRnTRP5JLzeJ_zLX8WFCwstneA_hJ7Inn-'      // ClientSecret
//        )
//    );
//    $paymentId = $request->paymentID;
//    $payment = Payment::get($paymentId, $apiContext);
//    $execution = new PaymentExecution();
//    $execution->setPayerId($request->payerID);
//
//    try {
//        $result = $payment->execute($execution, $apiContext);
//    } catch (Exception $ex) {
//        echo $ex;
//        exit(1);
//    }
//    return $result;
//});
