@extends('layouts.system')
@section('title', 'Create Manual Ticket')
@section('content')

    <div class="container">
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
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

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a Manual Ticket</div>

                    <div class="card-body">
                        <form method="post" action="{{route('post.manual.ticket')}}"  class="prevent-m-subs" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Enter User Full Name</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="email" value="{{ old('name') }}" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Enter Registered User Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" value="{{ old('email') }}" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="package" >Package</label>
                                            <select class="form-control @error('package') is-invalid @enderror" name="package" id="package" required>
                                                <option value="" disabled selected>Choose an option</option>
                                                @foreach($packages as $package)
                                                    <option value="{{$package->id}}" >{{$package->name}}</option>
                                                @endforeach
                                            </select>
                                        @error('package')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                
                                    <div class="form-group col-md-6">
                                        <label for="package" >Is the Ticket a FREEPASS?</label>
                                            <select class="form-control @error('free_pass') is-invalid @enderror" name="free_pass" id="free_pass" required>
                                                <option value="" disabled selected>Choose an option</option>
                                        <option value="no" >NO</option>
                                        <option value="yes" >YES</option>
                                            </select>
                                        @error('free_pass')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                            <button type="submit" id="checkBtn" class="btn btn-outline-primary button-prevent mr-2">
                                Create
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
