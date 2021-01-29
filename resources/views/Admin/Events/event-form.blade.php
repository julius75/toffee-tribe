@extends('layouts.system')
@section('title', 'Register Event')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{route('event.create')}}" class="prevent-m-subs" enctype="multipart/form-data">
                            @csrf
                                <div class="row" style="justify-content: space-between;margin-left: -5px;margin-right: -5px;">
                                    <h4 style="color: #1a9082" class="justify-content-end">Event Information</h4>
                                    <h4  class="justify-content-start"> <a href="{{route('list.events')}}" style="color: #1a9082">Back</a></h4>
                                </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Event Name</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="restaurant_name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="location">Event Location</label>
                                    <select class="form-control @error('category') is-invalid @enderror" name="location" id="location" required>
                                        @foreach($items as $item)
                                            <option value="{{$item->restaurant_name}}">{{$item->restaurant_name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="organizer">Event Description</label>
                                    <textarea required class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Provide a description about this event..."></textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="category">Event Category</label>
                                    <select class="form-control @error('category') is-invalid @enderror" name="category" id="category" required>
                                        <option value="Networking">Networking</option>
                                        <option value="Breakfast">Breakfast</option>
                                    </select>
                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="price">Event Price</label>
                                    <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price">
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status">Event Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('organizer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class=" form-group col-md-4">
                                    <div class="has-feedback{{ $errors->has('day[]') ? ' has-error' : '' }}">
                                        <label>Date of the Event<span class="asterisk">*</span></label>
                                        <input type="date" name="date" id="date" class="form-control" style="width: 100%; display: inline;" required value="">

                                    </div>
                                </div>

                                <div class="form-group col-md-3 ">
                                    <label for="open_time[]">Starting Time (Open)<small>(12hr time format)</small></label>
                                    <input id="open_time[]" type="time" class="form-control @error('open_time') is-invalid @enderror" name="starting_time" value="{{ old('open_time') }}"  autocomplete="open_time">
                                    @error('open_time')
                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3 ">
                                    <label for="close_time[]">Closing Time (Close) <small>(12hr time format)</small></label>
                                    <input id="close_time" type="time" class="form-control @error('close_time') is-invalid @enderror" name="ending_time" value="{{ old('close_time') }}"  autocomplete="close_time">
                                    @error('close_time[]')
                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="image">Select Event Image</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror"/>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <hr>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-outline-primary button-prevent mr-2">
                                        Create Event
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
