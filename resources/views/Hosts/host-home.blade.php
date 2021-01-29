@extends('layouts.admin')
@section('title', 'Host Check-In')
@section('content')
    <style>
        .theme-text{
            color: #1a9082;
        }
        .days-of-week{
            margin-top: 10px;
        }
        .map{
            margin-top: 40px;
        }
    </style>

    <div class="container-fluid">
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
            @if(Session::has('success'))
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <p class="alert alert-success text-center">{{ Session::get('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary mt-0">Total Visits</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$visits['total']}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-gifts fa-lg text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger mt-0">Visits (Month)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$visits['month']}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-circle fa-lg text-danger"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary mt-0">Visits (Week)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$visits['week']}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-lg text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success  mt-0">Visits (Today)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$visits['today']}}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-check fa-lg text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                    <th scope="col">User</th>
{{--                                                    <th scope="col">Package Type</th>--}}
                                                    <th scope="col">Arrival Time</th>
                                                    <th scope="col">Departure Time</th>
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
                <div class="col-md-5">
                    <div class="card mb-2" style="">
                                <img class="card-img-top" src="{{asset('storage/app/location-images/'.$location->image)}}" style= "object-fit: fill; max-width: 100%; height: 100%; background-position: center center; background-repeat: no-repeat; overflow: hidden;object-position: center; " alt="image could not load">
                                <div class="row">
                                    <div class="col-md-12">
                                    <h5 class="theme-text text-center mt-2 mb-0" style="font-weight: bolder">{{$location->restaurant_name}}</h5>
                                        @if($location->set_closed == 1)
                                            <p class="text-center mb-0"><i class="fa fa-circle fa-xs" style="color: grey"></i> Closed For Today</p>
                                        @else
                                            @if(strstr($location->days->implode('day_of_week', ','), $weekday))
                                                @if($location->tribe_capacity == 0)
                                                    <p class="mt-1 text-center mb-0"><i class="fa fa-circle fa-xs" style="color: grey"></i> NO SITTING  SPACE AVAILABLE</p>
                                                @else
                                                    <p class="text-center mb-0"><i class="fa fa-circle fa-xs" style="color: #0fdb5e"></i> Available Spaces: {{$location->tribe_capacity}}</p>
                                                @endif
                                            @else
                                                <p class="text-center mb-0"><i class="fa fa-circle fa-xs" style="color: grey"></i> Closed</p>
                                            @endif
                                        @endif
                                        <div class="row justify-content-center mt-2">
                                            <a class="btn btn-secondary btn-sm mr-1 mb-1" href="{{route('host.checkIn.index',['slug'=>$location->slug])}}"><small>Check-In Users</small></a>
                                            <a class="btn btn-warning btn-sm mb-1" href="{{route('host.monthly_visits',['slug'=>$location->slug])}}"><small>Monthly Visit Metrics</small></a>
                                        </div>
                                        <h6 class="theme-text text-center mt-2">Description:</h6>
                                        <p class="text-center ">{{$location->description}}</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-center theme-text mt-1">Address / Location:</h6>
                                                <p class="text-center">{{$location->location}}</p>
                                                <h6 class="text-center theme-text mt-1">Amenities Offered: </h6>
                                                <p class="text-center">{!! $location->amenities !!}</p>
                                                <h6 class="text-center theme-text mt-1">Food & Beverage </h6>
                                                <p class="text-center">{!! $location->food_beverage !!}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-center theme-text">Days Of The Week Available:</h6>
                                                <div class="days-of-week">
                                                    @if($days != null)
                                                        @foreach($days as $day)
                                                            <p class="text-center">{{$day->day_of_week}} - {{date('h:i A', strtotime($day->opening_time))}} - {{date('h:i A', strtotime($day->closing_time))}}</p>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-4">
                                    <div class="col-md-11">
                                        <div class="gmap_canvas map">
                                            <iframe style="width: 100%" {!! $location_map->iframe !!} </iframe>
                                        </div>
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
            ajax: '{!! route('host.visits_data')!!}',
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'print',
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0,1, 2,3],
                    },
                    footer: true,
                },
                'pageLength'
            ],
            "lengthMenu": [[15, 30, -1], [15, 30, "All"]],
            order: [0, 'desc'],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'order_number', name: 'order_number'},
                {data: 'user', name: 'user'},
                {data: 'arrival_time', name: 'arrival_time'},
                {data: 'departure', name: 'departure'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],

        });
    </script>

@endsection
