<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
.body {
    margin: 0;
}
.head {
    background-color: #155f53;
    height: 100px;
    width: 100%;
}
.logo {
    text-align: center;
    height: 40px;
    width: 80px;
}
.qr {
    height: 150px;
    width: 150px;
    text-align: center;
}
.footer {
    height: 100px;
    width: 100%;
    background-color: darkcyan;
}
.margin {
    margin: 0 20px 0 20px;
}
.pull {
    padding-right: 20px;
}
</style>
<body>
    <div class="body">
        <table class="head">
            <thead>
                <th>
                    <img src="{{'logo_white.png'}}" alt="Logo" class="logo" style="color:white;">
                </th>
            </thead>
        </table>
        <br>
        <table width="100%" class="margin">
            <thead>
                <tr>
                    <th>
                        <b>Subscription</b> {{$order['2']}} <br>
                        <b>Tribe Member</b> {{$order['1']}} <br>
                        <b>Phone</b> {{$order['7']}} <br>
                        <b>Email</b> {{$order['3']}} <br>
                        <b>Date</b> {{Carbon\Carbon::now()->format('d M Y')}} <br>
                        <b>Valid from: {{Carbon\Carbon::parse($order['4'])->format('d M Y, h:i')}} Expires at: {{Carbon\Carbon::parse($order['5'])->format('d M Y, h:i')}}</b>
                    </th>
                    <th align="right" class="pull">
                        <p>ORDER NUMBER {{$order['0']}}</p>
                        <p>Paid Amount KSH {{$order['6']}}</p>
                    </th>
                </tr>
            </thead>
        </table>
        <br>
        <table width="100%" class="margin">
            <thead>
                <tr>
                    <th>
                        <p align="center"><b>PAID</b></p>
                        <p>
                            YOU MAY PRINT OR DISPLAY THIS TICKET AT <br>
                            THE LOCATION. <br>
                            DUPLICATES WILL BE DETECTED AND REJECTED. <br>
                            ANY QUESTION ABOUT YOUR TICKET? <br>
                            EMAIL US AT info@toffeetribe.com <br>
                            DO NOT SHARE YOUR QR-CODE.
                        </p>
                    </th>
                    <th align="center">
                        <img src="{{$path}}" alt="QR-CODE" class="qr">
                    </th>
                </tr>
            </thead>
        </table>
        <br>
        <table class="footer">
            <thead>
                <th align="center" style="color:white;">
                    <p>Toffee Tribe<br>
                    https://toffeetribe.com</p>
                </th>
            </thead>
        </table>
    </div>
</body>
</html>