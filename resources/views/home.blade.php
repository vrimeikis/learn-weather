@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <div id="weather-data">
                            <p>Temp: {{ $weatherData->main->temp }} C</p>
                            <p>Wind speed: {{ $weatherData->wind->speed}} m/s</p>
                            <p>Wind direction: {{ $weatherData->wind->deg}} degrees</p>
                            <p>Wind direction: {{ $weatherData->wind->degHuman }}</p>
                        </div>

                        <div class="col-md-12">

                            <form>

                                <p>Subscribe</p>
                                <input class="col-md-12" type="email" id="email" name="email" value=""
                                       placeholder="Enter email...">
                                <button class="btn btn-success" onclick="makeSubscribe();" type="button">Subscribe
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function makeSubscribe() {
        let email = $('#email').val();

        $.ajax({
            url: '{{ route('api.subscribe') }}',
            method: 'POST',
            data: {email: email},
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
