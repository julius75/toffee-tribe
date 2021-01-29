@extends('layouts.system')
@section('title', 'View Location Details')
@section('content')
<style>
    .days-of-week{
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
                    <h3 class="text-center" style="color: #1a9082">{{$location->restaurant_name}}</h3>
                    <h5 class="text-center" style="color: #1a9082">Host Contacts</h5>
                    <p class="text-center">{{ $location->host_role}}: {{$location->host_name}} - {{$location->phone_number}}</p>

                    <h5 class="text-center" style="color: #1a9082">Description:</h5>
                    <p class="text-center">{{$location->description}}</p>
                    <h5 class="text-center" style="color: #1a9082">Address / Location:</h5>
                    <p class="text-center">{{$location->location}}</p>

                    <h5 class="text-center" style="color: #1a9082">Amenities Offered: </h5>
                    <p class="text-center">{!! $location->amenities !!}</p>

                    <h5 class="text-center" style="color: #1a9082">Food & Beverage </h5>
                    <p class="text-center">{!! $location->food_beverage !!}</p>

                    <h5 class="text-center" style="color: #1a9082">Days Of The Week Available:</h5>
                    <div class="days-of-week">
                        @foreach($days as $day)
                            <p class="text-center">{{$day}} - {{date('h:i A', strtotime($location->opening_time))}} - {{date('h:i A', strtotime($location->closing_time))}}</p>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="gmap_canvas map">
                        <iframe {!!  $map->iframe !!} </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
</div><br>


    @endsection