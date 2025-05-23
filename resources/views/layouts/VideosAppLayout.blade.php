<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col bg-gray-50" x-data="{ mobileMenuOpen: false }">
<!-- Navbar -->
<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('videos.index') }}" class="text-xl font-bold text-red-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    VideosAppSteven
                </a>
            </div>

            <!-- Desktop nav -->
            <div class="hidden md:flex md:space-x-8 items-center">
                @include('layouts.partials.nav-links')
            </div>

            <!-- Perfil Desktop -->
            <div class="hidden md:flex md:items-center">
                @auth
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="Perfil">
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <a href="{{ route('profile.show') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Tancar sessió
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                        Iniciar sessió
                    </a>
                @endauth
            </div>

            <!-- Botó del menú mòbil -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = true"
                        class="text-gray-600 hover:text-red-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú desplegable mòbil -->
    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition transform ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg z-50 p-6 space-y-4 md:hidden"
        @click.away="mobileMenuOpen = false"
        x-cloak
    >
        <!-- Botó per tancar -->
        <div class="flex justify-end">
            <button @click="mobileMenuOpen = false" class="text-gray-600 hover:text-red-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        @include('layouts.partials.nav-links')

        @auth
            <hr class="border-gray-200">
            <a href="{{ route('profile.show') }}"
               class="block text-gray-800 font-semibold hover:text-red-600">
                👤 Perfil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left text-gray-800 font-semibold hover:text-red-600">
                    🚪 Tancar sessió
                </button>
            </form>
        @else
            <hr class="border-gray-200">
            <a href="{{ route('login') }}"
               class="block text-gray-800 font-semibold hover:text-red-600">
                🔐 Iniciar sessió
            </a>
        @endauth
    </div>
</nav>

<!-- Contenido principal -->
<main class="flex-grow">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <p class="text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} VideosAppSteven. Tots els drets reservats.
        </p>
    </div>
</footer>

@livewireScripts
</body>
</html>
