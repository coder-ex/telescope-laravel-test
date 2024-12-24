<!DOCTYPE html>
<html lang="ru">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- CSRF Token -->
        <title>{{config('app.name', 'Laravel')}}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <!-- Font Awesome 4.7 -->
        {{-- <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet"> --}}
        <!-- Styles -->
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
        <!-- Scripts -->
        @vite('resources/js/app.js')
    </head>

    <body>
        <div id="app"></div>
    </body>

</html>