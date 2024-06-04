<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'MundoClip'))</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon1.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon1.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        .navbar-custom {
            background-color: #38B6FF;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .navbar-toggler-icon {
            color: white;
        }
        .dropdown-menu {
            background-color: #38B6FF;
        }
        .dropdown-item {
            color: white;
        }
        .dropdown-item:hover {
            background-color: #32A3E1;
        }
        .sidebar {
            height: 100vh;
            background-color: #2A2A2A;
            color: white;
            position: fixed;
            width: 250px;
            padding-top: 1rem;
            transition: transform 0.3s ease;
            transform: translateX(-250px);
        }
        .sidebar.show {
            transform: translateX(0);
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 0.5rem 1rem;
        }
        .sidebar a:hover {
            background-color: #1E1E1E;
        }
        .content {
            margin-left: 0;
            padding: 1rem;
            transition: margin-left 0.3s ease;
        }
        .content.shifted {
            margin-left: 250px;
        }
        .btn-primary {
            background-color: #38B6FF;
            border-color: #38B6FF;
        }
        .btn-primary:hover {
            background-color: #32A3E1;
            border-color: #32A3E1;
        }
        .btn-secondary {
            background-color: #E0E0E0;
            border-color: #E0E0E0;
            color: #000;
        }
        .btn-secondary:hover {
            background-color: #CCCCCC;
            border-color: #CCCCCC;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom shadow-sm">
            <div class="container">
                @auth
                    <button class="btn btn-outline-light me-2" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                @endauth
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'MundoClip') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @if (!Route::currentRouteNamed('login') && !Route::currentRouteNamed('register'))
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profiles.search') }}">
                                    <i class="fas fa-search"></i> Buscar Usuarios
                                </a>
                            </li>
                        </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <!-- Button to upload video -->
                            <li class="nav-item me-3">
                                <a class="btn btn-primary" href="{{ route('videos.create') }}">
                                    <i class="fas fa-upload"></i> Subir Video
                                </a>
                            </li>
                        @endauth
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus"></i> {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile.show', Auth::user()->id) }}">
                                    <i class="fas fa-user"></i> Perfil
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
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

        @auth
            <div class="sidebar" id="sidebar">
                <a href="{{ route('videos.index') }}">
                    <i class="fas fa-video"></i> Videos
                </a>
                <a href="{{ route('statistics.index') }}">
                    <i class="fas fa-chart-bar"></i> Estadísticas
                </a>
                <a href="{{ route('settings.edit') }}">
                    <i class="fas fa-cogs"></i> Configurar Perfil
                </a>
            </div>
        @endauth

        <main class="py-4 content">
            @yield('content')
        </main>

        @yield('scripts')

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const content = document.querySelector('.content');

                if (sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    content.classList.remove('shifted');
                } else {
                    sidebar.classList.add('show');
                    content.classList.add('shifted');
                }
            }
        </script>
    </div>
</body>
</html>
