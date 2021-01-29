@extends('layouts.system')
@section('title', 'Register Package')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Package Registration</div>

                    <div class="card-body">
                        <form method="POST" class="prevent-m-subs" action="{{route('package')}}">
                            @csrf
                                <div class="row justify-content-center">
                                    <h4 style="color: #1a9082">Package Information</h4>
                                </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Package Name</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="period" >Validity Period of the Package</label>
                                    <select class="form-control" name="period" id="period" required>
                                        <option value="" disabled selected>Choose an option</option>
                                        <option value="one day">One day</option>
                                        <option value="/ week">/ week</option>
                                        <option value="/ month">/ month</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row justify-content-center">
                                <div class="form-group col-md-5">
                                    <label for="amount" >Amount ($)</label>
                                    <input id="amount" type="number" min="0" max="100000" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required autocomplete="amount">
                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="discounted_amount" >Discounted Amount ($)<small>Price a user would pay on using a promo code.</small></label>
                                <input id="discounted_amount" type="number" max="100000" min="0" step="0.01" class="form-control @error('discounted_amount') is-invalid @enderror" name="discounted_amount" value="{{ old('discounted_amount') }}" required autocomplete="discounted_amount">
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="details">Package Details / Description</label>
                                     <textarea id="details" class="form-control @error('details') is-invalid @enderror" name="details" autocomplete="details" placeholder="Brief description on the pricing and length of the given package"></textarea>
                                    @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row justify-content-center">
                                    <button type="submit" id="checkBtn" class="btn btn-lg btn-outline-primary button-prevent">
                                        Send
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
