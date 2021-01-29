@extends('layouts.system')
@section('title', 'View Event Details')
@section('content')
<style>
    .days-of-week{
        margin-top: 40px;
    }
</style>
<div class="col-md-12">
    <h5  class="justify-content-start"> <a href="{{route('list.events')}}" style="color: #1a9082">Back</a></h5>

    <div class="card" style="height:auto; width: 100%;">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{asset('storage/app/location-images/'.$event->image)}}">
                </div>

        <hr>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h3 class="text-center" style="color: #1a9082">{{$event->name}}</h3>

                    <h5 class="text-center" style="color: #1a9082">Description:</h5>
                    <p class="text-center">{{$event->description}}</p>
                    <h5 class="text-center" style="color: #1a9082">Address / Location:</h5>
                    <p class="text-center">{{$event->location}}</p>

                    <h5 class="text-center" style="color: #1a9082">Days Of The Event:</h5>
                            <p class="text-center">{{$event->date}}</p>
                    <h5 class="text-center" style="color: #1a9082">Time Of The Event:</h5>
                    <p class="text-center"><h6 class="text-center" style="color: #1a9082">Starting Time: {{date('h:i A', strtotime($event->starting_time))}}</h6>
                    </p>
                    <p class="text-center"><h6 class="text-center" style="color: #1a9082">Closing Time: {{date('h:i A', strtotime($event->ending_time))}}</h6>
                    </p>
                </div>

            </div>
        </div>
    </div>
    <h5  class="justify-content-start"> <a href="{{route('list.events')}}" style="color: #1a9082">Back</a></h5>

    <br>

</div><br>


@endsection
