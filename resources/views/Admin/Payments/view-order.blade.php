@extends('layouts.system')
@section('title', 'View Order')

@section('content')
    <div class="container-fluid">
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
                                <small class="mt-0" style="color: #1a9082; font-weight: bolder">ADMIN APPROVED TICKET</small><br>
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
                                    <th scope="row">TOFFEE TRIBE - {{$order->package->name}} pass</th>
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
{{--                    <a href="{{route('download.pdf',['orderId'=>$order->order_number])}}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Download Report</a>--}}
{{--                    <a href="{{route('pdf',['orderId'=>$order->order_number])}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>--}}
                </div>
            </div>
        </div>

    </div>
@endsection
