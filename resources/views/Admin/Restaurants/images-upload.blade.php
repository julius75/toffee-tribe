@extends('layouts.system')
@section('title', 'Upload Restaurant Images')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Upload Slider Images</div>
                    <div class="card-body ">
                        <p>{{$restaurant->restaurant_name}}</p>

                            <form action="{{route('multiple.images')}}" method="post" class="prevent-m-subs" enctype="multipart/form-data">
                                @csrf
                                <input hidden name="restaurant_id" value="{{$restaurant->id}}">

                                <input type="file" name="file[]" class="form-control @error('file') is-invalid @enderror" multiple>
                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <input type="submit" class="mt-2 btn btn-outline-secondary button-prevent">
                            </form>
                            <hr>

                        @if($images->isEmpty())
                            <h5 class="text-center" style="color: #1a9082">You have not uploaded any slider images</h5>
                            @else
                        <h5 class="text-center" style="color: #1a9082">Uploaded Images</h5>
                        @endif
                        <div class="row justify-content-center">
                        @foreach($images as $image)
                                <div class="col-mb-12 mt-2 mb-2">
                                    <a href="{{asset($image->image_path)}}">
                                        <img src="{{asset($image->image_path)}}" style= "object-fit: fill;  object-position: center;  height: 200px;  width: 200px;">
                                    </a>
                                  <br>
                                  @if($image->size >= 1048576)
                                    <small>{{$image->size = number_format($image->size / 1048576, 2) . ' MB'}}</small>
                                  @elseif($image->size >= 1024)
                                      <small>{{$image->size = number_format($image->size / 1024, 2) . ' KB'}}</small>
                                  @elseif($image->size >= 1)
                                      <small>{{$image->size . ' bytes'}}</small>
                                  @endif
                                <form action="{{route('delete.image',['ImageUpload'=>$image->id])}}" class="prevent-m-subs" method="post">
                                    @csrf
                                    <button class="small btn btn-outline-danger mt-2 mb-2 button-prevent">
                                        Remove
                                    </button>
                                </form>
                               </div>

                                @endforeach
                         </div>
                        <hr>
                        <a href="{{route('host.map', ['slug'=>$restaurant->slug])}}" class="small btn btn-outline-secondary mt-2 offset-9">
                            Create Map
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
