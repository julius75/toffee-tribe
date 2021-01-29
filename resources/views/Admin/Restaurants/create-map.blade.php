@extends('layouts.system')
@section('title', 'Restaurant Map Location')
@section('content')

    <div class="container">
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" class="prevent-m-subs" action="{{route('post.host.map')}}">
                            @csrf
                                <div class="row justify-content-center">
                                    <h4 style="color: #1a9082">Map Information</h4>
                                </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="restaurant_name">Restaurant Name</label>
                                    <input readonly id="restaurant_name" type="text" class="form-control @error('restaurant_name') is-invalid @enderror" name="restaurant_name" value="{{ $location->restaurant_name }}" required autocomplete="restaurant_name" autofocus>
                                    @error('restaurant_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <input hidden name="id" value="{{$location->id}}">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="iframe">Paste iframe here: <br><small style="color: #f22000">NOTE: <br>
                                            Delete the opening and closing iframe tags.
                                            Edit width to 100% and height to "500"</small></label>
                                     <textarea id="iframe" rows="10" class="form-control @error('iframe') is-invalid @enderror" name="iframe" autocomplete="iframe"></textarea>
                                    @error('iframe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row ml-5">
                                    <button type="submit" class="btn btn-outline-primary button-prevent">
                                        Submit
                                    </button>
                            </div>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <div class="gmap_canvas map">
                    <small>This is a sample view of how the map should look with the correct dimensions</small>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d510564.6498664422!2d36.56720029142611!3d-1.3031933719272915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1172d84d49a7%3A0xf7cf0254b297924c!2sNairobi!5e0!3m2!1sen!2ske!4v1570542336550!5m2!1sen!2ske" width=100% height="500" frameborder="0" style="border:0;" allowfullscreen=""></iframe> </div>
            </div>
        </div>
    </div>
@endsection
