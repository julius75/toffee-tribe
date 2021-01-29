@extends('layouts.master')
@section('title', 'My Profile')


@section('content')
<style>
    .text-color{
        color: #1a9082;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    @if(Session::has('info'))
        <div class="row justify-content-center">
            <div class="col-md-6">
                <p class="alert text-center alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    @if(Session::has('error'))
        <div class="row justify-content-center">
            <div class="col-md-6">
                <p class="alert text-center alert-danger">{{ Session::get('error') }}</p>
            </div>
        </div>
    @endif
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-color">Member Profile</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form method="post" action="{{route('member.update.profile')}}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="full_name">Full Name</label>
                                <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $user->full_name }}" required autocomplete="full_name" autofocus>
                                @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone_number" >Phone Number</label>
                                <input id="phone_number" type="tel" pattern="\d{4}\d{3}\d{3}" title="'Phone Number (Format: 0712345678)'" class="form-control @error('phone_number') is-invalid @enderror " name="phone_number" value="{{ $user->phone_number }}"  maxlength="10" required autocomplete="phone_number" autofocus>

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="username">@Username</label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required readonly autocomplete="username" autofocus>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="location">Location</label>
                                <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ $user->location }}"  autocomplete="location" autofocus>
                                @error('location')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="grind">Occupation / Grind</label>
                                <input id="grind" type="text"  class="form-control @error('grind') is-invalid @enderror" name="grind" value="{{ $user->grind }}" autocomplete="grind" autofocus>
                                @error('grind')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="message">Bio</label>
                                <textarea class="form-control" id="message" name="message" placeholder="Enter Your Bio">{{$user->bio}}</textarea>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <p style="color: #1a9082"><b>Company Details</b></p>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="company">Company</label>
                                <input id="company" type="text" class="form-control @error('company') is-invalid @enderror" value="{{$user->company}}" name="company" autocomplete="company" autofocus>
                                @error('company')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="industry">Industry</label>
                                <input id="industry" type="text" class="form-control @error('industry') is-invalid @enderror" name="industry"  value="{{$user->industry}}" autocomplete="industry" autofocus>
                                @error('industry')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <input hidden name="username" value="{{$user->username}}">
                        <button type="submit" class="btn btn-outline-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>

    </div>


</div>

    @endsection