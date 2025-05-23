@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if (session('success') || session('error'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 4000)"
                    class="mb-4 px-4 py-3 rounded-md shadow-md max-w-xl mx-auto
            {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}"
                >
                    <p class="text-sm font-medium">
                        {{ session('success') ?? session('error') }}
                    </p>
                </div>
            @endif
            <!-- Contenedor del vídeo -->
            <div class="relative pb-[56.25%] bg-black"> <!-- 16:9 aspect ratio -->
                <iframe
                    src="{{ $video->url }}"
                    class="absolute top-0 left-0 w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>

                <!-- Informació del vídeo -->
                <div class="p-6 space-y-4">
                    <!-- Títol i accions -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $video->title }}</h1>

                        @auth
                            @php
                                $canManage = auth()->user()->can('manage-videos');
                                $canEditOwn = auth()->user()->can('create-videos') && $video->user_id === auth()->id();
                            @endphp

                            @if ($canManage || $canEditOwn)
                                <div class="flex gap-2">
                                    <a href="{{ route('videos.manage.edit', $video->id) }}"
                                       class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <a href="{{ route('videos.manage.delete', $video->id) }}"
                                       class="inline-flex items-center px-3 py-1 border border-transparent rounded-md text-sm text-white bg-red-600 hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                        Eliminar
                                    </a>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <!-- Descripció -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-1">Descripció</h2>
                        <p class="text-sm text-gray-700 whitespace-pre-line">
                            {{ $video->description ?: 'Aquest vídeo no té cap descripció.' }}
                        </p>
                    </div>

                    <!-- Publicació -->
                    <div class="text-xs text-gray-500">
                        Publicat: {{ $video->formatted_for_humans_published_at ?? 'Desconegut' }}
                    </div>
                </div>

                <!-- Navegació entre vídeos -->
                <div class="border-t border-gray-200 px-4 sm:px-6 py-4 bg-gray-50 flex flex-col sm:flex-row sm:justify-between gap-3 sm:items-center">
                @if($previous)
                        <a href="{{ route('videos.show', $previous->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="mr-2 h-5 w-5 text-gray-500" viewBox="0 0 24 24">
                                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                            </svg>
                            Anterior
                        </a>
                    @else
                        <span class="flex justify-center items-center text-center inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                        <svg class="mr-2 h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                            <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                        </svg>
                        Anterior
                    </span>
                    @endif

                    <a href="{{ route('videos.index') }}" class="flex justify-center items-center text-center inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Tornar al llistat
                    </a>

                    @if($next)
                        <a href="{{ route('videos.show', $next->id) }}" class="flex justify-center items-center text-center inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Següent
                            <svg class="ml-2 h-5 w-5 text-gray-500" viewBox="0 0 24 24">
                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                            </svg>
                        </a>
                    @else
                        <span class="flex justify-center items-center text-center inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                        Següent
                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                        </svg>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
