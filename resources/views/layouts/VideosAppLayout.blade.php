<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Assets compilados -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-[#100c0c]">

<!-- Navbar -->
<nav class="bg-gray-800 p-6 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Enlace a vídeos -->
        <a href="{{ route('videos.index') }}" class="text-white text-lg font-semibold">Vídeos</a>

        <!-- Enlace a gestionar vídeos para usuarios con el permiso `manage-videos` -->
        @can('manage-videos')
            <a href="{{ route('videos.manage.index') }}" class="text-white text-lg font-semibold ml-6">Gestionar Vídeos</a>
        @endcan

        <!-- Autenticación -->
        <div class="ml-auto relative" x-data="{ open: false }">
            @auth
                <!-- Si el usuario está autenticado -->
                <button @click="open = !open" class="flex items-center text-white focus:outline-none">
                    <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-profile.png') }}" alt="Perfil" class="w-8 h-8 rounded-full">
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                    <a href="{{ route('profile.show') }}"
                       class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <!-- Si el usuario NO está autenticado -->
                <a href="{{ route('login') }}" class="text-white bg-blue-500 px-4 py-2 rounded-md hover:bg-blue-600">
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- Contenido principal -->
<div class="flex-grow">
    <div class="container mx-auto py-6">
        @yield('content')
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-800 p-6 mt-auto">
    <div class="container mx-auto text-center text-white">
        &copy; {{ date('Y') }} La Meva Aplicació. Tots els drets reservats.
    </div>
</footer>

<!-- Scripts de Livewire u otros, si los usas -->
@livewireScripts
</body>
</html>
