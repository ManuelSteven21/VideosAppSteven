<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Incluir el archivo CSS -->
    @vite(['resources/css/app.css'])
</head>
<body>
<!-- Navbar -->
<nav class="navbar">
    <a href="{{ route('videos.index') }}" class="navbar-brand">VideosAppSteven</a>
    <div class="nav-links">
        <a href="{{ route('videos.index') }}">Vídeos</a>
        @can('manage-videos')
            <a href="{{ route('videos.manage.index') }}">Gestionar Vídeos</a>
        @endcan
        @auth
            <a href="{{ route('users.index') }}">Usuaris</a>
        @endauth
        @can('manage-users')
            <a href="{{ route('users.manage.index') }}">Gestionar Usuaris</a>
        @endcan
    </div>
    <div class="user-dropdown" x-data="{ open: false }">
        @auth
            <button @click="open = !open">
                <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-profile.png') }}" alt="Perfil">
            </button>
            <div x-show="open"
                 @click.away="open = false"
                 class="dropdown-menu"
                 x-cloak
                 style="display: none;">
                <a href="{{ route('profile.show') }}">Perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="login-button">Login</a>
        @endauth
    </div>
</nav>

<!-- Contenido principal -->
<main class="main-content">
    @yield('content')
</main>

<!-- Footer -->
<footer class="footer">
    &copy; {{ date('Y') }} La Meva Aplicació. Tots els drets reservats.
</footer>

<!-- Scripts de Livewire u otros, si los usas -->
@livewireScripts
<script src="//unpkg.com/alpinejs" defer></script>
@vite(['resources/js/app.js'])
</body>
</html>
