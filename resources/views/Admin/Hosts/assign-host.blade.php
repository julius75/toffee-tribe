@extends('layouts.system')
@section('title', 'Assign Host')
@section('content')

    <div class="container">
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
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

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Assign Host to {{$location->restaurant_name}}</div>

                    <div class="card-body">
                        <form method="post" action="{{route('assign.host.post')}}"  class="prevent-m-subs" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <input hidden name="restaurant_id" value="{{$location->id}}">
                                <div class="form-group col-md-6">
                                    <label for="email">Enter Host Email</label>
                                    <input id="email" type="email" class="form-control" name="email" required autocomplete="email" value="{{ old('email') }}" autofocus>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="role">Enter Host Role</label>
                                    <input id="role" type="text" class="form-control" name="role" required autocomplete="email" value="{{ old('role') }}" autofocus>
                                </div>
                            </div>
                            <button type="submit" id="checkBtn" class="btn btn-outline-primary button-prevent mr-2">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>
@endsection
@section('js')
@endsection
