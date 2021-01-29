
@extends('layouts.master')
@section('title', 'Add Event')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Host Registration</div>

                    <div class="card-body">
                        <form method="POST" action="" class="prevent-m-subs" enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center">
                                <h4 style="color: #1a9082">Restaurant Information</h4>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="event_name">Event Name</label>
                                    <input id="event_name" type="text" class="form-control @error('event_name') is-invalid @enderror" name="event_name" value="{{ old('event_name') }}" required autocomplete="event_name" autofocus >
                                    @error('event_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="social_link">Link to Website / Social Media Platform</label>
                                    <input id="social_link" type="text" class="form-control @error('social_link') is-invalid @enderror" name="social_link" value="{{ old('social_link') }}" required autocomplete="social_link" autofocus>
                                    @error('social_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="location" >Restaurant Location</label>
                                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required autocomplete="location">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="street" >Street Name</label>
                                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{old('street')}}" required autocomplete="street">
                                    @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="location_link" >Location Link</label>
                                    <input id="location_link" type="text" class="form-control @error('location_link') is-invalid @enderror" name="location_link" value="{{old('location_link')}}" required autocomplete="location_link">
                                    @error('location_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row justify-content-center">
                                <div class="form-group col-md-4">
                                    <label for="total_capacity">Total sitting Capacity</label>
                                    <input id="total_capacity" type="number" min="0" class="form-control @error('total_capacity') is-invalid @enderror" name="total_capacity" value="{{ old('total_capacity') }}" required autocomplete="total_capacity">
                                    @error('total_capacity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="tribe_capacity">Sitting Capacity available to Toffee Tribe</label>
                                    <input id="tribe_capacity" type="number" min="0" class="form-control @error('tribe_capacity') is-invalid @enderror" name="tribe_capacity" value="{{ old('tribe_capacity') }}" required autocomplete="capacity">
                                    @error('tribe_capacity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="form-row" data-duplicate="phone" >
                                <div class=" form-group col-md-4">
                                    <div class="has-feedback{{ $errors->has('day[]') ? ' has-error' : '' }}">
                                        <label>Day of the week<span class="asterisk">*</span></label>
                                        <div class="dropdown">
                                            <select class="dropdown-menu browser-default custom-select" name="day[]">
                                                <option disabled selected>Select Day of the Week</option>
                                                <option class="dropdown-item"  value="Sunday">Sunday</option>
                                                <option class="dropdown-item"  value="Monday">Monday</option>
                                                <option class="dropdown-item"  value="Tuesday">Tuesday</option>
                                                <option class="dropdown-item"  value="Wednesday">Wednesday</option>
                                                <option class="dropdown-item"  value="Thursday">Thursday</option>
                                                <option class="dropdown-item"  value="Friday">Friday</option>
                                                <option class="dropdown-item"  value="Saturday">Saturday</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3 ">
                                    <label for="close_time[]">Till (Close) <small>(12hr time format)</small></label>
                                    <input id="close_time[]" type="time" class="form-control @error('close_time[]') is-invalid @enderror" name="close_time[]" value="{{ old('close_time[]') }}"  autocomplete="close_time[]">
                                    @error('close_time[]')
                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <hr>
{{--                            <div class="form-row">--}}
{{--                                <div class="form-group col-md-6">--}}
{{--                                    <label for="description">Location Description</label>--}}
{{--                                    <textarea required class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Provide an enticing description about this location..."></textarea>--}}
{{--                                    @error('description')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="form-group col-md-6">--}}
{{--                                    <label for="amenities">Amenities Offered</label>--}}
{{--                                    <textarea required class="form-control @error('description') is-invalid @enderror" id="amenities" name="amenities" placeholder="List Amenities eg. - WiFi, - Power Sockets"></textarea>--}}
{{--                                    @error('food_beverage')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="food_beverage" >Food & Beverage</label>
                                    <select class="form-control @error('food_beverage') is-invalid @enderror" name="food_beverage" id="food_beverage" required>
                                        <option value="">Choose an option</option>
                                        <option value="Onsite ordering only ; no outside food.">Onsite ordering only ; no outside food.</option>
                                        <option value="Members allowed to carry their own food & drink">Members allowed to carry their own food</option>
                                    </select>
                                    @error('food_beverage')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="image">Select Event Image</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror"/>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <hr>
                            <div class="row justify-content-end">
                                <button type="submit" id="checkBtn" class="btn btn-outline-primary button-prevent mr-2">
                                    Add Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
