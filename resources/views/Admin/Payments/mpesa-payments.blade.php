@extends('layouts.system')
@section('title', 'View PayPayments')
@section('css')
    <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row" style="padding-left:20px;">
        <h4 style="color: #1a9082">
            MPESA Payments
            <button class="btn btn-success btn-sm">
                <a href="{{route('manual.payments')}}" style="text-decoration:none;color:white;">
                    Manual Entry
                </a>
            </button>
        </h4>
    </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered " id="pp_payments">

                                <thead>
                                <tr>

                                    <th scope="col">id</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Order Number</th>
                                    <th scope="col">Package Name</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Amount Paid (KSH)</th>
                                    <th scope="col">Payer PhoneNumber</th>
{{--                                    <th scope="col">PayPal Payer Account Name</th>--}}
                                    <th scope="col">Date Paid</th>
                                    <th scope="col">Status</th>
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
        $('#pp_payments').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('mpesa.data')!!}',
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
            order: [0, 'desc'],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user', name: 'user'},
                {data: 'order_number', name: 'order_number'},
                {data: 'package', name: 'package'},
                {data: 'mpesaReceiptNumber', name: 'mpesaReceiptNumber'},
                {data: 'amount', name: 'amount'},
                {data: 'phoneNumber', name: 'phoneNumber'},
                {data: 'transactionDate', name: 'transactionDate'},
                {data: 'status', name: 'status'},
                // {data: 'action', name: 'action', orderable: false, searchable: false}

            ]
        });
    </script>
{{--    <script>--}}
{{--        $(document).ready(function(){--}}

{{--            fetch_customer_data();--}}

{{--            function fetch_customer_data(query = '')--}}
{{--            {--}}
{{--                $.ajax({--}}
{{--                    url:"{{ route('pp.payments.search') }}",--}}
{{--                    method:'GET',--}}
{{--                    data:{query:query},--}}
{{--                    dataType:'json',--}}
{{--                    success:function(data)--}}
{{--                    {--}}
{{--                        $('tbody').html(data.table_data);--}}
{{--                        $('#total_records').text(data.total_data);--}}
{{--                    }--}}
{{--                })--}}
{{--            }--}}
{{--            $(document).on('keyup', '#search', function(){--}}
{{--                var query = $(this).val();--}}
{{--                fetch_customer_data(query);--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

    @endsection