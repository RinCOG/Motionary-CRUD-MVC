<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dictionary') | Motionary</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg site-nav">
            <div class="container">
                <a class="brand-lockup" href="{{ route('home') }}" aria-label="Motionary dictionary home">
                    <span class="brand-mark"><i class="fas fa-book-open" aria-hidden="true"></i></span>
                    <span><span class="brand-name">Motionary</span><span class="brand-caption">WORDS IN MOTION</span></span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavigation">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Dictionary</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('word-of-the-day') ? 'active' : '' }}" href="{{ route('word-of-the-day') }}">Word of the day</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('grammar') ? 'active' : '' }}" href="{{ route('grammar') }}">Grammar</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('slang') ? 'active' : '' }}" href="{{ route('slang') }}">Slang</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('games') ? 'active' : '' }}" href="{{ route('games') }}">Games</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('camera') ? 'active' : '' }}" href="{{ route('camera') }}">Camera</a></li>
                        @auth
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('words.*') ? 'active' : '' }}" href="{{ route('words.index') }}">My words</a></li>
                        @endauth
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        @guest
                            <a class="nav-link text-white" href="{{ route('login') }}">Sign in</a>
                            <a class="btn btn-success btn-sm px-3" href="{{ route('register') }}">Join Motionary</a>
                        @else
                            <div class="nav-user d-none d-lg-flex"><span class="nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span><a class="text-white text-decoration-none" href="{{ route('dashboard') }}">{{ Auth::user()->name }}</a></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="nav-logout" type="submit">Sign out</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="app-main">
            @if (session('success'))
                <div class="app-container mb-3"><div class="alert alert-success alert-dismissible fade show mb-0" role="status">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div></div>
            @endif
            @if (session('error'))
                <div class="app-container mb-3"><div class="alert alert-danger mb-0" role="alert">{{ session('error') }}</div></div>
            @endif
            @yield('content')
        </main>

        <footer class="site-footer"><div class="app-container"><span>Motionary · A touchless dictionary study</span><span><a href="{{ route('about') }}">About the study</a> · <a href="{{ route('contact') }}">Contact</a> · {{ date('Y') }}</span></div></footer>
    </div>
</body>
</html>
