@extends('layouts.master')
@section('title', 'Purchase a plan')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <div class="row">
                        <div class="col-md-12">
                            <p class="alert alert-success">{{ \Illuminate\Support\Facades\Session::get('success') }}</p>
                        </div>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Session::has('error'))
                    <div class="row">
                        <div class="col-md-12">
                            <p class="alert alert-danger">{{ \Illuminate\Support\Facades\Session::get('error') }}</p>
                        </div>
                    </div>
                @endif
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Selected Plan</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">{{$package->name}}</h6>
                            <small class="text-muted">{{$package->period}}</small>
                        </div>
                        <span class="text-muted">Ksh. {{$package->amount}}</span>
                    </li>
                    @if(\Illuminate\Support\Facades\Session::has('promo_code'))
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code activated</h6>
{{--                            <small>{{$valid_code}}</small>--}}
                        </div>
                        <span class="text-success">50% 0FF</span>
                    </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        @if(\Illuminate\Support\Facades\Session::has('promo_code'))
                        <strong>Ksh. {{$discount}}</strong>
                        @else
                            <strong>Ksh. {{$total}}</strong>
                        @endif
                    </li>
                </ul>
                @if(\Illuminate\Support\Facades\Session::has('promo_code'))
                        <b style="color: #1a9082">AN INVITE CODE HAS BEEN ACTIVATED, PROCEED TO BUY NOW AND ENJOY 50% OFF YOUR SUBSCRIPTION CHARGE</b>
                    @else
                <form action="{{route('promo')}}" method="post" class="card p-2">
                    @csrf
                    <div class="input-group">
                        <input hidden id="user_id" name="user_id" value="{{$user->id}}">
                        <input type="text" id="invite_code" name="invite_code" class="form-control  @error('invite_code') is-invalid @enderror" placeholder="Promo code" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                        @error('invite_code')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </form>
                    @endif
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Member Details</h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name">Name</label>
                            <input type="text" class="form-control" id="full_name" value="{{$user->full_name}}" placeholder="" required="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username">Username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" value="{{$user->username}}" class="form-control" id="username" placeholder="Username" required="">
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" value="{{$user->email}}"id="email">
                    </div>


                    <hr class="mb-4">

                    <h5 class="mb-3">Confirm details and proceed to payment</h5>

                        <form method="post" class="prevent-m-subs" action="{{route('create-payment')}}">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name">Package Name</label>
                                    <input readonly type="text" class="form-control" value="Toffee Tribe - {{$package->name}}" id="name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="period">Package Period</label>
                                    <input readonly type="text" class="form-control" value="{{$package->period}}" id="period">
                                </div>
                                <input hidden name="pkg" value="{{encrypt($package->id)}}">
                                <input hidden name="toffeetribe" value="{{encrypt($value)}}">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="details">Package Details</label><br>
                                    <textarea readonly rows="3" cols="35"  style="border-color:  #d1d3e2; color: #858796; background-color: #eaecf4;-webkit-border-radius: .35rem; -moz-border-radius: .35rem; border-radius: .35rem;">{{$package->details}}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="ml-2 mb-2 btn btn-outline-primary btn-sm button-prevent">
                               Pay With PayPal
                            </button>
                        </form>
                <button type="button" class="ml-2 mb-3 btn btn-sm btn-outline-success" data-toggle="modal" data-target="#mpesaModal">
                    Pay With M-Pesa
                </button>

                <div class="modal fade" id="mpesaModal" tabindex="-1" role="dialog" aria-labelledby="modLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modLabel">Pay With M-PESA</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="{{route('mpesa.payment')}}">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            @if(\Illuminate\Support\Facades\Session::has('promo_code'))
                                                <p> Amount to be paid: KES {{$discount}}</p>
                                            @else
                                                <p> Amount to be paid: KES {{$total}}</p>
                                            @endif
                                            <input hidden name="pkg" value="{{encrypt($package->id)}}">
                                            <input hidden name="toffeetribe" value="{{encrypt($value)}}">
                                            <label for="phone_number">Confirm M-Pesa Phone Number</label>
                                            <input required id="phone_number" name="phone_number" value="{{$user->phone_number}}">
                                        </div>
                                    </div>


{{--                                <p><b>If you did not receive a prompt, you may pay manually</b></p>--}}
{{--                                <p>Go to your M-Pesa menu</p>--}}
{{--                                <p>Select Lipa na M-Pesa</p>--}}
{{--                                <p>Select Paybill</p>--}}
{{--                                <p>Enter Business Number: 761221</p>--}}
{{--                                <p>Enter Account Number: {{$package->account}}</p>--}}
{{--                                @if(\Illuminate\Support\Facades\Session::has('promo_code'))--}}
{{--                                    <p> Enter amount: KES {{$discount}}</p>--}}
{{--                                @else--}}
{{--                                    <p> Enter amount: KES {{$total}}</p>--}}
{{--                                @endif--}}
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
{{--    <div id="paypal-button"></div>--}}
{{--    <script src="https://www.paypalobjects.com/api/checkout.js"></script>--}}
{{--    <script>--}}
{{--        paypal.Button.render({--}}
{{--            env: 'sandbox', // Or 'production'--}}
{{--            style: {--}}
{{--                size: 'medium',--}}
{{--                color: 'gold',--}}
{{--                shape: 'pill',--}}
{{--            },--}}
{{--            // Set up the payment:--}}
{{--            // 1. Add a payment callback--}}
{{--            payment: function(data, actions) {--}}
{{--                // 2. Make a request to your server--}}
{{--                return actions.request.post('/api/create-paypal-payment')--}}
{{--                    .then(function(res) {--}}
{{--                        // 3. Return res.id from the response--}}
{{--                        // console.log(res);--}}
{{--                        return res.id;--}}
{{--                    });--}}
{{--            },--}}
{{--            // Execute the payment:--}}
{{--            // 1. Add an onAuthorize callback--}}
{{--            onAuthorize: function(data, actions) {--}}
{{--                // 2. Make a request to your server--}}
{{--                return actions.request.post('/api/execute-paypal-payment', {--}}
{{--                    paymentID: data.paymentID,--}}
{{--                    payerID:   data.payerID--}}
{{--                })--}}
{{--                    .then(function(res) {--}}
{{--                        // console.log(res);--}}
{{--                        alert('PAYMENT WENT THROUGH!!');--}}
{{--                        // 3. Show the buyer a confirmation message.--}}
{{--                    });--}}
{{--            }--}}
{{--        }, '#paypal-button');--}}
{{--    </script>--}}
    @endsection
