@extends('layouts.VideosAppLayout')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-800 mb-4">Vídeos Disponibles</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($videos as $video)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <a href="{{ route('videos.show', $video->id) }}" class="block relative">
                    <!-- Miniatura del vídeo -->
                    <img src="{{ $video->thumbnail_url ?? 'https://img.youtube.com/vi/' . $video->url_id . '/hqdefault.jpg' }}" alt="{{ $video->title }}" class="w-full h-48 object-cover">

                    <!-- Título del vídeo -->
                    <div class="p-4">
                        <a href="{{ route('videos.show', $video->id) }}" class="text-lg font-semibold text-gray-800 hover:underline">
                            {{ $video->title }}
                        </a>
                        <p class="text-gray-600 mt-2">{{ Str::limit($video->description, 100) }}</p>
                        @if($video->author)
                            <div class="mt-4 flex items-center">
                                <img src="{{ $video->author->profile_photo_url }}" alt="{{ $video->author->name }}" class="w-8 h-8 rounded-full">
                                <div class="ml-2 text-sm">
                                    <p class="text-gray-700">{{ $video->author->name }}</p>
                                    <p class="text-gray-500">{{ $video->published_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
