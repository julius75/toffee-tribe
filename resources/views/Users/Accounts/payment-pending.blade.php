@extends('layouts.app')

@section('css')
    <style>
        #loading
        {
            text-align:center;
            background: url('{{asset('images/toffee_loader.gif')}}') no-repeat center;
            height: 400px;
        }
    </style>
    @endsection
@section('content')


    <div class="container">

        @if(Session::has('status'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-success text-center">{{ Session::get('status') }}</p>
                </div>
            </div>
        @endif
            @if(Session::has('error'))
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <p class="alert alert-warning text-center">{{ Session::get('error') }}</p>
                    </div>
                </div>
            @endif


    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="col-lg-12 d-none d-lg-block " style="text-align:center">
                            <img src="{{asset('illustrations/idea_applications.svg')}}" class="mt-1 ml-0 " style="width: 50%; height: 40%; " alt="SVG not supported">
                        </div>
                <p style="text-align: center">Once paid and you have received an M-PESA confirmation, click <a class="btn btn-sm btn-success" href="{{route('check.mpesa.confirm', ['orderId'=>encrypt($order->id)])}}">Finish</a></p>
            </div>


        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // $(document).ready(function(){
       
    // // function updatePost() {
    //     setInterval(function() {
    //         $.ajax({
    //             method: "GET",
    //             url: "{{route('check.mpesa',['orderId'=>encrypt($order->id)])}}",
    //             success: function(response) {
    //                 // If not false, display alert
    //                 if (response) {
    //                     alert("Payment Complete!");
    //                 }
    //             }
    //         });
    //     }, 5000);
    // // }
    // });
</script>
@endsection
