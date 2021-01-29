<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome to ToffeeTribe</title>

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
                    <a href="{{ url('http://toffeetribe.com/toffeetribe/') }}">Home</a>
                </div>

                <div class="top-right links">
                    @auth
                        <a href="{{ url('/member_dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
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

</body>
</html>