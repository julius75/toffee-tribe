@extends('layouts.master')
@section('title', 'Events')

@section('content')
    <style>
        .scheme_default h5 {
            color: #222327;
        }

        .scheme_default .single-tribe_events .type-tribe_events {
            border-color: #e1e1e3;
        }

        .single-tribe_events .type-tribe_events {
            padding-top: 0;
        }

        .single-tribe_events .tribe-events-event-image {
            float: left;
            width: 40%;
            margin: 0.4em 3% 2em 0;
        }

        .single-tribe_events .tribe-events-event-image {
            text-align: left;
            margin-bottom: 1.25em;
        }

        .single-tribe_events .tribe-events-event-image {
            clear: both;
            margin-bottom: 30px;
            text-align: center;
        }

        .tribe-events-event-image {
            margin-bottom: 1.25em;
            text-align: left;
        }

        .tribe-events-event-image {
            margin: 0 0 20px;
            text-align: center;
        }

        .tribe-events-event-image img {
            height: auto;
            max-width: 100%;
        }

        img {
            max-width: 100%;
            height: auto;
            vertical-align: top;
        }

        img {
            max-width: 100%;
            height: auto;
            vertical-align: top;
        }

        img {
            width: 100%;
        }

        .tribe-events-event-image + div.tribe-events-content {
            width: 57%;
            overflow: hidden;
        }

        .single-tribe_events .tribe-events-content {
            max-width: 100%;
            padding: 0;
            width: 100%;
        }

        h5 {
            font-size: 1.2em;
            font-weight: 400;
            font-style: normal;
            line-height: 1.65em;
            text-decoration: none;
            text-transform: none;
            letter-spacing: -0.2px;
            margin-top: 3em;
            margin-bottom: 0.8em;
        }

        .single-tribe_events .tribe-events-cal-links {
            margin-bottom: 1.75em;
            display: block;
        }

        .single-tribe_events .tribe-events-cal-links {
            margin-bottom: 1.75em;
            display: block;
        }

        .tribe-events-cal-links {
            margin-bottom: 1.75em;
            display: block;
        }

        .tribe-events-sub-nav {
            font-family: "Montserrat", sans-serif;
            font-weight: 400;
            font-style: normal;
            text-decoration: none;
            text-transform: uppercase;
            color: #ffffff;
            background-color: #135F52;
            border-color: #135F52;
            -webkit-appearance: none;
            cursor: pointer;
            display: inline-block;
            white-space: nowrap;
            padding: 1.1em 2.45em;
            font-size: 12px;
            line-height: 18px;
            letter-spacing: 0;
            margin-right: 1.25em;
            -webkit-border-radius: 24px;
            border-radius: 24px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            border-width: 1px !important;
            border-style: solid;
        }

        .single-tribe_events .tribe-events-cal-links {
            clear: both;
        }

        .single-tribe_events .tribe-events-single-section {
            clear: none;
            float: left;
            width: 50%;
            margin: 0;
            padding: 3em 0 0;
            border: none;
            background-color: transparent;
        }

        .single-tribe_events .tribe-events-event-meta {
            font-size: 1em;
        }



        .tribe-events-event-meta {
            background: #fafafa;
            border: 1px solid #eee;
            margin: 30px 0;
        }

        .tribe-events-meta-group {
            box-sizing: border-box;
            display: inline-block;
            float: left;
            margin: 0 0 20px;
            padding: 0 1%;
            text-align: left;
            vertical-align: top;
            zoom: 1;
        }
        .tribe-events-meta-groups {
            box-sizing: border-box;
            display: inline-block;
            float: left;
            margin: 0 0 20px;
            padding: 0 1%;
            text-align: left;
            vertical-align: top;
            zoom: 1;
        }

        .tribe-events-event-meta .tribe-events-meta-group {
            box-sizing: border-box;
            display: inline-block;
            float: left;
            margin: 0 0 20px;
            padding: 0 4%;
            text-align: left;
            vertical-align: top;
            zoom: 1;
        }

        .single-tribe_events .tribe-events-event-meta .tribe-events-meta-group + .tribe-events-meta-group {
            margin-left: 3em;
        }

        .single-tribe_events .tribe-events-event-meta .tribe-events-meta-group {
            padding: 0;
            margin: 0;

        }
.title-event{
    font-weight: 700;
    margin: 20px 0 10px;
    font-size: 1.2em;
}
.event-label{
    font-size: 1.0667em;
    letter-spacing: 0;
    font-style: italic;
    font-weight: 400;
    line-height: 1.4em;
    color: #222327;
}
.venue-map{
    color: #7f7f7f;
    background: #ffffff;
    border: 1px solid #dadada;
    border-radius: 3px;
    display: inline-block;
    float: right;
    margin: 20px 4% 2% 0;
    padding: 5px;
    vertical-align: top;
    width: 90%;
    zoom: 1;
}
.description{
    color: #222327;
    font-size: 1.2em;
    font-weight: 400;
    font-style: normal;
    line-height: 1.65em;
    text-decoration: none;
    text-transform: none;
    letter-spacing: -0.2px;
    margin-top: 3em;
    margin-bottom: 0.8em;
}

    </style>
    <div class="container">
        @if(Session::has('success'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-success text-center">{{ Session::get('success') }}</p>
                </div>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-danger text-center">{{ Session::get('error') }}</p>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <p>This are daily events details. Continue, check out our plans below.</p>
        </div>
        <div class="row" style="margin-top: 8px">
            <div class="row" style="margin-top: 8px">
                <div class="col-md-6">
                    <div class="tribe-events-event-image">
                        <img width="400" height="400" class="d-block"
                             src="{{asset('storage/app/location-images/'.$event->image)}}" alt="Logo"
                             style="width: 100%;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="" style="overflow: hidden;max-width: 100%;padding: 0;width: 100%;">
                        <h5 class="kvgmc6g5 cxmmr5t8 oygrvhab hcukyx3x c1et5uql">{{$event->name}}</h5>
                        <h5 class="description">{{nl2br($event->description)}} </h5>
                    </div>
                </div>
            </div>
            <div class="row">
            </div>
                <div class=" row tribe-events-single-section" style="width: -webkit-fill-available;">
                    <div class="col-md-3">
                    <div class="tribe-events-meta-group">
                        <h2 class="tribe-events-single-section-title title-event"> Details </h2>
                        <dl>
                            <dt class="event-label">Date:</dt>
                            <dd>
                                <abbr class="tribe-events-abbr tribe-events-start-date published dtstart"
                                      title="2020-12-03"> December 3 </abbr>
                            </dd>

                            <dt class="event-label"> Time:</dt>
                            <dd>
                                <div class="tribe-events-abbr tribe-events-start-time published dtstart"
                                     title="2020-12-03">
                                    {{date('h:i A', strtotime($event->starting_time))}} - {{date('h:i A', strtotime($event->ending_time))}}
                                </div>
                            </dd>


                            <dt class="event-label"> Cost:</dt>
                            <dd class="tribe-events-event-cost"> Kshs.{{$event->price}}</dd>

                            <dt class="event-label">Event Categories:</dt>
                            <dd class="tribe-events-event-categories">
                                <a href=""
                                    rel="tag">{{$event->category}}</a></dd>
                            <dt class="event-label">Event Tags:</dt>
                            <dd class="tribe-event-tags">
                                <a href="" rel="tag">Cafecoworking</a>
                            </dd>
                        </dl>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="tribe-events-meta-group">
                        <h2 class="tribe-events-single-section-title title-event">Organizer</h2>
                        <dl>
                            <dt style="display:none;"></dt>
                            <dd class="tribe-organizer">
                                ToffeeTribe
                            </dd>
                            <dt class="event-label">
                                Email:
                            </dt>
                            <dd class="tribe-organizer-email">
                                hello@toffeetribe.com
                            </dd>
                            <dt class="event-label">
                                Website:
                            </dt>
                            <dd class="tribe-organizer-url">
                                <a href="" target="_self">www.toffeetribe.com</a></dd>
                        </dl>
                    </div>
                    </div>
                    <div class="col-md-2">
                    <div class="tribe-events-meta-groups">
                        <h2 class="tribe-events-single-section-title title-event"> Venue </h2>
                        <dl>

                            <dd class="tribe-venue">{{$event->location}}</dd>

                            <dd class="tribe-venue-location">
                                <address class="tribe-events-address">
					<span class="tribe-address">
		        <br>
		        <span class="tribe-locality">Nairobi</span><span class="tribe-delimiter">,</span>
	            <span class="tribe-country-name">Kenya</span>
                                 </span>
                                    <a class="tribe-events-gmap"
                                       href="{{$location->location_link}}"
                                       title="Click to view a Google Map" target="_blank">+ Google Map</a></address>
                            </dd>

                        </dl>
                    </div>
                    </div>
                    <div class="col-md-4">

                    <div class="venue-map">
                        <div class="gmap_canvas map">
                            <iframe width="100%" height="350px"  {!!  $map->iframe !!} </iframe>
                        </div>

                    </div>
                </div>
                    <a href="{{route('purchase_form', ['slug'=> $event->slug])}}" class="btn btn-outline-secondary">Purchase</a>
                </div>
@endsection
