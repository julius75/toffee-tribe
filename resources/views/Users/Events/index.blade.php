@extends('layouts.master')
@section('title', 'Events')

@section('content')
    <style>
        .theme-text{
            color: #1a9082;
        }

    </style>
    <div class="container">
        @if(!$events)
            <h3 class="text-center">There are currently no available locations</h3>
        @else

        <div class="row justify-content-center">
            <p>This are daily events. Whenever you're ready to attend, check out our plans below.</p>
        </div>
        @foreach($events as $event)
                <a href="{{route('event.show',$event->slug)}}" style="text-decoration: none">
                    <div class="" style="background-color: #ebeced;display: flex;overflow: hidden;position: relative;">
                     <span class="sc_events_item_date" style="display: grid;">
		            <span class="sc_events_item_day" style="padding-top: 0.5rem;padding-right: 1.25rem;padding-left: 1.25rem;background-color: #222327;color: #ffffff">{{\Carbon\Carbon::parse($event->date)->format('d')}}</span>
		            <span class="sc_events_item_month" style="padding-bottom: 0.5rem;padding-right: 1.25rem;padding-left: 1.25rem;background-color: #222327;color: #ffffff">{{\Carbon\Carbon::parse($event->date)->format('M')}}</span>
	                </span>
                        <span class="sc_events_item_title" style="padding: 1.25rem;top: 50%;left: 8em;color: #292929;font-size: 1.1429em;line-height: 1.3em;max-width: 75%;padding-right: 3em;">{{$event->name}}</span>

                    </div>
                </a>

          <br>
        @endforeach


        @endif
    </div>
    @endsection
