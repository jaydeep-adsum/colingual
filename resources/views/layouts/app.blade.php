<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Argon Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('public/argon/img/brand/favicon.png') }}" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('public/argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('public/argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('public/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('public/argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
{{--        <style>--}}
{{--            .bg-gradient-primary{--}}
{{--                background: linear-gradient(87deg, #639B2B 0, #FFCC26 100%) !important;--}}
{{--            }--}}
{{--        </style>--}}
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth

        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
{{--            @include('layouts.footers.guest')--}}
        @endguest

        <script src="{{ asset('public/argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('public/argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('public/assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('public/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
        @stack('js')

        <!-- Argon JS -->
        <script src="{{ asset('public/argon') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>
