<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ToffeeTribe Home</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .top-left {
            position: absolute;
            left: 5px;
            top: 18px;
        }
        .content {
            text-align: center;
        }
        .title {
            font-size: 84px;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body >
<div class="flex-center position-ref full-height">
    <div class="content" >
        <div class="flex-center position-ref full-height" >
            @if (Route::has('login'))

                <div class="top-left links">
                    <a href="{{ url('http://toffeetribe.com/toffeetribe/') }}">Return to Website</a>

                </div>

                <div class="top-right links">
                    @auth
                        <a href="{{ url('/member_dashboard') }}">View your Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <p style="color: #1a9082">YOU ARE ALREADY LOGGED IN!</p>
                <div class="title m-b-md" style="color: #1a9082">
                    TOFFEE TRIBE
                </div>

                <div class="links">
                    @auth
                        <a href="{{route('member.account')}}">Account</a>
                        <a href="{{route('member.locations')}}">Locations</a>
                        <a href="{{route('member.profile', ['username'=>\Illuminate\Support\Facades\Auth::user()->username])}}">Profile</a>

                    @endauth
                </div>
            </div>
        </div>

    </div>
</div>

{{--<div id="paypal-button"></div>--}}
{{--<script src="https://www.paypalobjects.com/api/checkout.js"></script>--}}
{{--<script>--}}
{{--    paypal.Button.render({--}}
{{--        env: 'sandbox', // Or 'production'--}}
{{--        style: {--}}
{{--            size: 'large',--}}
{{--            color: 'gold',--}}
{{--            shape: 'pill',--}}
{{--        },--}}
{{--        // Set up the payment:--}}
{{--        // 1. Add a payment callback--}}
{{--        payment: function(data, actions) {--}}
{{--            // 2. Make a request to your server--}}
{{--            return actions.request.post('/api/create-payment')--}}
{{--                .then(function(res) {--}}
{{--                    // 3. Return res.id from the response--}}
{{--                    // console.log(res);--}}
{{--                    return res.id;--}}
{{--                });--}}
{{--        },--}}
{{--        // Execute the payment:--}}
{{--        // 1. Add an onAuthorize callback--}}
{{--        onAuthorize: function(data, actions) {--}}
{{--            // 2. Make a request to your server--}}
{{--            return actions.request.post('/api/execute-payment', {--}}
{{--                paymentID: data.paymentID,--}}
{{--                payerID:   data.payerID--}}
{{--            })--}}
{{--                .then(function(res) {--}}
{{--                    console.log(res);--}}
{{--                    alert('PAYMENT WENT THROUGH!!');--}}
{{--                    // 3. Show the buyer a confirmation message.--}}
{{--                });--}}
{{--        }--}}
{{--    }, '#paypal-button');--}}
{{--</script>--}}
</body>
</html>