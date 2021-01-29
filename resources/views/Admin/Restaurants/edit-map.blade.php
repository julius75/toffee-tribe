@extends('layouts.system')
@section('title', 'Update Restaurant Map Location')
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
                        <form method="POST" class="prevent-m-subs" action="{{route('update.host.map')}}">
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
                            <input hidden name="id" value="{{$location_map->id}}">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="iframe">Paste iframe here: <br><small style="color: #f22000">NOTE: <br>
                                            Delete the opening and closing iframe tags.
                                            Edit width to 100% and height to "500"</small></label>
                                    <textarea id="iframe" rows="10" class="form-control @error('iframe') is-invalid @enderror" name="iframe" autocomplete="iframe">{{$location_map->iframe}}</textarea>
                                    @error('iframe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
{{--                            <script>--}}
{{--                                ClassicEditor--}}
{{--                                    .create( document.querySelector( '#editor' ) )--}}
{{--                                    .then( editor => {--}}
{{--                                        console.log( editor );--}}
{{--                                    } )--}}
{{--                                    .catch( error => {--}}
{{--                                        console.error( error );--}}
{{--                                    } );--}}
{{--                            </script>--}}
                            <div class="row">
                                    <button type="submit" class="btn btn-outline-primary button-prevent ml-3">
                                        Update
                                    </button>
                                    <a href="{{route('list.locations')}}" class="offset-6 mt-2">Finish</a>
                            </div>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <div class="gmap_canvas map">
                    <small>Map Preview</small>
                    <iframe {!! $location_map->iframe !!} </iframe>
                </div>
        </div>
    </div>
</div>
@endsection
