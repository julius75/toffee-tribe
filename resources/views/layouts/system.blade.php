<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link href="{{asset('assets/fonts/fonts.googleapis.com/css0e2b.css?family=Open+Sans:400,600')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/feather/css/feather.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/icofont/css/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">
    <!-- custom overrides -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/datepicker/jquery.datetimepicker.css')}}">

    {{-- <script src="{{ asset('js/app.js') }}" ></script> --}}
    <script src="{{ asset('js/submit.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/submit.css') }}" rel="stylesheet">
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>

    @yield('css')
</head>
<body>
<div class="theme-loader">
<div class="ball-scale">
<div class='contain'>
<div class="ring">
<div class="frame"></div>
</div>
</div>
</div>
</div>

<div id="pcoded" class="pcoded">
<div class="pcoded-overlay-box"></div>
<div class="pcoded-container navbar-wrapper">
  <nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
    <div class="navbar-logo" style="background-color:#fff;">
    <a class="mobile-menu" id="mobile-collapse" href="#!">
    <i class="feather icon-menu" style="color:black;"></i>
    </a>
    <a href="index-2.html">
    <img class="img-fluid" src="{{asset('assets/images/logo.png')}}" alt="Company Logo" style="height: 45px; with: 170px;text-align:center;"/>
    </a>
    <a class="mobile-options">
    <i class="feather icon-more-horizontal"></i>
    </a>
    </div>
    <div class="navbar-container container-fluid">
    <ul class="nav-left">
    <li class="header-search">
    <div class="main-search morphsearch-search">
    <div class="input-group">
     <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
    <input type="text" class="form-control">
    <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
    </div>
    </div>
    </li>
    <li>
    <a href="#!" onclick="javascript:toggleFullScreen()">
    <i class="feather icon-maximize full-screen"></i>
    </a>
    </li>
    </ul>
    <ul class="nav-right">
    <li class="user-profile header-notification">
    <div class="dropdown-primary dropdown">
    <div class="dropdown-toggle" data-toggle="dropdown">
    <img src="{{asset('assets/images/avatar.png')}}" class="img-radius" alt="Admin Profile">
    <span>{{ Auth::user()->username }}</span>
    <i class="feather icon-chevron-down"></i>
    </div>
    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
    <li>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="feather icon-log-out"></i> Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
    </li>
    </ul>
    </div>
    </li>
    </ul>
    </div>
    </div>
    </nav>

<div class="pcoded-main-container">
<div class="pcoded-wrapper">
<nav class="pcoded-navbar">
<div class="pcoded-inner-navbar main-menu">
<div class="pcoded-navigatio-lavel">Navigation</div>
<ul class="pcoded-item pcoded-left-item">

<li class="">
<a href="/toffee-admin">
<span class="pcoded-micon"><i class="feather icon-home"></i></span>
<span class="pcoded-mtext">Admin-Dashboard</span>
</a>
</li>

<li class="">
<a href="{{route('member.index')}}">
<span class="pcoded-micon"><i class="feather icofont icofont-users-alt-5"></i></span>
<span class="pcoded-mtext">Member-Dashboard</span>
</a>
</li>

<li class="">
<a href="{{route('reg.users')}}">
<span class="pcoded-micon"><i class="feather icon-users"></i></span>
<span class="pcoded-mtext">Users</span>
</a>
</li>

<li class="">
<a href="{{route('list.locations')}}">
<span class="pcoded-micon"><i class="feather icofont icofont-location-pin"></i></span>
<span class="pcoded-mtext">Locations</span>
</a>
</li>

    <li class="">
        <a href="{{route('list.events')}}">
            <span class="pcoded-micon"><i class="feather icofont icofont-package"></i></span>
            <span class="pcoded-mtext">Events</span>
        </a>
    </li>
    <li class="">
        <a href="{{route('list.tickets')}}">
            <span class="pcoded-micon"><i class="feather icofont icofont-money-bag"></i></span>
            <span class="pcoded-mtext">Events Revenue</span>
        </a>
    </li>
<li class="">
<a href="{{route('list.packages')}}">
<span class="pcoded-micon"><i class="feather icofont icofont-package"></i></span>
<span class="pcoded-mtext">Packages</span>
</a>
</li>

<li class="pcoded-hasmenu">
<a href="javascript:void(0)">
<span class="pcoded-micon"><i class="feather icofont icofont-money-bag"></i></span>
<span class="pcoded-mtext">Orders and Revenue</span>
</a>
<ul class="pcoded-submenu">
<li class=" ">
<a href="{{route('list.orders')}}">
<span class="pcoded-mtext">Orders</span>
</a>
</li>
<li class=" ">
<a href="{{route('mpesa.payments')}}">
<span class="pcoded-mtext">Mpesa Payments</span>
</a>
</li>
<li class=" ">
<a href="{{route('manual.payments')}}">
<span class="pcoded-mtext">Mpesa Manual Entry</span>
</a>
</li>
<li class=" ">
<a href="{{route('pp.payments')}}">
<span class="pcoded-mtext">Paypal Payments</span>
</a>
</li>
<li class=" ">
<a href="{{route('promo.codes')}}">
<span class="pcoded-mtext">Invite Codes / Promotions</span>
</a>
</li>
</ul>
</li>

<li class="pcoded-hasmenu">
<a href="javascript:void(0)">
    <span class="pcoded-micon"><i class="feather icofont icofont-map-pins"></i></span>
    <span class="pcoded-mtext">Location Visits</span></a>
    <ul class="pcoded-submenu">
        <?php
        $locations = \App\Restaurant::all();                                     foreach ($locations as $location){
                $slug = $location->slug;
        ?>
<li class=" ">
<a href="{{route('list.visitors',['slug'=>$slug])}}">
<span class="pcoded-mtext">{{$location->restaurant_name}}</span>
</a>
</li>
<?php }?>
</ul>
</li>



</ul>

</div>
</nav>
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<div class="page-body">
<div class="row">
@yield('content')
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@yield('js')
<script type="text/javascript" src="{{ asset('bower_components/jquery/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/popper.js/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/modernizr/js/modernizr.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/SmoothScroll.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('assets/js/vartical-layout.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/script.min.js') }}"></script>
<!-- custom scripts -->
<script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/jquery.datetimepicker.full.js') }}"></script>
{{-- @yield('js') --}}
</body>
</html>
