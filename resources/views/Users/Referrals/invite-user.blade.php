@extends('layouts.master')
@section('title', 'Verify Invite Code')


@section('content')
    <style>
        .text-color{
            color: #1a9082;
        }
        .btn-theme{
            background-color: #1a9082;
            color: white;

        }
        .circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            color: #fff;
            line-height: 50px;
            text-align: center;
            background: #1a9082;
        }

            .fa-facebook-square{
                color: #3b5998;
            }
            .fa-whatsapp-square{
                color: #25D366;
            }
            .fa-at{
                color: #B23121;
            }
            .fa-twitter-square{
                color: #00acee;
            }

    </style>

    <script>
        function myFunction() {
            var copyText = document.getElementById("invite_message");
            navigator.clipboard.writeText(copyText.textContent)
            alert("Message copied!");
        }
    </script>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        @if(Session::has('info'))
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p class="alert alert-info text-center">{{ Session::get('info') }}</p>
                </div>
            </div>
        @endif

            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-color">Send an invitation to a friend</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="text-center">
                            <h4>Coworking is better with friends!</h4>
                            <p>nvite your friends and earn credits and they will get 50% off their first month! There is no limit to the credits you can earn.</p>
                            <p>Your code is:</p>
                            <h4 class="text-color">{{$user->invite_code}}</h4>
                            <hr>
                        </div>
                        <div class="row justify-content-center">
                            <h5>How it Works!</h5>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-xs-12 col-sm-4">
                                <div class="container align-content-center  circle">1</div>
                                <p class="text-center">You tell a friend about TOFFEETRIBE</p>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="container align-content-center  circle">2</div>
                                <p class="text-center">Your friend buys a membership using the promo code <strong class="text-color">{{$user->invite_code}}</strong></p>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                    <div class="container align-content-center circle">3</div>
                                <p class="text-center">You get 50% off your next month and your friend gets 50% off their first month</p>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div id="invite_message" onclick="myFunction()" class="col-xs-12 col-sm-12 col-md-8" style="width:240px;background: #e9f5f3" onmouseover="this.style.background='#bfd9d4';" onmouseout="this.style.background= '#e9f5f3';">
                             <p>Hiya [Friends Name],<br>
                                 <br>Take a look at this new company, I think you'll like it!<br>
                                 <br>I’ve been using Toffee Tribe, a kick-start that helps the coworking tribe access coworking spaces in restaurants and cafes. There is plenty of coffee, tea, blazing-fast wifi, community connections, and monthly fun activities and events to help you take a break from work. You honestly can't get all these cool necessities working from home or coffee shops.
                                 <br>The first three days are free for everyone but if you become a member afterward with my code {{$user->invite_code}} you’ll get 50% off your first month and guess what, I get a credit too if you join 😊<br>
                                 <br>You can start your three days free trial on their website https://www.toffeetribe.com/<br>
                                 <br>Let's Grind!<br>
                                 <br>-{{$user->full_name}}</p>

{{--                                <p>Hi [Friends Name],<br>--}}
{{--                                    <br>I’ve been using Toffee Tribe, a startup that turns excess space in beautiful restaurants into a network of super flexible &amp; affordable coworking spaces. All the necessities like coffee, tea, snacks, and fast wifi are included - it’s way better than working at home or in coffee shops.<br>--}}
{{--                                    <br>The first week is free for everyone but if you become a member afterwards with my code {{$user->invite_code}} you’ll get 50% off your first month. (Full disclosure: I get a credit too if you join 😉)<br>--}}
{{--                                    <br>You can start your free trial week on their website https://www.toffeetribe.com/<br>--}}
{{--                                    <br>Let's Grind!<br>--}}
{{--                                    <br>-{{$user->full_name}}</p>--}}
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                                <p>Share via:</p>
                            <div class="col-md-1 "><a href=""><i class="fab fa-facebook-square fa-3x"></i></a></div>
                            <div class="col-md-1 "><a href="https://api.whatsapp.com/send?text={{$text}}" target="_blank"><i class="fab fa-whatsapp-square fa-3x"></i></a></div>
                            <div class="col-md-1 "><a href="{{route('email')}}"><i class="fas fa-at fa-3x"></i></a></div>
                            <div class="col-md-1 "><a href="https://twitter.com/intent/tweet?text={{$text}}"><i class="fab fa-twitter-square fa-3x"></i></a></div>

                        </div>


                    </div>
                </div>
            </div>

        </div>


{{--    </div>--}}
@endsection