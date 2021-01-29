@extends('layouts.master')
@section('title', 'Available Locations')
@section('content')
    <style>
        .stretched-link::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1;
            pointer-events: auto;
            content: "";
            background-color: rgba(0,0,0,0);
        }
        .bod:hover{
            background-color: #f0f5f4;
            color: #1a9082;
        }


         .wabebe:link {
             color: #1a9082;
         }

        /* visited link */
        .wabebe:visited {
            color: black;
        }

        /* mouse over link */
        .wabebe:hover {
            color: grey;
        }

        /* selected link */
        .wabebe:active {
            color: blue;
        }
    </style>

    <div class="container-fluid">
        <div class="row justify-content-center">
            @if($locations->isEmpty())
                <h3 class="text-center">There are currently no available locations</h3>
            @else
            <div class="col-md-6">
                <div class="card" >
                    <div class="card-body" style="overflow-y: scroll; height:550px;">
                        <ul class="list-group list-group-flush">
                            @foreach($locations as $location)
                                <div class="mb-2">
                                    <div class="card mb-3 bod">
                                        <div class="row no-gutters">
                                            <div class="col-md-6">
                                                <a href="{{route('location', ['slug'=> $location->slug])}}">
                                                    <img src="{{asset('storage/app/location-images/'.$location->image)}}" class="card-img" style="height: 100%; width: 100%; object-fit: cover; object-position: center" >
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card-body">
{{--                                                    <a href="{{route('location', ['slug'=> $location->slug])}}" class="stretched-link"></a>--}}
                                                    <h6 class="mb-2">{{$location->location}}</h6>
                                                    @if($location->set_closed == 1)
                                                        <small class="mt-0 mb-0"><i class="fa fa-circle fa-xs" style="color: grey"></i> Closed For Today</small>
                                                    @else
                                                        @if(strstr($location->days->implode('day_of_week', ','), $weekday))
                                                            @if($location->tribe_capacity == 0)
                                                                <small class="mt-1 mb-0"><i class="fa fa-circle fa-xs" style="color: grey"></i> NO SITTING SPACE AVAILABLE</small>
                                                            @else
                                                                <small class="mt-0 mb-0"><i class="fa fa-circle fa-xs" style="color: #0fdb5e"></i> Available</small>
                                        <small class="card-title ml-3" style="color: #1a9082">Available Spaces: {{$location->tribe_capacity}}</small>

                                                            @endif
                                                        @else
                                                            <small class="mt-0 mb-0"><i class="fa fa-circle fa-xs" style="color: grey"></i> Closed</small>
                                                        @endif
                                                    @endif
                                                        <h4 class="card-title mb-2" style="color: #1a9082">{{$location->restaurant_name}}</h4>

                                                    @if($location->set_closed != 1)
                                                        @if(strstr($location->days->implode('day_of_week', ','), $weekday))
                                                            <h6 class="mb-0 mt-0">Today: {{date('h:ia', strtotime($location->opening_time))}} - {{date('h:ia', strtotime($location->closing_time))}}</h6>
                                                        @endif
                                                    @endif

                                                    <br>
                                                    <br>
                                                    <br>
                                                    <a class="wabebe" href="{{$location->location_link}}"><small><i class="fas fa-directions"></i> {{$location->street}}</small></a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-md-6">
                <div class="gmap_canvas">
{{--                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15955.604892629028!2d36.8050662!3d-1.2285054!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6c60a00831d0e4b4!2sKarel%20T-Lounge!5e0!3m2!1sen!2ske!4v1570457268857!5m2!1sen!2ske" width=100% height="550" frameborder="0" style="border:0;" allowfullscreen=""></iframe><br>--}}
                    <iframe {!! $location_map->iframe !!} </iframe>
                </div>
            </div>
            @endif
    </div>
    </div>

    @endsection
