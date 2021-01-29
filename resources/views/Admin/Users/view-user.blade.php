@extends('layouts.system')
@section('title', 'User Profile')


@section('content')
    <style>
        .text-color{
            color: #1a9082;
        }
    </style>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row">
                            <p class="ml-3" style="color: #1a9082"><b>User Details</b></p>
                        </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="full_name">Full Name</label>
                                    <input readonly id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $user->full_name }}" required autocomplete="full_name" autofocus>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="username">@username</label>
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required readonly autocomplete="username" autofocus>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="phone_number" >Phone Number</label>
                                    <input readonly id="phone_number" type="tel" pattern="\d{4}\d{3}\d{3}" title="'Phone Number (Format: 0712345678)'" class="form-control @error('phone_number') is-invalid @enderror " name="phone_number" value="{{ $user->phone_number }}"  maxlength="10" required autocomplete="phone_number" autofocus>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="location">Location</label>
                                    <input readonly id="location" type="text" class="form-control @error('location') is-invalid @enderror" value="{{$user->location}}" name="location" autocomplete="location" autofocus>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="grind">Occupation</label>
                                    <input readonly id="grind" type="text" class="form-control @error('grind') is-invalid @enderror" value="{{$user->grind}}" name="grind" autocomplete="grind" autofocus>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="company">Company</label>
                                    <input readonly id="company" type="text" class="form-control @error('company') is-invalid @enderror" value="{{$user->company}}" name="company" autocomplete="company" autofocus>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="industry">Industry</label>
                                    <input readonly id="industry" type="text" class="form-control @error('industry') is-invalid @enderror" name="industry"  value="{{$user->industry}}" autocomplete="industry" autofocus>

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="info_source">Information Source</label>
                                    <input readonly id="info_source" type="text" class="form-control @error('info_source') is-invalid @enderror" value="{{$user->info_source}}" name="info_source" autocomplete="info_source" autofocus>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="message">Bio</label>
                                    <textarea class="form-control" id="message" name="message" readonly>{{$user->bio}}</textarea>
                                </div>
                            </div>
                        <hr>
                        <div class="row">
                            <p class="ml-3" style="color: #1a9082"><b>User Orders</b></p>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <thead>
                                        @if($orders->isEmpty())
                                            <th colspan="7" class="text-center">NO RECORDS</th>
                                        @else
                                        <tr>
                                            <th scope="col">id</th>
                                            <th scope="col">Order Number</th>
                                            <th scope="col">Package</th>
                                            <th scope="col">Amount($)</th>
                                            <th scope="col">Date Purchased</th>
                                            <th scope="col">End of Validity</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <th scope="row">{{$order->id}}</th>
                                                <td>{{$order->order_number}}</td>
                                                <td>{{$order->package->name}}</td>
                                                <td>{{$order->amount}}</td>
                                                <td>{{\Carbon\Carbon::parse($order->created_at)->format('d M Y h:i')}}</td>
                                                <td>{{\Carbon\Carbon::parse($order->expires_at)->format('d M Y h:i')}}</td>
                                                <td>@if(\Carbon\Carbon::now() >= $order->expires_at)
                                                        <h6><span class="badge badge-danger">EXPIRED</span></h6>
                                                    @else
                                                        <h6><span class="badge badge-success">ACTIVE</span></h6>
                                                    @endif</td>
                                                <td>
                                                    <a class="btn btn-warning btn-sm" href="{{route('view.order', ['orderId'=>$order->order_number])}}"><small>View</small></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

@endsection