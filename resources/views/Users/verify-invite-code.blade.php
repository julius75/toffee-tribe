@extends('layouts.app')
@section('title', 'Verify Invitation')


@section('content')
    <style>
        .text-color{
            color: #1a9082;
        }
    </style>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Content Row -->

        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-color">Enter Invite Code</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">

                    <form action="{{route('verify.invite')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="invite_code" class="col-md-4 col-form-label text-md-right">Invite Code</label>

                            <div class="col-md-6">
                                <input id="invite_code" type="text" class="form-control @error('invite_code') is-invalid @enderror" name="invite_code" value="{{ old('invite_code') }}" required autocomplete="invite_code">

                                @error('invite_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-outline-success">
                                        Verify
                                    </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

        </div>


    </div>

@endsection