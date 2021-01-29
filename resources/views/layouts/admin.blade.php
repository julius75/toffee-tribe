<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/submit.js') }}" defer></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/submit.css') }}" rel="stylesheet">
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 1px grey;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #1a9082;
            border-radius: 5px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: gray;
        }
    </style>
    @yield('css')
</head>
<body >

    <div id="app">
        <nav style="background-color: #155f53" class="navbar navbar-expand-md navbar-light shadow-sm fixed-top">
            <div class="container">
                @if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    <img src="{{asset('logo.png')}}" style="height: 35px; width: 125px">
                </a>
                @else
                    <a class="navbar-brand" href="{{ route('host.home') }}">
                        <img src="{{asset('logo_white.png')}}" style="height: 35px; width: 130px">
                    </a>
                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
                        <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('member.index')}}" style="color: white">Member-Dashboard</a>
                        </li>
                        <li class="nav-item active">
                             <a class="nav-link" href="{{route('reg.users')}}" style="color: white">Users </a>
                         </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('list.locations')}}" style="color: white">Locations</a>
                        </li>

                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('list.packages')}}" style="color: white">Packages</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a style="color: white" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                                Orders and Revenue
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('list.orders')}}">Orders</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('mpesa.payments')}}">MPESA Payments</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('pp.payments')}}">PayPal Payments</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('promo.codes')}}">Invite Codes / Promotions</a>
                            </div>
                        </li>

                    </ul>
                    @endif
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a style="color: white" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
<br>
<br>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('js')
</body>
</html>
