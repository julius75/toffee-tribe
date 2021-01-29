@extends('layouts.auth')

@section('content')

<div class="container">
    @if(Session::has('status'))
        <div class="row justify-content-center">
            <br>
            <div class="col-md-6">
                <p class="alert alert-info text-center">{{ Session::get('status') }}</p>
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
{{--                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>--}}
                        <div class="col-lg-6 d-none d-lg-block ">
                            <img src="{{asset('illustrations/click_here.svg')}}" class="mt-5 ml-5 " style="width: 100%; height: 80%" alt="SVG not supported">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password? 😮</h1>
                                    <p class="mb-4">Enter your email address below and we'll send you a link to reset your password!</p>
                                </div>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email" class="col-md-12 col-form-label">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 ">
                                            <button type="submit" class="btn btn-secondary">
                                                {{ __('Send Password Reset Link') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection