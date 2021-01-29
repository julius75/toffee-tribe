@extends('layouts.auth')
@section('title', 'Register as a New User')
@section('content')
 <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
{{--                <div class="col-lg-5 d-none d-lg-block bg-register-image">--}}
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="{{asset('illustrations/save_the_earth.svg')}}" class="ml-5" style="width: 100%; height: 100%" alt="SVG not supported">
                </div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account! 🎉</h1>
                        </div>
                        <form method="POST" class="prevent-m-subs" action="{{ route('register') }}">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="full_name" class="col-form-label">{{ __('Full Name') }}</label>
                                        <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required autocomplete="full_name" autofocus>
                                        @error('full_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="username" class="col-form-label">{{ __('@username') }}</label>
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="phone_number" class="col-form-label ">{{ __('Phone-Number') }}</label>
                                        <input id="phone_number" type="tel" pattern="\d{4}\d{3}\d{3}" title="'Phone Number (Format: 0712345678)'" class="form-control @error('phone_number') is-invalid @enderror " name="phone_number" value="{{ old('phone_number') }}"  maxlength="10" required autocomplete="phone_number" autofocus>

                                        @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password" class="col-form-label ">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="password-confirm" class=" col-form-label">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>


                            <hr>


                            <div class="form-group row">
                                <label for="info_source" class="col-md-12 col-form-label">Where did you hear us from?</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="info_source" id="info_source">
                                        <option value="" selected>Choose an option</option>
                                        <option value="Referral / Word of Mouth">Referral / Word of Mouth</option>
                                        <option value="Google Search">Google Search</option>
                                        <option value="Online Ads">Online Ads</option>
                                        <option value="Social Media">Social Media</option>
                                        <option value="Press">Press</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 ">
                                    <div class="form-check">
                                        <input class="form-check-input" name="newsletter" type="checkbox" >

                                        <label class="form-check-label" for="newsletter">
                                            Subscribe to our Newsletter?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 ">
                                    <button type="submit" class="btn btn-secondary button-prevent">
                                        {{ __('Register') }}
                                    </button>

                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="btn btn-link" href="{{ route('login') }}">
                                {{ __('Already Registered? Log in here !') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
