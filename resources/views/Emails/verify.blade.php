@component('mail::message')


<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Toffee Verify Address</title>

    <!-- <link rel="stylesheet" href="bootstrap2.css"> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        @import url(http://fonts.googleapis.com/css?family=Bree+Serif);
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Bree Serif', serif;
        }
        
        table.borderless td,
        table.borderless th {
            border: none !important;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="row">
            <div class="col-xs-6">
                <h1>
                <a href="https://www.toffeetribe.com/toffeetribe/">
                  <img style="width: 105.9px; height: 46.6px;" src="https://toffeetribe.com/emImages/Toffee-Tribe-Logo-2.png">                 
                </a>
              </h1>
            </div>

        </div>

        <div  align="center" style="background-color: #155F53;" class="jumbotron text-center">

            <img style="width: 128px; height: 72px;" src="https://toffeetribe.com/emImages/inboxicon.png">
        </div>

        <div>
            <h4>YOU'RE ONE STEP AWAY</h4>

            <p style="font-size: 45px; "><b>Verify your email <br> address</b></p>
            <p>To complete your sign up process, please verify your email</p>
        </div>

        <div style="margin-bottom: 50px;" class="text-center">

    <!--         <a style="background-color: #61b7b4; border-color: none; border-radius: 0px; text-transform: capitalize!important;" class="btn btn-primary btn-lg" href="">Verify Email Address</a> -->
            @component('mail::button', ['url' => $url]) Verify Email Address @endcomponent

        </div>

        <div>
            <p>If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below int your browser: </p>
            <a href="{{$url}}">{{$url}}</a>
        </div>

        <br>
        <br>

        <div class="text-center">
            <h4 align="center">APP DOWNLOAD</h4>
        </div>

        <div align="center" class="text-center jumbotron">

            <a style="text-decoration: none;" href="https://play.google.com/store/apps/details?id=io.ionic.mato">
                <img style="width: 129.2px; height: 50px;" src="https://toffeetribe.com/emImages/playstore.png">
                <!-- <span style="color: #155F53;">ANDROID</span> -->
            </a>
             
            <a style="text-decoration: none;" href="">
                <img style="width: 129.2px; height: 50px;" src="https://toffeetribe.com/emImages/appstore.png">
                <!-- <span style="color: #155F53;">IOS</span> -->
            </a>

        </div>

        <br>
        <br>

    </div>

</body>

</html>

Warm Regards,

<br> {{ config('app.name') }} @endcomponent