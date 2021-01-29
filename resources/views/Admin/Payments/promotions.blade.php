@extends('layouts.system')
@section('title', 'Promotions / User Invite-Codes')
@section('content')
    <div class="container-fluid">
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-2">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold" style="color: #1a9082">Used Discount Codes</h6>
                    </div>
                       <div class="col-md-12">
                           <div class="table-responsive">
                               <table class="table table-bordered ">
                                   <thead>
                                   @if($codes->isEmpty())
                                       <th class="text-center">NO RECORDS</th>
                                        @else
                                            <tr>
                                                <th scope="col">id</th>
                                                <th scope="col">Invite Code</th>
                                                <th scope="col">Used By</th>
                                                <th scope="col">Order Id</th>
                                                <th scope="col">Date Created</th>
                                                <th scope="col">Date Used</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($codes as $code)
                                            <tr>
                                                <th scope="row">{{$code->id}}</th>
                                                <td>{{$code->code}}</td>
                                                <td>{{$code->user->full_name}}</td>
                                                <td>{{$code->order->order_number}}</td>
                                                <td>{{\Carbon\Carbon::parse($code->created_at)->format('d M Y h:i')}}</td>
                                                <td>{{\Carbon\Carbon::parse($code->used_at)->format('d M Y h:i')}}</td>
                                                <td>@if($code->status == 0)
                                                        <h6><span class="badge badge-danger">INVALID</span></h6>
                                                    @else
                                                        <h6><span class="badge badge-success">VALID</span></h6>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                   @endif
                               </table>
                                </div>
                       </div>
               </div>
            </div>


            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold" style="color: #1a9082">Unused Discount Codes</h6>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                @if($unused_codes->isEmpty())
                                    <th  class="text-center">NO RECORDS</th>
                                @else
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Invite Code</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($unused_codes as $unused_code)
                                            <tr>
                                                <th scope="row">{{$unused_code->id}}</th>
                                                <td>{{$unused_code->code}}</td>
                                                <td>{{\Carbon\Carbon::parse($unused_code->created_at)->format('d M Y')}}</td>
                                                <td>@if($unused_code->status == 0)
                                                        <h6><span class="badge badge-danger">INVALID</span></h6>
                                                    @else
                                                        <h6><span class="badge badge-success">VALID</span></h6>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
                                @endif
                            </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
    </div>
@endsection