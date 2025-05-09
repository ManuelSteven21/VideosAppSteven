@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Banner de la serie -->
        @if($series->image)
            <div class="w-full h-64 overflow-hidden">
                <img src="{{ $series->image }}"
                     alt="{{ $series->title }}"
                     class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Tarjeta de información de la serie -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Detalls de la Sèrie: {{ $series->title }}</h1>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('series.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Tornar
                    </a>

                    @auth
                        @can('update', $series)
                            <a href="{{ route('series.manage.edit', $series->id) }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                ✏️ Editar
                            </a>
                            <a href="{{ route('series.manage.delete', $series->id) }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm text-white bg-red-600 hover:bg-red-700">
                                🗑️ Eliminar
                            </a>
                        @endcan
                    @endauth
                </div>
            </div>

            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Columna izquierda -->
                    <div class="space-y-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-2">Descripció</h2>
                            <p class="text-gray-600">{{ $series->description }}</p>
                        </div>
                    </div>

                    <!-- Columna derecha -->
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-500">Creat per</span>
                                <div class="flex items-center">
                                    <img src="{{ $series->user_photo_url ?? asset('images/default-avatar.png') }}"
                                         alt="{{ $series->user_name }}"
                                         class="w-8 h-8 rounded-full mr-2">
                                    <span class="text-gray-900">{{ $series->user_name }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-medium text-gray-500">Creat el</span>
                                <span class="text-gray-900">{{ $series->formatted_created_at }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-medium text-gray-500">Actualitzat</span>
                                <span class="text-gray-900">{{ $series->updated_at->format('d/m/Y H:i') }}</span>
                            </div>

                            @if($series->published_at)
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-500">Publicat fa</span>
                                    <span class="text-gray-900">{{ $series->formatted_for_humans_created_at }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de vídeos (mantenido igual) -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    Vídeos de la Sèrie ({{ $series->videos->count() }})
                </h2>
            </div>

            @if($series->videos->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    @foreach($series->videos as $video)
                        <a href="{{ route('videos.show', $video->id) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <!-- Miniaturas -->
                            <div class="relative pb-[56.25%]">
                                @if($video->thumbnail && Storage::exists('public/'.$video->thumbnail))
                                    <img src="{{ asset('storage/' . $video->thumbnail) }}"
                                         alt="Miniatura de {{ $video->title }}"
                                         class="absolute h-full w-full object-cover">
                                @else
                                    <img src="https://img.youtube.com/vi/{{ $video->url_id }}/hqdefault.jpg"
                                         alt="Miniatura de {{ $video->title }}"
                                         class="absolute h-full w-full object-cover">
                                @endif
                            </div>

                            <!-- Detalles del vídeo -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $video->title }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $video->description }}</p>

                                <!-- Información del autor y fecha -->
                                <div class="flex items-center mt-3">
                                    <div>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $video->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM12 6c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                    <p class="mt-2 text-gray-600">Aquesta sèrie no té vídeos</p>
                </div>
            @endif
        </div>
    </div>
@endsection
