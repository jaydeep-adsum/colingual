<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Colingual') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('public/favicon.jpg') }}" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('public/argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/sweetalert.css') }}">
        <link href="{{ asset('public/argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('public/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
        <!-- Argon CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="{{ asset('public/css/iziToast.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('public/argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <style>
            .mandatory{
                font-weight: bold;
                color: #cf0000;
            }
            .edit-btn{
                background-color:#5e72e4;
                color: #ffffff !important;
            }
            .delete-btn{
                background-color: #ff001e;
                color: #ffffff !important;
            }
            .navbar-light .navbar-nav .nav-link{
                font-weight: 600;
            }
            .active{
                background-color: #f6f9fc;
                border-bottom-right-radius: 0.5rem;
                margin-right: 5px;
                border-top-right-radius: 0.5rem;
            }
            .navbar-vertical.navbar-expand-md .navbar-nav .nav-link.active:before{
                left: 5px;
                border-left: 4px solid #5e72e4;
            }
        </style>
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
        <script src="{{ asset('public/assets/js/sweetalert.min.js') }}"></script>
        <script src="{{asset('public/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{ asset('public/js/custom.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('public/js/iziToast.js') }}"></script>
        @stack('js')

        <!-- Argon JS -->
        <script src="{{ asset('public/argon') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>
