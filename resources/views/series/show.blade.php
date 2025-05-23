@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Imatge de portada -->
        @if($series->image)
            <div class="w-full h-64 overflow-hidden rounded-lg shadow mb-6">
                <img src="{{ $series->image }}" alt="{{ $series->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Informació principal -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between md:items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Detalls de la Sèrie: {{ $series->title }}</h1>

                <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    <a href="{{ route('series.index') }}"
                       class="w-full md:w-auto text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-red-500">
                        <svg class="h-5 w-5 inline mr-2 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Tornar
                    </a>

                    @can('update', $series)
                        <a href="{{ route('series.manage.edit', $series->id) }}"
                           class="w-full md:w-auto text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-red-500">
                            ✏️ Editar
                        </a>
                        <a href="{{ route('series.manage.delete', $series->id) }}"
                           class="w-full md:w-auto text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-red-500">
                            🗑️ Eliminar
                        </a>
                    @endcan
                </div>
            </div>

            <div class="px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Descripció -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Descripció</h2>
                    <p class="text-gray-600 whitespace-pre-line">{{ $series->description ?: 'Aquesta sèrie no té descripció.' }}</p>
                </div>

                <!-- Detalls -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="text-gray-500 font-medium">Creat per:</span>
                        <div class="flex items-center gap-2">
                            <img src="{{ $series->user_photo_url ?? asset('images/default-avatar.png') }}" alt="{{ $series->user_name }}" class="w-8 h-8 rounded-full">
                            <span class="text-gray-900">{{ $series->user_name }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Creat el:</span>
                        <span>{{ $series->formatted_created_at }}</span>
                    </div>

                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Actualitzat:</span>
                        <span>{{ $series->updated_at->format('d/m/Y H:i') }}</span>
                    </div>

                    @if($series->published_at)
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Publicat fa:</span>
                            <span>{{ $series->formatted_for_humans_created_at }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Llista de vídeos -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Vídeos de la Sèrie ({{ $series->videos->count() }})</h2>
            </div>

            @if($series->videos->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    @foreach($series->videos as $video)
                        <a href="{{ route('videos.show', $video->id) }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 overflow-hidden block">
                            <div class="relative pb-[56.25%]">
                                <img src="{{ $video->thumbnail && Storage::exists('public/'.$video->thumbnail) ? asset('storage/' . $video->thumbnail) : 'https://img.youtube.com/vi/'.$video->url_id.'/hqdefault.jpg' }}"
                                     alt="Miniatura de {{ $video->title }}"
                                     class="absolute h-full w-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $video->title }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $video->description }}</p>
                                <p class="mt-2 text-xs text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $video->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM12 6c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                    <p class="mt-3 text-gray-600">Aquesta sèrie no té cap vídeo.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
