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

    <p>This receipt confirms the payment for your purchase.</p>

    <p>Order ID: <span style="color: #155F53;"><strong>{{$order->order_number}}</strong></span> </p>

    <p>Date of Purchase:  <span style="color: #155F53;"><strong> {{\Carbon\Carbon::parse($order->created_at)->format('D, d M Y, h:i a')}}</strong></span> </p>
    <p>Date of Expiry:  <span style="color: #155F53;"><strong>{{\Carbon\Carbon::parse($order->expires_at)->format('D, d M Y, h:i a')}}</strong></span> </p>
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
            <td >{{$order->amount}}</td>
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

    <br><br>

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
