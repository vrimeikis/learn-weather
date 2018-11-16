<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="NOINDEX, NOFOLLOW">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>

<div id="weather-data">
    <p>Temp: {{ $weatherData->main->temp }} C</p>
    <p>Wind speed: {{ $weatherData->wind->speed}} m/s</p>
    <p>Wind direction: {{ $weatherData->wind->deg}} degrees</p>
    <p>Wind direction: {{ $weatherData->wind->degHuman }}</p>
</div>

<div class="col-md-12">

    <form>

    <p>Subscribe</p>
    <input class="col-md-12" type="email" id="email" name="email" value="" placeholder="Enter email...">
    <button class="btn btn-success" onclick="makeSubscribe();" type="button">Subscribe</button>
    </form>

</div>

<script>
    function makeSubscribe() {
        let email = $('#email').val();

        $.ajax({
            url: '{{ route('api.subscribe') }}',
            method: 'POST',
            data: { email: email},
            statusCode: {
                200: function (data) {
                    alert(data.message);
                    $('#email').val('');
                },
                422: function (data) {
                    alert(data.responseJSON.errors.email);
                }
            }
        });
    }
</script>

</body>
</html>