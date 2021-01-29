@extends('layouts.system')
@section('title', 'Register Package')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Package Registration</div>

                    <div class="card-body">
                        <form method="post" class="prevent-m-subs" action="{{route('update.package')}}">
                            @csrf
                                <div class="row justify-content-center">
                                    <h4 style="color: #1a9082">Update Package / Subscription Information</h4>
                                </div>
                            <input hidden name="id" value="{{$package->id}}">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Package Name</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $package->name }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="period" >Validity Period of the Package</label>
                                    <select class="form-control" name="period" id="period" required>
                                        <option value="one day" {{$package->period == "one day" ? 'selected' : ''}}>One day</option>
                                        <option value="/ week" {{$package->period == "/ week" ? 'selected' : ''}}>/ week</option>
                                        <option value="/ month" {{$package->period == "/ month" ? 'selected' : ''}}>/ month</option>
                                    </select>
                                </div>
                            </div>

                                <div class="form-row justify-content-center">
                                    <div class="form-group col-md-5">
                                        <label for="amount" >Amount (KSH.)</label>
                                        <input id="amount" type="number" min="0" max="100000" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $package->amount }}" required autocomplete="amount">
                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="discounted_amount" >Discounted Amount (KSH.)<small>Price a user would pay on using a promo code.</small></label>
                                        <input id="discounted_amount" type="number" max="100000" min="0" step="0.01" class="form-control @error('discounted_amount') is-invalid @enderror" name="discounted_amount" value="{{ $package->discounted_amount }}" required autocomplete="discounted_amount">
                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="details">Package Details</label>
                                     <textarea id="details" class="form-control @error('details') is-invalid @enderror" name="details" autocomplete="details" >{{$package->details}}</textarea>
                                    @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row justify-content-center">
                                    <button type="submit" id="checkBtn" class="btn btn-outline-primary button-prevent">
                                        Update
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
