@extends('layouts.app')

@section('content')
    <div class="container">

        @if(Session::has('status'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-success text-center">{{ Session::get('status') }}</p>
                </div>
            </div>
        @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome to Toffee Tribe</div>

                <div class="card-body">
                  <h4 class="text-center" style="color: #1a9082">YOUR PAYMENT WAS SUCCESSFUL</h4>
                  <h6 class="text-center" >Click <a href="{{route('member.index')}}">here</a> to access your Member Dashboard</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
