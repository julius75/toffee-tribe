@extends('layouts.system')
@section('title', 'Update Toffee Tribe Host')
@section('content')
    // <script type="text/javascript">
        // $(document).ready(function () {
            // $('#checkBtn').click(function() {
                // checked = $("input[type=checkbox]:checked").length;
                // if(!checked) {
                    // alert("You must select at least one day available for Toffee Tribe members");
                    // return false;
                // }

            // });
        // });


        // function sunday() {
        //     var checkBox = document.getElementById("Sunday");
        //     var open = document.getElementById("sunday_opening_time");
        //     var close = document.getElementById("sunday_closing_time");
        //     if (checkBox.checked === true){
        //         open.style.display = "block";
        //         close.style.display = "block";
        //     } else {
        //         open.style.display = "none";
        //         close.style.display = "none";
        //     }
        // }

    <!--</script>-->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Update {{$location->restaurant_name}} Information</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('host.update')}}" class="prevent-m-subs" enctype="multipart/form-data">
                            <input hidden name="id" value="{{$location->id}}">

                            @csrf
                                <div class="row justify-content-center">
                                    <h4 style="color: #1a9082">Update Restaurant Information</h4>
                                </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="restaurant_name">Restaurant Name</label>
                                        <input id="restaurant_name" type="text" class="form-control @error('restaurant_name') is-invalid @enderror" name="restaurant_name" value="{{$location->restaurant_name}}" required autocomplete="restaurant_name" autofocus>
                                    @error('restaurant_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="social_link">Link to Website / Social Media Platform</label>
                                    <input id="social_link" type="text" class="form-control @error('social_link') is-invalid @enderror" name="social_link" value="{{$location->social_link}}" required autocomplete="social_link" autofocus>
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
                                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{$location->location}}" required autocomplete="location">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="street" >Street Name</label>
                                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{$location->street}}" required autocomplete="street">
                                    @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="location_link" >Location Link</label>
                                    <input id="location_link" type="text" class="form-control @error('location_link') is-invalid @enderror" name="location_link" value="{{$location->location_link}}" required autocomplete="location_link">
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
                                    <input id="total_capacity" type="number" min="0" class="form-control @error('total_capacity') is-invalid @enderror" name="total_capacity" value="{{$location->total_capacity}}" required autocomplete="total_capacity">
                                    @error('total_capacity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="tribe_capacity">Sitting Capacity available to Toffee Tribe</label>
                                    <input id="tribe_capacity" type="number" min="0" class="form-control @error('tribe_capacity') is-invalid @enderror" name="tribe_capacity" value="{{$location->tribe_capacity}}" required autocomplete="capacity">
                                    @error('tribe_capacity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!--<div class="form-row">-->

                            <!--    <div class="form-group col-md-8">-->
                            <!--        <label for="day_available">Select days available for Toffee Tribe users: </label>-->
                            <!--        <br>-->

                            <!--        <div class="form-check form-check-inline">-->
                            <!--            <input class="form-check-input" type="checkbox" id="Sunday"  name="day_available[]" value="Sunday" @if(in_array("Sunday", $day_available)) checked @endif>-->
                            <!--            <label class="form-check-label" for="Sunday">Sunday</label>-->
                            <!--        </div><br>-->

                            <!--        <div class="form-check form-check-inline">-->
                            <!--            <input class="form-check-input" type="checkbox" id="Monday" name="day_available[]" value="Monday" @if(in_array("Monday", $day_available)) checked @endif>-->
                            <!--            <label class="form-check-label" for="Monday">Monday</label>-->
                            <!--        </div><br>-->
                            <!--        <div class="form-check form-check-inline">-->
                            <!--            <input class="form-check-input" type="checkbox" id="Tuesday" name="day_available[]" value="Tuesday" @if(in_array("Tuesday", $day_available)) checked @endif>-->
                            <!--            <label class="form-check-label" for="Tuesday">Tuesday</label>-->
                            <!--        </div><br>-->
                            <!--        <div class="form-check form-check-inline">-->
                            <!--            <input class="form-check-input" type="checkbox" id="Wednesday" name="day_available[]" value="Wednesday" @if(in_array("Wednesday", $day_available)) checked @endif>-->
                            <!--            <label class="form-check-label" for="Wednesday">Wednesday</label>-->
                            <!--        </div><br>-->
                            <!--        <div class="form-check form-check-inline">-->
                            <!--            <input class="form-check-input" type="checkbox" id="Thursday" name="day_available[]" value="Thursday" @if(in_array("Thursday", $day_available)) checked @endif>-->
                            <!--            <label class="form-check-label" for="Thursday">Thursday</label>-->
                            <!--        </div><br>-->
                            <!--        <div class="form-check form-check-inline">-->
                            <!--            <input class="form-check-input" type="checkbox" id="Friday" name="day_available[]" value="Friday" @if(in_array("Friday", $day_available)) checked @endif>-->
                            <!--            <label class="form-check-label" for="Friday">Friday</label>-->
                            <!--        </div><br>-->
                            <!--        <div class="form-check form-check-inline">-->
                            <!--            <input class="form-check-input" type="checkbox" id="Saturday" name="day_available[]" value="Saturday" @if(in_array("Saturday", $day_available)) checked @endif>-->
                            <!--            <label class="form-check-label" for="Saturday">Saturday</label>-->
                            <!--        </div><br>-->
                            <!--    </div>-->

                            <!--    <div class="form-group col-md-2">-->
                            <!--        <label for="opening_time">From <small>(24hr time format)</small></label>-->
                            <!--        <input id="opening_time" type="time" class="form-control @error('opening_time') is-invalid @enderror" name="opening_time" value="{{$location->opening_time}}"  autocomplete="opening_time">-->
                            <!--        @error('opening_time')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->

                            <!--    <div class="form-group col-md-2">-->
                            <!--        <label for="closing_time">Till <small>(24hr time format)</small></label>-->
                            <!--        <input id="closing_time" type="time" class="form-control @error('closing_time') is-invalid @enderror" name="closing_time" value="{{$location->closing_time}}"  autocomplete="closing_time">-->
                            <!--        @error('closing_time')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->
                            <!--</div>-->

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="description">Location Description</label>
                                    <textarea required id="description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Provide an enticing description about this location...">{{$location->description}}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>

                                <div class="form-group col-md-6">
                                    <label for="amenities">Amenities Offered</label>
                                    <textarea required id="amenities" name="amenities" class="form-control @error('amenities') is-invalid @enderror" placeholder="List Amenities eg. - WiFi, - Power Sockets">{{$location->amenities}}</textarea>
                                    @error('amenities')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="food_beverage" >Food & Beverage</label>
                                    <select class="form-control" name="food_beverage" id="food_beverage">
                                        <option value="Onsite ordering only ; no outside food." {{$foodnbev == "Onsite ordering only ; no outside food."  ? 'selected' : ''}}>Onsite ordering only ; no outside food.</option>
                                        <option value="Members allowed to carry their own food & drink" {{$foodnbev == "Members allowed to carry their own food & drink"  ? 'selected' : ''}}>Members allowed to carry their own food</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="image">Select Main Image</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror"/>

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <hr>

                            <!--<div class="row justify-content-center">-->
                            <!--    <h4  style="color: #1a9082">Host Information</h4>-->
                            <!--</div>-->


                            <!--<div class="form-row">-->
                            <!--    <div class="form-group col-md-6">-->
                            <!--        <label for="host_name" >Full Name</label>-->
                            <!--        <input id="host_name" type="text" maxlength="50" class="form-control @error('host_name') is-invalid @enderror" name="host_name" value="{{$location->host_name}}"  autocomplete="host_name" autofocus>-->

                            <!--        @error('host_name')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->

                            <!--    <div class="form-group col-md-3">-->
                            <!--        <label for="host_role" >Role</label>-->
                            <!--        <input id="host_role" type="text" maxlength="20" class="form-control @error('host_role') is-invalid @enderror" name="host_role" value="{{$location->host_role}}"  autocomplete="host_role" autofocus>-->

                            <!--        @error('host_role')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->

                            <!--    <div class="form-group col-md-3">-->
                            <!--        <label for="phone_number">Phone Number</label>-->
                            <!--        <input id="phone_number" type="tel" pattern="\d{4}\d{3}\d{3}" title="'Phone Number (Format: 0712345678)'" class="form-control @error('phone_number') is-invalid @enderror " name="phone_number" value="{{$location->phone_number}}"   maxlength="10" required autocomplete="phone_number" autofocus>-->

                            <!--        @error('phone_number')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->

                            <!--</div>-->

                            <div class="row justify-content-center">
                                    <button type="submit" id="checkBtn" class="btn btn-lg btn-outline-primary button-prevent">
                                        Update
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
