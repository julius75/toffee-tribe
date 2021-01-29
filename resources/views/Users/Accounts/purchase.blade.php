@extends('layouts.master')
@section('title', 'Event Payment')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Member Details</h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name">Name</label>
                            <input type="text" class="form-control" id="full_name" value="{{$user->full_name}}" placeholder="" required="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username">Username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" value="{{$user->username}}" class="form-control" id="username" placeholder="Username" required="">
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" value="{{$user->email}}"id="email">
                    </div>


                    <hr class="mb-4">

                    <h5 class="mb-3">Confirm details and proceed to payment</h5>

                        <form class="prevent-m-subs">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name">Event Name</label>
                                    <input readonly type="text" class="form-control" value="Toffee Tribe - {{$event->name}}" id="name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="period">Event Location</label>
                                    <input readonly type="text" class="form-control" value="{{$event->location}}" id="period">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="details">Event Details</label><br>
                                <textarea readonly rows="3" class="form-control"  style="border-color:  #d1d3e2; color: #858796; background-color: #eaecf4;-webkit-border-radius: .35rem; -moz-border-radius: .35rem; border-radius: .35rem;">{{$event->description}}</textarea>
                            </div>
                        </form>
                <button type="button" class="ml-2 mb-3 btn btn-sm btn-outline-success" data-toggle="modal" data-target="#mpesaModal">
                    Pay With M-Pesa
                </button>
                <div class="modal fade" id="mpesaModal" tabindex="-1" role="dialog" aria-labelledby="modLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modLabel">Pay With M-PESA</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="{{route('pay.event')}}">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                                <p> Amount to be paid: KES {{$total}}</p>
                                            <label for="phone_number">Confirm M-Pesa Phone Number</label>
                                            <input hidden name="slug" value="{{$event->id}}">
                                            <input hidden name="id" value="{{$event->slug}}">
                                            <input required id="phone_number" name="phone_number" value="{{$user->phone_number}}">
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    @endsection
