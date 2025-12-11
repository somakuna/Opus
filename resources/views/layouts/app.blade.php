<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Opus') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/img/site.webmanifest">
    <link rel="mask-icon" href="/img/safari-pinned-tab.svg" color="#ff0000">
    <link rel="shortcut icon" href="/img/favicon.ico">
    <meta name="msapplication-TileColor" content="#a00000">
    <meta name="msapplication-config" content="/img/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Almarai" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css" >   
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-dark-subtle">
    <div id="app">
        <nav class="navbar navbar-expand-md bg-body shadow-sm">
            <div class="container-fluid">
                <div class="col-lg-3">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/img/logo.svg" height="40" width="40" alt="Logo"/> {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse d-lg-flex" id="navbarSupportedContent">
                    <ul class="navbar-nav col-lg-8 justify-content-lg-center">
                        <!-- Authentication Links -->
                        @guest
                            {{-- @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item link-secondary">
                                <a class="nav-link" href="{{ route('work.create') }}">
                                    <i class="bi bi-journal-plus"></i> Add new work
                                </a>
                            </li>
                            <li class="nav-item link-secondary">
                                <a class="nav-link" href="{{ route('work.show_deleted') }}">
                                    <i class="bi bi-recycle"></i> Deleted works
                                </a>
                            </li>
                            <li class="nav-item link-secondary">
                                <a class="nav-link" href="{{ route('loan.index') }}">
                                    <i class="bi bi-currency-exchange"></i> Loans
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link link-secondary" href="{{ route('item.index') }}">
                                    <i class="bi bi-arrow-down-up"></i> Lendings
                                </a>
                            </li>
                            <li class="nav-item link-secondary">
                                <a class="nav-link" href="{{ route('note.index') }}">
                                    <i class="bi bi-chat"></i> Notes
                                </a>
                            </li>
                            <li class="nav-item link-secondary">
                                <a class="nav-link" href="{{ route('partner.index') }}">
                                    <i class="bi bi-people"></i> Partners
                                </a>
                            </li>
                            <li class="nav-item link-secondary dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-down"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="my-2">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="/vendor/livewire-charts/app.js"></script>
</body>
</html>
