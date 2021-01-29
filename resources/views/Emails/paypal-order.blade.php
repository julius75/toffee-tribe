<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ToffeeTribe Purchase Receipt</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        @import url(http://fonts.googleapis.com/css?family=Bree+Serif);
        body, h1, h2, h3, h4, h5, h6{
            /*font-family: 'Bree Serif', serif;*/
        }

        table.borderless td,table.borderless th{
            border: none !important;
        }
    </style>
</head>
<body>

<div align="container">

    <div style="background-color: #155F53;" class="row">
        <div class="col-xs-6">
            <h1>
                <a href="https://www.toffeetribe.com/toffeetribe/">
                    <img style="width: 166.5px; height: 52.3px;" src="https://dashboard.toffeetribe.com/logo_white.png">
                </a>
            </h1>
        </div>
    </div>

    <br><br>
    <p>Hi {{$order->user->full_name}},</p>

    <p>Welcome to the ToffeeTribe Family!</p>
    @if($order->amount > 0)
            < <p>This receipt confirms the payment for your purchase.</p>
        @else
             <p>You have successfully activated your free day pass.</p>
        @endif

    <p>Order ID: <span style="color: #155F53;"><strong>{{$order->order_number}}</strong></span> </p>

    <p>Date of Purchase:  <span style="color: #155F53;"><strong> {{\Carbon\Carbon::parse($order->created_at)->format('D, d M Y')}}</strong></span> </p>
    <p>Date of Expiry:  <span style="color: #155F53;"><strong>{{\Carbon\Carbon::parse($order->expires_at)->format('D, d M Y')}}</strong></span> </p>
    <table class="table borderless">
        <thead>
        <tr>
            <th><h4><strong>Subscription Info</strong></h4></th>
            <th><h4><strong>Amount(Ksh)</strong></h4></th>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td >{{$order->package->name}}</td>
            @if($order->amount > 0)
                <td >{{$order->amount}}</td>
            @else
                <td >FREE PASS</td>
            @endif    
        </tr>


        <tr>

            <!-- Without Sub Total -->
            <td>Total</td>
            <td>{{$order->amount}}</td>

            <!-- With Sub Total -->

            <!-- <td ></td>
            <td class="pull-left" >
             	<strong>
				Sub Total : 750 <br>
				TAX : 0 <br>
				Total : 750 <br>
				</strong>
			</td> -->




        </tr>
        </tbody>
    </table>
        <div align="center" class="text-center"><span style="color: #155F53;">Choose your location, scan QR Code to check-in, HAPPY WORK DAY!</span> <br>
            <a style="text-decoration: none;" title="Download ToffeeTribe Check-In App here" href="https://play.google.com/store/apps/details?id=io.ionic.mato">
                <img style="width: 129.2px; height: 50px;" src="https://toffeetribe.com/emImages/playstore.png">
                 
            </a>
        </div>

    <div class="row">
        <div class="col-xs-12">
            <!-- White BG C. Details -->
            <div style="border-color: transparent;" class="panel panel-info">
                <div class="panel-body">
                    <h4 align="center" style="color: #000">ToffeeTribe</h4>
                    <div align="center">
                        <img style="width: 50.2px; height: 50.2px; margin-right: 20px;" src="https://dashboard.toffeetribe.com/facebook.png">
                        <img style="width: 50.2px; height: 50.2px; margin-right: 20px;" src="https://dashboard.toffeetribe.com/twitter.png">
                        <img style="width: 50.2px; height: 50.2px; margin-right: 20px;" src="https://dashboard.toffeetribe.com/instagram.png">
                        <br>
                        <br>
                        <a href="https://www.toffeetribe.com/" align="center">https://www.toffeetribe.com/</a>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>
