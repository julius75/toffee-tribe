<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Invoice</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        .text-right {
            text-align: right;
        }
        .theme-text{
            color: #1a9082;
        }
    </style>

</head>
<body class="login-page" style="background: white">

<div>
    <div class="row">
        <div class="col-xs-7">
            <h4>From:</h4>
            <strong class="theme-text">ToffeeTribe</strong><br>
            Nairobi, Kenya<br>
            Phone Number: 0724073864 <br>
            Mail: info@toffeetribe.com <br>

            <br>
        </div>

        <div class="col-xs-4">
            <img src="http://dashboard.toffeetribe.com/logo.png" style="height: 65px; width: 120px">
        </div>
    </div>

    <div style="margin-bottom: 0px">&nbsp;</div>

    <div class="row">
        <div class="col-xs-4">
            <h4>To:</h4>
            <address>
                <strong>{{$user->full_name}}</strong><br>
                <span>{{$user->email}}</span> <br>

            </address>
        </div>

        <div class="col-xs-8">
            <table style="width: 90%">
                <tbody>
                <tr>
                    <th>Order Number:</th>
                    <td class="text-right theme-text">{{$order->order_number}}</td>
                </tr>
                <tr>
                    @if($paypal != null)
                        <th>Paypal Transaction Number:</th>
                        <td class="text-right theme-text">{{$paypal->txn_id}}</td>
                    @elseif($mpesa != null)
                        <th>M-PESA Transaction Number:</th>
                        <td class="text-right theme-text">{{$mpesa->mpesaReceiptNumber}}</td>
                    @else
                        <th>Type:</th>
                        <td class="text-right theme-text">Admin Approved Ticket</td>
                    @endif
                </tr>
                <tr>
                    <th> Date of Purchase: </th>
                    <td class="text-right theme-text">{{\Carbon\Carbon::parse($order->created_at)->format('d M Y')}}</td>
                </tr>
                <tr>
                    <th> Date of Expiry: </th>
                    <td class="text-right theme-text">{{\Carbon\Carbon::parse($exp_date)->format('d M Y')}}</td>
                </tr>
                </tbody>
            </table>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <table style="width: 90%; margin-bottom: 20px">
                <tbody>
                <tr class="well" style="padding: 5px">
                    <th style="padding: 5px"><div> Amount Paid : </div></th>
                    <td style="padding: 5px" class="text-right"><strong> KSH. {{$order->amount}}</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <table class="table">
        <thead style="background: #F5F5F5;">
        <tr>
            <th class="theme-text">Subscription Details</th>
            <th></th>
            <th class="text-right">Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><div><strong class="theme-text">ToffeTribe - {{$order->package->name}} pass</strong></div>
                <p>{{$order->package->details}}</p></td>
            <td></td>
            <td class="text-right"> KSH. {{$order->amount}}</td>
        </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-5">
            <table style="width: 100%">
                <tbody>
                <tr class="well" style="padding: 5px">
                    <th style="padding: 5px"><div> Paid Amount </div></th>
                    <td style="padding: 5px" class="text-right"><strong>  KSH. {{$order->amount}} </strong></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-bottom: 0px">&nbsp;</div>

    <div class="row">
        <div class="col-xs-8 invbody-terms">
            Thank you for your purchase. <br>
            <br>
          </div>
    </div>
</div>

</body>
</html>