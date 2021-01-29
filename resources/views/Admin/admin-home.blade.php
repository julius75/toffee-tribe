@extends('layouts.system')
@section('title', 'ToffeeTribe Admin Panel - Home')
@section('css')
    <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
 <div class="row justify-content-center">

    <div class="col-xl-2 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Members Registered.</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($users)}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Successful Orders.</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($orders)}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div class="col-xl-2 col-md-6 mb-4">
         <div class="card border-left-warning shadow h-100 py-2">
             <div class="card-body">
                 <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                         <div class="text-xs font-weight-bold text-success text-uppercase mb-1">PayPal Gross.</div>
                         <div class="h5 mb-0 font-weight-bold text-gray-800"> ${{number_format($revenue, 2)}} <br> Ksh.{{number_format($converted_rev, 2)}}</div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="col-xl-2 col-md-6 mb-4">
         <div class="card border-left-warning shadow h-100 py-2">
             <div class="card-body">
                 <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                         <div class="text-xs font-weight-bold text-success text-uppercase mb-1">M-Pesa Gross.</div>
                         <div class="h5 mb-0 font-weight-bold text-gray-800"> Ksh. {{number_format($mpesarevenue, 2)}} </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

    <div class="col-xl-2 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Active Locations  .</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($active_locations)}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div class="col-xl-2 col-md-6 mb-4">
         <div class="card border-left-info shadow h-100 py-2">
             <div class="card-body">
                 <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                         <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Inactive Locations.</div>
                         <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($inactive_locations)}}</div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>


    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color: #155f53">Earnings Overview</h6>
                    
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <div id="top_x_div" style="width:80%; height: 70%;"></div>
                    </div>
                    <br>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color: #155f53">Information Sources</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <div id="donutchart" style="height: 80%; width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold"  style="color: #155f53">Registered Users</h6>
                </div>
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
{{--                                    <th scope="col">Role</th>--}}
{{--                                    <th colspan="2" class="text-center">Actions</th>--}}
                                </tr>
                                </thead>
                                <tbody>
{{--                                @foreach($users as $user)--}}
{{--                                    <tr>--}}
{{--                                        <th scope="row">{{$user->id}}</th>--}}
{{--                                        <td>{{$user->full_name}}</td>--}}
{{--                                        <td>{{$user->username}}</td>--}}
{{--                                        <td>{{$user->email}}</td>--}}
{{--                                        <td>{{$user->phone_number}}</td>--}}
{{--                                        <td>{{\Carbon\Carbon::parse($user->created_at)->format('d M Y, h:i')}}</td>--}}
{{--                                        <td>@foreach($user->roles as $role)--}}
{{--                                                {{$role->name}}--}}
{{--                                            @endforeach</td>--}}
{{--                                        <td><a class="btn btn-light btn-sm btn-prevent" href="{{route('view.user',['username'=>$user->username])}}" ><small>View</small></a></td>--}}
{{--                                        <td>--}}
{{--                                    @if($user->id != \Illuminate\Support\Facades\Auth::user()->id)--}}
{{--                                                @if($user->hasRole('admin'))--}}
{{--                                                    <a class="btn btn-warning btn-sm" href="{{route('remove.admin',['userId'=>$user->id])}}"><small>Remove-Admin</small></a>--}}
{{--                                                @else--}}
{{--                                                    <a class="btn btn-primary btn-sm" href="{{route('make.admin',['userId'=>$user->id])}}"><small>Make-Admin</small></a>--}}
{{--                                                @endif--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>

            </div>
        </div>
        </div>

    </div>

     <!--<div class="row">-->
     <!--    <div class="col-md-12">-->
     <!--        <div class="card shadow mb-4">-->
     <!--            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">-->
     <!--                <h6 class="m-0 font-weight-bold text-primary">Registered Locations</h6>-->
     <!--            </div>-->
     <!--            <div class="card-body">-->
     <!--                <div class="table-responsive">-->
     <!--                                <table class="table table-bordered " id="locations">-->
     <!--                                    <thead>-->
     <!--                                    <tr>-->
     <!--                                        <th scope="col">id</th>-->
     <!--                                        <th scope="col">Main Image</th>-->
     <!--                                        <th scope="col">Restaurant Name</th>-->
     <!--                                        <th scope="col">Location</th>-->
     <!--                                        <th scope="col">Seats</th>-->
     <!--                                        <th scope="col">Host Details</th>-->
     <!--                                        <th scope="col">Date Registered</th>-->
     <!--                                        <th scope="col">Status</th>-->
     <!--                                        <th scope="col">Opened/Closed</th>-->
     <!--                                        <th scope="col">Actions</th>-->
     <!--                                    </tr>-->
     <!--                                    </thead>-->
     <!--                                    <tbody>-->

     <!--                                    </tbody>-->
     <!--                                </table>-->
     <!--                            </div>-->
     <!--            </div>-->
     <!--        </div>-->
     <!--    </div>-->
     <!--</div>-->

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold" style="color: #155f53">Registered Packages/Subscriptions</h6>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Package Name</th>
                                    <th scope="col">Period</th>
                                    <th scope="col">Amount (KSH.)</th>
                                    <th scope="col">Discounted Amount (KSH.)</th>
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
                                        <td>{{$package->amount}}</td>
                                        <td>{{$package->discounted_amount}}</td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="{{route('edit.package',['slug'=>$package->slug])}}"><small>Edit</small></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">

                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold"  style="color: #155f53">User Subscription</h6>
                    </div>
                    <div class="card-body">
                        <h4 class="small font-weight-bold">Day Pass <span class="float-right">{{$day_pass}}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{$day_pass}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Weekly Subscription <span class="float-right">{{$weekly_pass}}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{$weekly_pass}}%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Monthly Subscription <span class="float-right">{{$monthly_pass}}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="width: {{$monthly_pass}}%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
        </div>
        </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold"  style="color: #155f53">Successful Orders</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered " id="orders">
                                    <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Order Number</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Package</th>
                                        <th scope="col">Amount(KSH)</th>
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
            <div class="row justify-content-end">
                <button onclick="topFunction()" id="myBtn" title="Go to top" class="btn-outline-danger btn btn-sm mr-5">Top</button>
            </div>

    </div>

@endsection
@section('js')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{--    <script type="text/javascript" src="{{asset('datatables/jquery-3.4.1.min.js')}}"></script>--}}
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

        // $('#locations').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: '{!! route('locations.data')!!}',
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'colvis','copy', 'excel', 'print',

        //         {
        //             extend: 'csvHtml5',
        //             text: 'CSV',
        //             exportOptions: {
        //                 columns: [0,1, 2,3,4, 5,6,7,8],
        //             },
        //             footer: true,
        //         },
        //         'pageLength'
        //     ],
        //     columns: [
        //         {data: 'id', name: 'id'},
        //         {data: 'main_image', name: 'main_image', orderable: false, searchable: false},
        //         // {data: 'slider_images', name: 'slider_images'},
        //         {data: 'restaurant_name', name: 'restaurant_name'},
        //         {data: 'location', name: 'location'},
        //         {data: 'available_seats', name: 'available_seats'},
        //         {data: 'host', name: 'host'},
        //         {data: 'created_at', name: 'created_at'},
        //         {data: 'status', name: 'status'},
        //         {data: 'open_close', name: 'open_close' , orderable: false, searchable: false},
        //         {data: 'action', name: 'action', orderable: false, searchable: false}

        //     ]
        // });

        $('#orders').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('orders.data')!!}',
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
            columns: [
                {data: 'id', name: 'id'},
                {data: 'order_number', name: 'order_number'},
                {data: 'user', name: 'user'},
                {data: 'package', name: 'package'},
                {data: 'amount', name: 'amount'},
                {data: 'created_at', name: 'created_at'},
                {data: 'expires_at', name: 'expires_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}

            ],
            order: [0,'desc']
        });
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Source', 'Number of Users'],
                ['Referrals',     {{$referral}}],
                ['Press',      {{$press}}],
                ['Social Media',  {{$socials}}],
                ['Onlide Ads',  {{$ads}}],
                ['Google Search', {{$google}}]
            ]);

            var options = {
                title: 'Where our Users heard about us from',
                pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Total Earnings', 'Amount (KSH)'],
                ["PayPal Purchases", {{$converted_rev}}],
                ["Mpesa Purchases", {{$mpesarevenue}}],
            ]);

            var options = {
                legend: { position: 'none' },
                chart: { title: 'Revenue Summary',
                    subtitle: 'PayPal Amount in Ksh. exchange rate used 1$ = {{number_format($rate, 2)}}' },
                bars: 'horizontal', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: { side: 'top', label: 'Ksh'} // Top x-axis.
                    }
                },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.charts.Bar(document.getElementById('top_x_div'));
            chart.draw(data, options);
        };
    </script>

    <script>
        //Get the button
        var mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

    @endsection