@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Explora el nostre catàleg</h1>
            @can('create-videos')
                <a href="{{ route('videos.manage.create') }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nou vídeo
                </a>
            @endcan
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($videos as $video)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('videos.show', $video->id) }}" class="block">
                        <div class="relative pb-[56.25%]"> <!-- 16:9 aspect ratio -->
                            <img src="{{ $video->thumbnail_url ?? 'https://img.youtube.com/vi/'.$video->url_id.'/hqdefault.jpg' }}"
                                 alt="{{ $video->title }}"
                                 class="absolute h-full w-full object-cover">
                        </div>

                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $video->title }}</h2>

                            <div class="text-sm text-gray-600 mb-3">
                                <div class="line-clamp-2">
                                    {{ $video->description }}
                                </div>
                                @if(strlen($video->description) > 120)
                                    <button class="text-red-600 hover:text-red-800 text-sm font-medium mt-1 toggle-description">
                                        Veure més
                                    </button>
                                @endif
                            </div>

                            @if($video->author)
                                <div class="flex items-center">
                                    <img src="{{ $video->author->profile_photo_url }}"
                                         alt="{{ $video->author->name }}"
                                         class="h-8 w-8 rounded-full mr-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $video->author->name }}</p>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $video->formatted_for_humans_published_at ?? 'No publicada' }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Asegurar que el botón esté por encima de otros elementos */
        .z-50 {
            z-index: 50;
        }
        /* Animación suave para el hover */
        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-description').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const container = e.target.closest('div');
                    const description = container.querySelector('.line-clamp-2');

                    if(description.style.webkitLineClamp === '2') {
                        description.style.webkitLineClamp = 'unset';
                        e.target.textContent = 'Veure menys';
                    } else {
                        description.style.webkitLineClamp = '2';
                        e.target.textContent = 'Veure més';
                    }
                });
            });
        });
    </script>
@endpush
