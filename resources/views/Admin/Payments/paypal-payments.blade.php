@extends('layouts.system')
@section('title', 'View PayPayments')
@section('css')
    <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row offset-1">
            <h4 style="color: #1a9082">PayPal Payments</h4>
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
                                    <th scope="col">Amount Paid ($)</th>
                                    <th scope="col">Payer ID</th>
                                    <th scope="col">PayPal Payer Account Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date Paid</th>
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
            ajax: '{!! route('paypal.data')!!}',
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
                {data: 'order_id', name: 'order_id'},
                {data: 'package', name: 'package'},
                {data: 'txn_id', name: 'txn_id'},
                {data: 'payment_gross', name: 'payment_gross'},
                {data: 'payer_id', name: 'payer_id'},
                {data: 'payer_name', name: 'payer_name'},
                {data: 'payment_status', name: 'payment_status'},
                {data: 'created_at', name: 'created_at'},
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