@extends('layouts.system')
@section('title', 'Edit Day Available')
@section('content')
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
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="{{route('day.update')}}">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="open_time">From (Open)</label>
                                                    <input id="open_time" type="time" class="form-control @error('open_time') is-invalid @enderror" name="open_time" value="{{ $day->opening_time }}"  autocomplete="open_time">
                                                    @error('open_time')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <input hidden name="id" value="{{$day->id}}">
                                                <div class="form-group col-md-6 ">
                                                    <label for="close_time">Till (Close)</label>
                                                    <input id="close_time" type="time" class="form-control @error('close_time') is-invalid @enderror" name="close_time" value="{{ $day->closing_time }}"  autocomplete="close_time">
                                                    @error('close_time')
                                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection