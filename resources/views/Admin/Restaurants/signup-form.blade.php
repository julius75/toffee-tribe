@extends('layouts.system')
@section('title', 'Register as a Toffee Tribe Partner')
@section('content')
{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function () {--}}
{{--            $('#checkBtn').click(function() {--}}
{{--                checked = $("input[type=checkbox]:checked").length;--}}
{{--                if(!checked) {--}}
{{--                    alert("You must select at least one day available for Toffee Tribe members");--}}
{{--                    return false;--}}
{{--                }--}}

{{--            });--}}
{{--        });--}}
{{--    </script>--}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Host Registration</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('host.signup')}}" class="prevent-m-subs" enctype="multipart/form-data">
                            @csrf

                                <div class="row justify-content-center">
                                    <h4 style="color: #1a9082">Restaurant Information</h4>
                                </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="restaurant_name">Restaurant Name</label>
                                        <input id="restaurant_name" type="text" class="form-control @error('restaurant_name') is-invalid @enderror" name="restaurant_name" value="{{ old('restaurant_name') }}" required autocomplete="restaurant_name" autofocus>
                                    @error('restaurant_name')
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

{{--                            <div class="form-row">--}}

{{--                                <div class="form-group col-md-8">--}}
{{--                                    <label for="day_available">Select days available for Toffee Tribe users: </label>--}}
{{--                                    <br>--}}
{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="Sunday"  name="day_available[]" value="Sunday">--}}
{{--                                        <label class="form-check-label" for="Sunday">Sunday</label>--}}
{{--                                    </div>--}}

{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="Monday" name="day_available[]" value="Monday">--}}
{{--                                        <label class="form-check-label" for="Monday">Monday</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="Tuesday" name="day_available[]" value="Tuesday">--}}
{{--                                        <label class="form-check-label" for="Tuesday">Tuesday</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="Wednesday" name="day_available[]" value="Wednesday">--}}
{{--                                        <label class="form-check-label" for="Wednesday">Wednesday</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="Thursday" name="day_available[]" value="Thursday">--}}
{{--                                        <label class="form-check-label" for="Thursday">Thursday</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="Friday" name="day_available[]" value="Friday">--}}
{{--                                        <label class="form-check-label" for="Friday">Friday</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="Saturday" name="day_available[]" value="Saturday">--}}
{{--                                        <label class="form-check-label" for="Saturday">Saturday</label>--}}
{{--                                    </div>--}}
{{--                                    @error('day_available')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="form-group col-md-2">--}}
{{--                                    <label for="opening_time">From <small>(12hr time format)</small></label>--}}
{{--                                    <input id="opening_time" type="time" class="form-control @error('opening_time') is-invalid @enderror" name="opening_time" value="{{ old('opening_time') }}"  autocomplete="opening_time">--}}
{{--                                    @error('opening_time')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="form-group col-md-2">--}}
{{--                                    <label for="closing_time">Till <small>(12hr time format)</small></label>--}}
{{--                                    <input id="closing_time" type="time" class="form-control @error('closing_time') is-invalid @enderror" name="closing_time" value="{{ old('closing_time') }}"  autocomplete="closing_time">--}}
{{--                                    @error('closing_time')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
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
                                                    <label for="open_time[]">From (Open)<small>(12hr time format)</small></label>
                                                    <input id="open_time[]" type="time" class="form-control @error('open_time[]') is-invalid @enderror" name="open_time[]" value="{{ old('open_time[]') }}"  autocomplete="open_time[]">
                                                    @error('open_time[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
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

                                    <div class="col-md-2">
                                        <a data-duplicate-add="phone" class="btn btn-sm btn-outline-success">Add</a>
                                        <a data-duplicate-remove="phone" class="btn btn-sm btn-outline-danger">Remove</a>
                                    </div>
                                </div>

                            <hr>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="description">Location Description</label>
                                    <textarea required class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Provide an enticing description about this location..."></textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="amenities">Amenities Offered</label>
                                    <textarea required class="form-control @error('description') is-invalid @enderror" id="amenities" name="amenities" placeholder="List Amenities eg. - WiFi, - Power Sockets"></textarea>
                                    @error('food_beverage')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="food_beverage" >Food & Beverage</label>
                                    <select class="form-control @error('food_beverage') is-invalid @enderror" name="food_beverage" id="food_beverage" required>
                                        <option value="" disabled selected>Choose an option</option>
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
                                <label for="image">Select Main Image</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror"/>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <hr>

{{--                            <div class="row justify-content-center">--}}
{{--                                <h4  style="color: #1a9082">Host Information</h4>--}}
{{--                            </div>--}}
{{--                            <div class="form-row">--}}
{{--                                <div class="form-group col-md-6">--}}
{{--                                    <label for="host_name" >Full Name</label>--}}
{{--                                    <input id="host_name" type="text" maxlength="50" class="form-control @error('host_name') is-invalid @enderror" name="host_name" value="{{ old('host_name') }}" autocomplete="host_name" autofocus>--}}

{{--                                    @error('host_name')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                                <div class="form-group col-md-3">--}}
{{--                                    <label for="host_role" >Role</label>--}}
{{--                                    <input id="host_role" type="text" maxlength="20" class="form-control @error('host_role') is-invalid @enderror" name="host_role" value="{{ old('host_role') }}" autocomplete="host_role" autofocus>--}}

{{--                                    @error('host_role')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="form-group col-md-3">--}}
{{--                                    <label for="phone_number">Phone Number</label>--}}
{{--                                    <input id="phone_number" type="tel" pattern="\d{4}\d{3}\d{3}" title="'Phone Number (Format: 0712345678)'" class="form-control @error('phone_number') is-invalid @enderror " name="phone_number" value="{{ old('phone_number') }}"  maxlength="10" required autocomplete="phone_number" autofocus>--}}

{{--                                    @error('phone_number')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                            </div>--}}

                            <div class="row justify-content-end">
                                <small class="text-justify mr-2 mt-2" style="color:firebrick;">NOTE: Make sure to review and confirm the filled form before proceeding</small>
                                <button type="submit" id="checkBtn" class="btn btn-outline-primary button-prevent mr-2">
                                        Upload Slider Images
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $.duplicate = function () {
            var body = $('body');
            body.off('duplicate');
            var templates = {};
            var settings = {};
            var init = function () {
                $('[data-duplicate]').each(function () {
                    var name = $(this).data('duplicate');
                    var template = $('<div>').html($(this).clone(true, true)).html();
                    var options = {};
                    var min = +$(this).data('duplicate-min');
                    options.minimum = isNaN(min) ? 1 : min;
                    options.maximum = +$(this).data('duplicate-max') || Infinity;
                    //options.maximum = +$(this).data('duplicate-max') || '<?php /*echo  $used; */?>';
                    options.parent = $(this).parent();

                    settings[name] = options;
                    templates[name] = template;
                });

                body.on('click.duplicate', '[data-duplicate-add]', add);
                body.on('click.duplicate', '[data-duplicate-remove]', remove);

            };

            function add() {
                var targetName = $(this).data('duplicate-add');
                var selector = $('[data-duplicate=' + targetName + ']');
                var target = $(selector).last();
                if (!target.length) target = $(settings[targetName].parent);
                var newElement = $(templates[targetName]).clone(true);

                if ($(selector).length >= 7) {
                    // $(this).trigger('duplicate.error');
                    swal({
                        title: 'Maximum reached',
                        text: "You can't buy more than set amount tickets using this invite code",
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        // confirmButtonText: 'Yes, PAY NOW!'
                    })
                    return;
                }
                target.after(newElement);
                $(this).trigger('duplicate.add');

            }

            function remove() {
                var targetName = $(this).data('duplicate-remove');
                var selector = '[data-duplicate=' + targetName + ']';
                var target = $(this).closest(selector);
                if (!target.length) target = $(this).siblings(selector).eq(0);
                if (!target.length) target = $(selector).last();

                if ($(selector).length <= settings[targetName].minimum) {
                    $(this).trigger('duplicate.error');
                    return;
                }
                target.remove();
                $(this).trigger('duplicate.remove');
            }

            $(init);
        };
        $.duplicate()



    </script>
@endsection
