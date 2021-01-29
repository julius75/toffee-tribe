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
    
    @if(Session::has('success'))
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                </div>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="row">
                <div class="col-md-8">
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                </div>
            </div>
        @endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="h3 mb-0 text-color">Member Dashboard</h5>
         @if($subscriber == null)
        <!--<p  class="d-none d-sm-inline-block btn btn-sm btn-color ">-->
        <!--    Your Invite Code is {{$user->invite_code}}-->
        <!--</p>-->
        @else
        <p  class="d-none d-sm-inline-block btn btn-sm btn-color ">
            <!--Your Invite Code is {{$user->invite_code}}-->
            @if($subscriber->status == 0)
            <button class="btn text-white" style="background-color:#1A9082" data-toggle="modal" data-target="#dayPass">
                Activate your Free Day-Pass
            </button>
            @endif
        </p>
        @endif
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Your Purchases</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">KSH {{$revenue}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-money-bill-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Current Subscription</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$current_package}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Profile Completion</div>
                            <div class="row no-gutters align-items-center">
                                @if($user->location and $user->grind and $user->company and $user->industry and $user->info_source != null)
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">100%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                    @elseif($user->location or $user->grind or $user->company or $user->industry or $user->info_source == null)
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">70%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @elseif($user->location and $user->grind and $user->company and $user->industry and $user->info_source == null)
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">20%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-color">My Subscriptions</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row justify-content-center">
                        @if($orders->isEmpty())
                            <p class="text-center">YOU CURRENTLY DO NOT HAVE ANY ORDERS, purchase a subscription <a href="{{route('member.account')}}">here</a></p>
                        @else
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Package Name</th>
                                        <th scope="col">Amount(KSH)</th>
                                        <th scope="col">Date Paid</th>
                                        <th scope="col">Date of Expiry</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <th scope="row">{{$order->order_number}}</th>
                                            <td>{{$order->package->name}} Subscription</td>
                                            @if($order->amount > 0)
                                                <td>{{$order->amount}}</td>
                                            @else
                                                <td>FREE PASS</td>
                                            @endif
                                            <td>{{\Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i')}}</td>
                                            <td>{{\Carbon\Carbon::parse($order->expires_at)->format('d M Y, h:i')}}</td>
                                            <td>@if(\Carbon\Carbon::now() >= $order->expires_at)
                                                <h6><span class="badge badge-danger">EXPIRED</span></h6>
                                                @else
                                                <h6><span class="badge badge-success">ACTIVE</span></h6>
                                                @endif</td>
                                            <td>
                                                <a class="btn btn-warning btn-sm" href="{{route('order', ['orderId'=>$order->order_number])}}"><small>View</small></a>
                                            </td>
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

@if($subscriber != null)
<div class="modal fade" id="dayPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="w-100 modal-title text-center" id="exampleModalLabel">
              Activate Day Pass
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
                  Proceed to activate your <b>FREE DAY PASS</b>?<br>
                  It will be valid as from 
                  <b>
                    {{Carbon\Carbon::now()->format('d-M-Y')}}
                  </b> to
                  <b>
                    {{Carbon\Carbon::tomorrow()->format('d-M-Y')}}
                  </b>
              
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm">
            <a href="{{url('/subscriber/update', $subscriber->id)}}" style="color: white;text-decoration: none;">
              Activate
            </a>
          </button>
        </div>
      </div>
    </div>
  </div>
  @endif

    @endsection