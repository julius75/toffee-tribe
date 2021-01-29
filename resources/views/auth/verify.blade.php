@extends('layouts.auth')

@section('content')
<div class="container">
    @if(Session::has('resent'))
        <div class="row justify-content-center">
            <br>
            <div class="alert alert-success text-center" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block ">
                            <img src="{{asset('illustrations/working_with_computer.svg')}}" class="mt-5 ml-5 " style="width: 100%; height: 60%" alt="SVG not supported">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Please Verify Your Email Address</h1>
                                    {{ __('Before proceeding, please check your email for a verification link.') }}
                                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


@endsection
