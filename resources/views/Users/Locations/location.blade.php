@extends('layouts.master')
@section('title', 'View Location Details')
@section('content')
<style>
    .theme-text{
        color: #1a9082;
    }
    .days-of-week{
        margin-top: 10px;
    }
    .map{
        margin-top: 40px;
    }
</style>
        <div class="col-md-12">
            <div class="card" style="height:auto; width: 100%;">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{asset('storage/app/location-images/'.$location->image)}}"   alt="First slide">
                        </div>
                        @foreach($images as $image)
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{asset($image->image_path)}}"  style= "object-fit: fill;  object-position: center;  height: 80%;  width: 100%;" alt="Second slide">
                            </div>
                            @endforeach

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                <hr>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            @if($location->set_closed == 1)
                                    <p class="text-center mb-0"><i class="fa fa-circle fa-xs" style="color: grey"></i> Closed For Today</p>
                            @else
                                @if(strstr($location->days->implode('day_of_week', ','), $weekday))
                                    @if($location->tribe_capacity == 0)
                                        <p class="mt-1 text-center mb-0"><i class="fa fa-circle fa-xs" style="color: grey"></i> NO SITTING  SPACE AVAILABLE</p>
                                    @else
                                    <p class="text-center mb-0"><i class="fa fa-circle fa-xs" style="color: #0fdb5e"></i> Available</p>
                                 <p class="text-center mb-0" style="color: #1a9082; font-size: 18px;">Available Spaces: {{$location->tribe_capacity}}</p>

                                    @endif
                                @else
                                    <p class="text-center mb-0"><i class="fa fa-circle fa-xs" style="color: grey"></i> Closed</p>
                                @endif
                            @endif
                        <h1 class="theme-text text-center mt-0" style="font-weight: bolder">{{$location->restaurant_name}}</h1>

                            <h5 class="theme-text text-center">Description:</h5>
                            <p class="text-center">{{$location->description}}</p>
                            <h5 class="text-center theme-text">Address / Location:</h5>
                            <p class="text-center">{{$location->location}}</p>

                            <h5 class="text-center theme-text">Amenities Offered: </h5>
                            <p class="text-center">{!! $location->amenities !!}</p>

                            <h5 class="text-center theme-text">Food & Beverage </h5>
                            <p class="text-center">{!! $location->food_beverage !!}</p>

                            <h5 class="text-center theme-text">Days Of The Week Available:</h5>
                            <div class="days-of-week">
                                @if($days != null)
                                        @foreach($days as $day)
        {{--                                    <p class="text-center">{{$day}} - {{date('h:i A', strtotime($location->opening_time))}} - {{date('h:i A', strtotime($location->closing_time))}}</p>--}}
                                            <p class="text-center">{{$day->day_of_week}} - {{date('h:i A', strtotime($day->opening_time))}} - {{date('h:i A', strtotime($day->closing_time))}}</p>
                                        @endforeach
                                 @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="gmap_canvas map">
                                <iframe {!! $location_map->iframe !!} </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
        </div><br>
    @endsection