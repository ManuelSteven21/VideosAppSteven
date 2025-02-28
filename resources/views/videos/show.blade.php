@extends('layouts.VideosAppLayout')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">{{ $video->title }}</h1>
        <p class="text-gray-600 text-lg mb-6">{{ $video->description }}</p>

        <div class="flex justify-center mb-6">
            <iframe
                src="{{ $video->url }}"
                class="rounded-lg shadow-lg border border-gray-300"
                width="560"
                height="315"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>
        </div>

        <div class="text-sm text-gray-500 mb-6">
            <p>
                <span class="font-medium text-gray-700">Publicado en:</span>
                <span class="text-gray-800">{{ $video->formatted_published_at }}</span>
                (<span class="text-gray-600">{{ $video->formatted_for_humans_published_at }}</span>)
            </p>
            <p>
                <span class="font-medium text-gray-700">ID de la serie:</span>
                <span class="text-gray-800">{{ $video->series_id }}</span>
            </p>
        </div>

        <div class="flex justify-between mt-6">
            @if($previous)
                <a href="{{ route('videos.show', $previous->id) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    ← Vídeo Anterior
                </a>
            @else
                <span class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded-lg cursor-not-allowed">
                ← Vídeo Anterior
            </span>
            @endif

            @if($next)
                <a href="{{ route('videos.show', $next->id) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Vídeo Siguiente →
                </a>
            @else
                <span class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded-lg cursor-not-allowed">
                Vídeo Siguiente →
            </span>
            @endif
        </div>
    </div>
@endsection
