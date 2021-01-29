@extends("layouts.system")
@section('title', 'Manual Mpesa Entry')
@section("css")
<link rel="stylesheet" href="{{asset('bower_components/select2/css/select2.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/datepicker/jquery.datetimepicker.css')}}">
@stop
@section("content")
<div class="row">
    <div class="col-sm-12">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Error!</strong> {{ Session::get('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif
        <div class="card">
            <div class="card-block">
                <form action="{{route('manual')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="customer">Name</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color:#1a9082;" id="basic-addon1"><i
                                        class="icofont icofont-user"></i></span>
                                <select
                                    class="js-example-basic-single form-control{{ $errors->has('id') ? ' is-invalid' : '' }}"
                                    name="id" required>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">
                                        {{$user->full_name}} ( {{$user->phone_number}} )
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('user'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('user') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="datetimepicker1">Date Paid</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color:#1a9082;" id="basic-addon1"><i
                                        class="icofont icofont-calendar"></i></span>
                                <input id="datetimepicker1" type="text" autocomplete="off" name="date_payed"
                                    value="{{ old('date_payed')}}"
                                    class="form-control{{ $errors->has('date_payed') ? ' is-invalid' : '' }}" required>
                            </div>
                            @if ($errors->has('date_payed'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('date_payed') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="trans">Transaction ID</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color:#1a9082;"
                                    id="basic-addon1">TID</span>
                                <input type="text" id="trans" name="transaction_id" value="{{ old('transaction_id')}}"
                                    class="form-control{{ $errors->has('transaction_id') ? ' is-invalid' : '' }}"
                                    required>
                            </div>
                            @if ($errors->has('transaction_id'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('transaction_id') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="amount">Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color:#1a9082;" id="basic-addon1"><i
                                        class="icofont icofont-money"></i></span>
                                <input type="number" name="amount" value="{{ old('amount')}}"
                                    class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" required>
                            </div>
                            @if ($errors->has('amount'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <button class="btn btn-primary float-left" style="background-color:#1a9082;">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {

            "use strict";
            jQuery('#datetimepicker1').datetimepicker({

                format:'Y-m-d H:i:s'
                //format: 'Y-m-d'

            });
        })
</script>
@stop