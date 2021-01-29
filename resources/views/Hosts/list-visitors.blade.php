@extends('layouts.admin')
@section('title', 'Checked In Visitors')
@section('content')
    <div class="container">
        <div class="row">
            <h4 style="color: #1a9082">{{$location->restaurant_name}} visitors </h4>
        </div>
        <div class="row">
            <h4 style="color: #1a9082">Total Visits {{count($visits)}}</h4>
        </div>
        <br>
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Order Number</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Package Type</th>
                                    <th scope="col">Arrival Time</th>
                                    <th scope="col">Departure Time</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($visits->isEmpty())
                                    <th colspan="8" style="text-align: center">LOCATION IS YET TO RECORD ANY VISITS</th>
                                    @endif
                                @foreach($visits as $visit)
                                    <tr>
                                        <th scope="row">{{$visit->id}}</th>
                                        <td>{{$visit->order_number}}</td>
                                        <td>{{$visit->user->full_name}}</td>
                                        <td>{{$visit->user->email}}</td>
                                        <td>{{$visit->order->package->name}}</td>
                                        <td>{{\Carbon\Carbon::parse($visit->arrival_time)->format('d M Y, h:i')}}</td>
                                        @if($visit->departure_time == null)
                                            <td>--</td>
                                        @else
                                        <td>{{\Carbon\Carbon::parse($visit->departure_time)->format('d M Y, h:i')}}</td>
                                        @endif
                                        <td>
                                            @if($visit->departure_time == null)
                                                <a class="btn btn-warning btn-sm" href="{{route('host.checkout.visitor',['id'=>$visit->id, 'slug'=>$location->slug])}}"><small>Check-Out</small></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection