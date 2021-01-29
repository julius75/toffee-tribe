@extends('layouts.system')
@section('title', 'Completed Events')
@section('css')
    <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
@endsection
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
            <h4 style="color: #1a9082">Completed Events Payments </h4>
            <div class="col-md-4 mb-1">
                <a href="{{route('get.manual.ticket')}}" class="btn btn-warning">Create a Manual Event Ticket</a>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="orders">
                                <thead>

                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Ticket Number</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Amount(KHS)</th>
                                    <th scope="col">Date Purchased</th>
                                    <th scope="col">End of Validity</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{asset('datatables/datatables.min.js')}}" ></script>

    <script>
    $('#orders').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('orders.events.data')!!}',
    dom: 'Bfrtip',
    buttons: [
    'colvis','copy', 'excel', 'print',

    {
    extend: 'csvHtml5',
    text: 'CSV',
    exportOptions: {
    columns: [0,1, 2,3,4, 5,6],
    },
    footer: true,
    },
    'pageLength'
    ],
    order: [0, 'desc'],
    columns: [
    {data: 'id', name: 'id'},
    {data: 'order_number', name: 'order_number'},
    {data: 'user', name: 'user'},
    {data: 'amount', name: 'amount'},
    {data: 'created_at', name: 'created_at'},
    {data: 'expires_at', name: 'expires_at'},
    {data: 'status', name: 'status'},
    {data: 'action', name: 'action', orderable: false, searchable: false}

    ]
    });
    </script>
@endsection
