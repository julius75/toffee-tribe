@extends('layouts.system')
@section('title', 'Registered Events')
@section('content')
    <div class="container-fluid">
        <div class="row offset-1">
            <h4 style="color: #1a9082">Overview of Registered Events </h4>
            <div class="col-md-2 mb-1">
                <a href="{{route('event.signup')}}" class="btn btn-outline-success btn-sm"><b>+</b>  Add a New Event</a>
            </div>
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
                            <table class="table table-bordered " id="locations">
                                <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Event Image</th>
                                    <th scope="col">Event Name</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Starting time</th>
                                    <th scope="col">Ending time</th>
                                    <th scope="col">Actions</th>
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
    $('#locations').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('events.data')!!}',
        dom: 'Bfrtip',
        buttons: [
            'colvis','copy', 'excel', 'print',

            {
                extend: 'csvHtml5',
                text: 'CSV',
                exportOptions: {
                    columns: [0,1, 2,3,4, 5,6,7,8],
                },
                footer: true,
            },
            'pageLength'
        ],
        columns: [
            {data: 'id', name: 'id'},
            {data: 'image', name: 'image', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'location', name: 'location'},
            {data: 'date', name: 'date'},
            {data: 'status', name: 'status'},
            {data: 'starting_time', name: 'starting_time'},
            {data: 'ending_time', name: 'ending_time'},
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ]
    });
</script>
@endsection
