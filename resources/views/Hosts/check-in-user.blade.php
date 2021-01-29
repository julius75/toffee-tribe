@extends('layouts.admin')
@section('title', 'Check In User')

@section('content')
    <div class="container-fluid">
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
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
            <div class="card col-md-10">
                <div class="card-body">
                    <div class="row">
                        <h4 class="mt-4 ml-3" style="color: #1a9082">Order Description</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <small class="mt-0" style="color: #1a9082; font-weight: bolder">ORDER NUMBER: {{$order->order_number}}</small><br>
                            @if($paypal != null)
                                <small class="mt-0" style="color: #1a9082; font-weight: bolder">PAYPAL TRANSACTION CODE: {{$paypal->txn_id}}</small><br>
                            @elseif($mpesa != null)
                                <small class="mt-0" style="color: #1a9082; font-weight: bolder">MPESA TRANSACTION CODE: {{$mpesa->mpesaReceiptNumber}}</small><br>
                            @else
                                <small class="mt-0" style="color: #1a9082; font-weight: bolder">FREE PASS</small><br>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <small class="mt-0" style="color: #1a9082; font-weight: bolder">MEMBER NAME : {{$user->full_name}}</small><br>
                            <small class="mt-0" style="color: #1a9082; font-weight: bolder">EMAIL ADDRESS : {{$user->email}}</small><br>
                            <small class="mt-0" style="color: #1a9082; font-weight: bolder">PHONE NUMBER : {{$user->phone_number}}</small><br>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Subscription Description</th>
                                    <th scope="col">Amount Paid</th>
                                    <th scope="col">Date of Purchase</th>
                                    <th scope="col">Date of Expiry</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">TOFFEE TRIBE - {{$order->package->name}}</th>
                                    <td>{{$order->amount}}</td>
                                    <td>{{\Carbon\Carbon::parse($order->created_at)->format('d M Y')}}</td>
                                    <td>{{\Carbon\Carbon::parse($order->expires_at)->format('d M Y')}} <small style="font-size: 10px; color: #1a9082">END OF DAY</small></td>
                                    <td>@if(\Carbon\Carbon::now() >= $order->expires_at)
                                            <h6><span class="badge badge-danger">EXPIRED</span></h6>
                                        @else
                                            <h6><span class="badge badge-success">ACTIVE</span></h6>
                                        @endif</td>
                                    <td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form method="post" action="{{route('host.record.visit')}}" class="prevent-m-subs">
                        @csrf
                        <input hidden name="restaurant_id" value="{{$location->id}}">
                        <input hidden name="order_number" value="{{$order->order_number}}">
                        <input hidden name="order_id" value="{{$order->id}}">
                        <input hidden name="user_id" value="{{$user->id}}">
                        <button type="submit" id="checkBtn" class="btn btn-outline-secondary button-prevent mr-2">
                            Check-In
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
