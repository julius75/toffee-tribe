@extends('layouts.master')
@section('title', 'Member Dashboard')


@section('content')
<style>
    .text-color{
        color: #1a9082;
    }
    .btn-color{
        color: #1a9082;
    }

</style>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="h3 mb-0 text-color">

        </h5>
        <p  class="d-none d-sm-inline-block btn btn-sm btn-color ">Your Invite Code is {{$user->invite_code}}</p>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        @if(Session::has('success'))
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                </div>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                </div>
            </div>
        @endif

    </div>

    <!-- Content Row -->

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-color">Visited Locations</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row justify-content-center">
                        @if($visits->isEmpty())
                            <p class="text-center">YOU ARE YET TO CHECK-IN AT ANY OF OUR AVAILABLE LOCATIONS</p>
                        @else
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Location Name</th>
                                        <th scope="col">Check-In Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($visits as $visit)
                                        <tr>
                                            <th scope="row">{{$visit->order->order_number}}</th>
                                            <td>{{$visit->restaurant->restaurant_name}} Subscription</td>
                                            <td>{{\Carbon\Carbon::parse($visit->arrival_time)->format('d M Y, h:i')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @endsection