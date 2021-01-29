@extends('layouts.system')
@section('title', 'Registered Subscriptions')
@section('content')
    <div class="container">
        <div class="row">
            <h4 style="color: #1a9082">Overview of Registered Packages/Subscriptions </h4>
        </div>
        <br>
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Package Name</th>
                                    <th scope="col">Period</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Amount(KSH)</th>
                                    <th scope="col">Discounted Amount(KSH)</th>
                                    <th scope="col">Date Created</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($packages->isEmpty())
                                    <tr>NO RECORDS</tr>
                                    @endif
                                @foreach($packages as $package)
                                    <tr>
                                        <th scope="row">{{$package->id}}</th>
                                        <td>{{$package->name}}</td>
                                        <td>{{$package->period}}</td>
                                        @if($package->details == null)
                                            <td class="text-muted">No Description</td>
                                        @else
                                            <td>{{$package->details}}</td>
                                        @endif
                                        <td>{{$package->amount}}</td>
                                        <td>{{$package->discounted_amount}}</td>
                                        <td>{{\Carbon\Carbon::parse($package->created_at)->format('d M Y, h:i')}}</td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="{{route('edit.package',['slug'=>$package->slug])}}"><small>Edit</small></a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <small>{!! $packages->appends(request()->input())->links() !!}</small>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection