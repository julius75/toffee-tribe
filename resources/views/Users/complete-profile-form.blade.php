@extends('layouts.app')
@section('title', 'Complete your profile')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Complete Your Profile</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('create.profile')}}">
                            @csrf
                            <div class="form-group row">
                                <label for="location" class="col-md-4 col-form-label text-md-right">Where are You from?</label>

                                <div class="col-md-6">
                                    <input id="location" type="text" maxlength="50" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" autocomplete="location" autofocus>

                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="grind" class="col-md-4 col-form-label text-md-right">What's your grind(occupation)?</label>

                                <div class="col-md-6">
                                    <input id="grind" type="text" maxlength="50" class="form-control @error('grind') is-invalid @enderror" name="grind" value="{{ old('grind') }}" autocomplete="grind">

                                    @error('grind')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="info_source" class="col-md-4 col-form-label text-md-right">Where did you hear us from?</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="info_source" id="info_source">
                                        <option value="Google Search">Google Search</option>
                                        <option value="Online Ads">Online Ads</option>
                                        <option value="Social Media">Social Media</option>
                                        <option value="Press">Press</option>
                                        <option value="Word of Mouth">Word of Mouth</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>

{{--                                    <a class="offset-md-8" href="{{route('home')}}">Skip...</a>--}}
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
