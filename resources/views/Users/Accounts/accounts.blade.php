@extends('layouts.master')
@section('title', 'Account Information')

@section('content')
    <style>
        .theme-text{
            color: #1a9082;
        }
    </style>
    <div class="container">
        @if(Session::has('success'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-success text-center">{{ Session::get('success') }}</p>
                </div>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-danger text-center">{{ Session::get('error') }}</p>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
{{--            <h5>Your free trial begins when you enter one of our spaces.</h5>--}}
            <p>We have spaces conveniently located all across Nairobi. Whenever you're ready to join us full-time, check out our plans below.</p>
        </div>
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
                <br>
                <h4 class="my-0 font-weight-normal theme-text" >Day Pass</h4>
                <div class="card-body">
                    <h2 class="card-title pricing-card-title theme-text" >KHS. {{number_format($day->amount)}} <small class="theme-text">one day</small></h2>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>- Access to all our locations -</li><hr>
                        <li>- 8 working hours -</li><hr>
                        <li>- Reserved Seating -</li><hr>
                        <li>- High speed wifi -</li><hr>
                        <li>- Unlimited Coffee & tea</li><hr>
{{--                        <li>- Guest visit ksh.300 -</li><hr>--}}
                        <li>- Access to our slack community, events and parties -</li><hr>
                    </ul>
                    <a href="{{route('checkout', ['slug'=> $day->slug])}}" class="btn btn-outline-secondary">Purchase</a>
                </div>
            </div>




{{--            WEEKLY                --}}
            <div class="card mb-4 box-shadow">
                <br>
                <h4 class="my-0 font-weight-normal theme-text" >Weekly</h4>
                <div class="card-body">
                    <h2 class="card-title pricing-card-title theme-text" >KSH. {{number_format($weekly->amount)}} <small class=" theme-text">/ week</small></h2>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>- Access to all our locations -</li><hr>
                        <li>- 10 working hours -</li><hr>
                        <li>- Reserved seating -</li><hr>
                        <li> - High speed Wifi -</li><hr>
                        <li>- Unlimited Coffee & Tea -</li><hr>
{{--                        <li>- 6 hours free of  2 guest visits -</li><hr>--}}
                        <li>- Access to our slack community, events and parties -</li><hr>
                    </ul>
                    <form method="post" action="">
                        @csrf
                        <input hidden value="{{$weekly}}"/>
                    </form>
                    <a href="{{route('checkout', ['slug'=> $weekly->slug])}}" class="btn btn-outline-secondary">Purchase</a>
                </div>
            </div>



            <div class="card mb-4 box-shadow">
                <br>
                <h4 class="my-0 font-weight-normal theme-text" >Monthly</h4>
                <div class="card-body">
                    <h2 class="card-title pricing-card-title theme-text" >  KSH. {{number_format($monthly->amount)}} <small class="theme-text" >/ month</small></h2>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>- Access to all our locations -</li><hr>
                        <li>- 10 working hours -</li><hr>
                        <li>- Reserved seating -</li><hr>
                        <li> - High speed Wifi -</li><hr>
                        <li>- Unlimited Coffee & Tea -</li><hr>
{{--                        <li>- Access to 2 guest visits -</li><hr>--}}
                        <li>- Access to our slack community, events and parties -</li><hr>
                    </ul>
                    <a href="{{route('checkout', ['slug'=> $monthly->slug])}}" class="btn btn-outline-secondary">Purchase</a>
                </div>
            </div>
        </div>
    </div>
    @endsection