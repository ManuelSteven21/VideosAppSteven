<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col bg-gray-50">
<!-- Navbar -->
<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('videos.index') }}" class="text-xl font-bold text-red-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    VideosAppSteven
                </a>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('videos.index') }}"
                       class="{{ request()->routeIs('videos.index') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Vídeos
                    </a>

                    @can('manage-videos')
                        <a href="{{ route('videos.manage.index') }}"
                           class="{{ request()->routeIs('videos.manage.*') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Gestionar Vídeos
                        </a>
                    @endcan

                    @auth
                        <a href="{{ route('users.index') }}"
                           class="{{ request()->routeIs('users.index') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Usuaris
                        </a>
                    @endauth

                    @can('manage-users')
                        <a href="{{ route('users.manage.index') }}"
                           class="{{ request()->routeIs('users.manage.*') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Gestionar Usuaris
                        </a>
                    @endcan

                    @auth
                        <a href="{{ route('series.index') }}"
                           class="{{ request()->routeIs('series.index') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Series
                        </a>
                    @endauth

                    @can('manage-series')
                        <a href="{{ route('series.manage.index') }}"
                           class="{{ request()->routeIs('series.manage.*') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Gestionar Series
                        </a>
                    @endcan

                    @can('manage-users')
                        <a href="{{ url('/notifications') }}"
                           class="{{ request()->is('notifications') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Notificacions
                        </a>
                    @endcan
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <button @click="open = !open" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_url}}" alt="Perfil">
                        </button>

                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                             role="menu"
                             x-cloak>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Perfil</a>
                            <form method="POST" action="{{ route('logout') }}" role="none">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Tancar sessió
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Iniciar sessió
                    </a>
                @endauth
            </div>
        </div>
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
