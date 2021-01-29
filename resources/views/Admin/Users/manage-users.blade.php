@extends('layouts.system')
@section('title', 'Registered Users')
@section('css')
    <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        @if(Session::has('error'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-danger text-center">{{ Session::get('error') }}</p>
                </div>
            </div>
        @endif
        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif
        <div class="row">
            <h4 style="color: #1a9082">Manage Registered Users </h4>
            <div class="col-md-2 mb-1">
                <a href="{{route('user.register')}}" class="btn btn-outline-success btn-sm"><b>+</b>  Register New User</a>
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
                                    <th scope="col">Email</th>
{{--                                    <th scope="col">@username</th>--}}
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Date Registered</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Actions</th>
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
{{--                                                @if($user->id != \Illuminate\Support\Facades\Auth::user()->id)--}}
{{--                                                    @if($user->hasRole('admin'))--}}
{{--                                                        <a class="btn btn-warning btn-sm btn-prevent" href="{{route('remove.admin',['userId'=>$user->id])}}" ><small>Remove-Admin</small></a>--}}
{{--                                                    @else--}}
{{--                                                        <a class="btn btn-primary btn-sm btn-prevent" href="{{route('make.admin',['userId'=>$user->id])}}"><small>Make-Admin</small></a>--}}
{{--                                                    @endif--}}
{{--                                                        @if($user->hasRole('host'))--}}
{{--                                                            <a class="btn btn-danger btn-sm btn-prevent mt-1" href="{{route('remove.host',['userId'=>$user->id])}}" ><small>Remove-Host</small></a>--}}
{{--                                                        @else--}}
{{--                                                            <a class="btn btn-info btn-sm btn-prevent mt-1" href="{{route('make.host',['userId'=>$user->id])}}"><small>Make-Host</small></a>--}}
{{--                                                        @endif--}}
{{--                                                @endif--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
                                </tbody>
                            </table>

{{--                                <small>{!! $users->appends(request()->input())->links() !!}</small>--}}

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
        $('#users').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('manage.users.data')!!}',
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
                {data: 'full_name', name: 'full_name'},
                {data: 'email', name: 'email'},
                // {data: 'username', name: 'username'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'date_registered', name: 'date_registered'},
                {data: 'role', name: 'role'},
                {data: 'action', name: 'action', orderable: false, searchable: false}

            ]
        });
    </script>
    @endsection