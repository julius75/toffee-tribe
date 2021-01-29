@extends('layouts.system')
@section('title', 'Checked In Visitors')
@section('css')
    <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h4 style="color: #1a9082">{{$location->restaurant_name}} </h4>
        </div>
        <div class="row">
            <h5 style="color: #1a9082">Visits Today: {{count($visits_today)}} visitors </h5>
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
                            <table class="table table-bordered " id="visitsData">
                                <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Order Number</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Package Type</th>
                                    <th scope="col">Arrival Time</th>
                                    <!--<th scope="col">Departure Time</th>-->
                                    <!--<th scope="col">Actions</th>-->
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
        $('#visitsData').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('loc.visits.data', ['slug'=>$location->slug])!!}',
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
                {data: 'email', name: 'email'},
                {data: 'package', name: 'package'},
                {data: 'arrival_time', name: 'arrival_time'},
                // {data: 'departure', name: 'departure'},
                // {data: 'action', name: 'action', orderable: false, searchable: false}
            ],

        });
    </script>
@endsection