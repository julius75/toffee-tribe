@extends('layouts.system')
@section('title', 'Check-In User')
@section('content')

    <div class="container">
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-danger text-center">{{ Session::get('error') }}</p>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User Check-In, {{$location->restaurant_name}}</div>

                    <div class="card-body">
                        <form method="post" action="{{route('find.order',['slug'=>$location->slug])}}"  class="prevent-m-subs" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <input hidden name="restaurant_id" value="{{$location->id}}">
                                <div class="form-group col-md-12">
                                    <label for="order_number">Enter Order Number</label>
                                    <input id="order_number" type="text" class="form-control" name="order_number" required autocomplete="order_number" autofocus>
                                </div>
                            </div>
                            <button type="submit" id="checkBtn" class="btn btn-outline-primary button-prevent mr-2">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="table-responsive">--}}
{{--                        <h3 align="center">Total Data : <span id="total_records"></span></h3>--}}
{{--                        <table class="table table-striped table-bordered">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>Order Number</th>--}}
{{--                                <th>User</th>--}}
{{--                                <th>Package</th>--}}
{{--                                <th>Amount</th>--}}
{{--                                <th>Date Purchased</th>--}}
{{--                                <th>Date Expires</th>--}}
{{--                                <th>Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}

{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
@section('js')
{{--    <script>--}}
{{--        $(document).ready(function(){--}}
{{--            fetch_customer_data();--}}
{{--            function fetch_customer_data(query = '')--}}
{{--            {--}}
{{--                $.ajax({--}}
{{--                    url:"{{ route('find.order') }}",--}}
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
