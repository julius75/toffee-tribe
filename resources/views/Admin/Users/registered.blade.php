@extends('layouts.system')
@section('title', 'Registered Users')
@section('content')
<div class="container">
    <div class="row">
        <h4 style="color: #1a9082">Registered Users</h4>
        <div class="col-md-2 mb-1">
            <a href="{{route('user.register')}}" class="btn btn-outline-success btn-sm"><b>+</b>  Register New User</a>
        </div>
        <div class="col-md-2 mb-1">
            <a href="{{route('manage.users')}}" class="btn btn-outline-danger btn-sm"><b>*</b>  Manage Users</a>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="users">
                            <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">@username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Date Registered</th>
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="{{asset('datatables/datatables.min.js')}}" ></script>
<script>

$('#users').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('users.data')!!}',
            dom: 'Bfrtip',
            buttons: [
                'colvis','copy', 'excel', 'print',

                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0,1, 2,3,4, 5,6,7],
                    },
                    footer: true,
                },
                'pageLength'
            ],
            order:[0, 'DESC'],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'full_name', name: 'full_name'},
                {data: 'username', name: 'username'},
                {data: 'email', name: 'email'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'date_registered', name: 'date_registered'},
                {data: 'action', name: 'action', orderable: false, searchable: false}

            ]
        });
    // $(document).ready(function(){

    //     fetch_customer_data();

    //     function fetch_customer_data(query = '')
    //     {
    //         $.ajax({
    //             url:"{{ route('reg.users.search') }}",
    //             method:'GET',
    //             data:{query:query},
    //             dataType:'json',
    //             success:function(data)
    //             {
    //                 $('tbody').html(data.table_data);
    //                 $('#total_records').text(data.total_data);
    //             }
    //         })
    //     }
    //     $(document).on('keyup', '#search', function(){
    //         var query = $(this).val();
    //         fetch_customer_data(query);
    //     });
    // });
</script>
    @endsection