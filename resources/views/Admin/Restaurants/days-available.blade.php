@extends('layouts.system')
@section('title', 'Days Available')
@section('content')
    <div class="container">
        <div class="row">
            <h4 style="color: #1a9082">Overview of the days available for {{$restaurant->restaurant_name}}</h4>
        </div>
        <br>
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
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h4>{{$restaurant->name}}</h4>
                    <div class="col-md-12">
                        <button type="button" class="ml-2 mb-3 btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#dayModal">
                           Add New Day Available
                        </button>

                        <div class="modal fade" id="dayModal" tabindex="-1" role="dialog" aria-labelledby="modLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modLabel">Create New Day Available for {{$restaurant->name}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{route('day.create.new')}}">
                                            @csrf
                                            <div class="form-row">
                                                <div class=" form-group col-md-6">
                                                    <div class="has-feedback{{ $errors->has('day') ? ' has-error' : '' }}">
                                                        <label>Day of the week<span class="asterisk">*</span></label>
                                                        <div class="dropdown">
                                                            <select class="dropdown-menu browser-default custom-select" name="day">
                                                                <option disabled selected>Select Day</option>
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

                                                <div class="form-group col-md-6 ">
                                                    <label for="open_time">From (Open)</label>
                                                    <input id="open_time" type="time" class="form-control @error('open_time') is-invalid @enderror" name="open_time" value="{{ old('open_time') }}"  autocomplete="open_time">
                                                    @error('open_time')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <input hidden name="restaurant_id" value="{{$restaurant->id}}">
                                                <div class="form-group col-md-6 ">
                                                    <label for="close_time">Till (Close)</label>
                                                    <input id="close_time" type="time" class="form-control @error('close_time') is-invalid @enderror" name="close_time" value="{{ old('close_time') }}"  autocomplete="close_time">
                                                    @error('close_time')
                                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Create</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>

                                </div>
                            </div>
                        </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                <tr>
{{--                                    <th scope="col">id</th>--}}
                                    <th scope="col">Day Of Week</th>
                                    <th scope="col">Opening Time</th>
                                    <th scope="col">Closing Time</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($days->isEmpty())
                                    <td colspan="5" class="text-center"><b>NO RECORDS AVAILABLE FOR THIS LOCATION</b></td>
                                @endif
                                @foreach($days as $day)
                                    <tr>
{{--                                        <th scope="row">{{$day->id}}</th>--}}
                                        <td>{{$day->day_of_week}}</td>
                                        <td>{{$day->opening_time}}</td>
                                        <td>{{$day->closing_time}}</td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="{{route('get.day.edit',['id'=>$day->id])}}" ><small>Edit Details</small></a>

                                            <a class="btn btn-danger btn-sm" href="{{route('day.delete',['id'=>$day->id])}}" ><small>Delete Record</small></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>


{{--                        <div class="modal fade edit{{$day->id}}" id="edit{{$day->id}}" tabindex="-1" role="dialog" aria-labelledby="modLabel" aria-hidden="true"  >--}}
{{--                            <div class="modal-dialog" role="document">--}}
{{--                                <div class="modal-content">--}}
{{--                                    <div class="modal-header">--}}
{{--                                        <h5 class="modal-title" id="modLabel">Edit Day Available for {{$restaurant->name}}, {{$day->day_of_week}}</h5>--}}
{{--                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                            <span aria-hidden="true">&times;</span>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                    <div class="modal-body">--}}
{{--                                        <form method="post" action="{{route('day.update', ['id'=>$day->id])}}">--}}
{{--                                            @csrf--}}
{{--                                            <div class="form-row">--}}
{{--                                                <div class="form-group col-md-6 ">--}}
{{--                                                    <label for="open_time">From (Open)</label>--}}
{{--                                                    <input id="open_time" type="time" class="form-control @error('open_time') is-invalid @enderror" name="open_time" value="{{ $day->opening_time }}"  autocomplete="open_time">--}}
{{--                                                    @error('open_time')--}}
{{--                                                    <span class="invalid-feedback" role="alert">--}}
{{--                                                            <strong>{{ $message }}</strong>--}}
{{--                                                        </span>--}}
{{--                                                    @enderror--}}
{{--                                                </div>--}}

{{--                                                <div class="form-group col-md-6 ">--}}
{{--                                                    <label for="close_time">Till (Close)</label>--}}
{{--                                                    <input id="close_time" type="time" class="form-control @error('close_time') is-invalid @enderror" name="close_time" value="{{ $day->closing_time }}"  autocomplete="close_time">--}}
{{--                                                    @error('close_time')--}}
{{--                                                    <span class="invalid-feedback" role="alert">--}}
{{--                                                                <strong>{{ $message }}</strong>--}}
{{--                                                    </span>--}}
{{--                                                    @enderror--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="modal-footer">--}}
{{--                                                <button type="submit" class="btn btn-primary">Update</button>--}}
{{--                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection