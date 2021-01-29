@extends('layouts.checkIn')
@section('title', 'CONNECT COFFEE Check In')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <img src="{{asset('logo_white.png')}}" style="width: 200px; height: 80px" class="mb-3">
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                <h5 class="text-white mb-3">Welcome to Connect Coffee!</h5>
                <h6 class="text-white mb-3">Scan the QR-Code below using our ToffeeTribe app to check yourself in</h6>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9 col-xs-8">
                    <div class="row justify-content-center">
                            <div class="text-center">
                                <img src="{{asset('QR-checkin/connectcoffee.jpeg')}}" style="width: 70%; height: 100%" alt="Image not found">
                            </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

