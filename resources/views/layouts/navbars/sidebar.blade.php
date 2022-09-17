<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand pt-0 d-flex justify-content-between" href="{{ route('home') }}">
            <img src="{{ asset('public/argon') }}/img/brand/logo.png" class="navbar-brand-img" alt="..."><h1>{{__('Colingual')}}</h1>
        </a>
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('public/argon') }}/img/theme/logo.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="ni ni-settings-gear-65"></i>--}}
{{--                        <span>{{ __('Settings') }}</span>--}}
{{--                    </a>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="ni ni-calendar-grid-58"></i>--}}
{{--                        <span>{{ __('Activity') }}</span>--}}
{{--                    </a>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="ni ni-support-16"></i>--}}
{{--                        <span>{{ __('Support') }}</span>--}}
{{--                    </a>--}}
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('public/argon') }}/img/brand/logo.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
{{--            <form class="mt-4 mb-3 d-md-none">--}}
{{--                <div class="input-group input-group-rounded input-group-merge">--}}
{{--                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <span class="fa fa-search"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{Request::is('home')?'active':''}}" href="{{ route('home') }}">
                        <i class="ni ni-tv-2"></i> <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::is('user')?'active':''}}" href="{{ route('user') }}">
                        <i class="far fa-user"></i>{{ __('Users') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::is('language')?'active':''}}" href="{{ route('language.index') }}">
                        <i class="fas fa-language"></i>{{ __('Languages') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::is('quiz*')?'active':''}}" href="{{ route('quiz') }}">
                        <i class="fas fa-stopwatch"></i>{{ __('Quiz') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
