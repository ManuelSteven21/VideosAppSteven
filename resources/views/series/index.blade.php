@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" data-qa="series-page">
        <div class="flex flex-col space-y-6">
            <!-- Título y Buscador -->
            <div class="space-y-4">
                <h1 class="text-3xl font-bold text-gray-900" data-qa="page-title">Explora les nostres sèries</h1>

                <!-- Cercador - Icono mejor posicionado -->
                <form action="{{ route('series.index') }}" method="GET" class="w-full max-w-2xl" data-qa="series-search-form">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request()->get('search') }}"
                            placeholder="Cerca per títol o descripció..."
                            class="w-full px-4 py-3 pl-12 text-sm border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition duration-200"
                            data-qa="search-input"
                        >
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" data-qa="search-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1016.65 2a7.5 7.5 0 000 14.65z"/>
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Grid de series -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" data-qa="series-grid">
                @foreach ($series as $serie)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300" data-qa="series-card">
                        <a href="{{ route('series.show', $serie->id) }}" class="block" data-qa="series-link">
                            <div class="relative pb-[56.25%]" data-qa="series-image-container">
                                <img src="{{ $serie->image }}"
                                     alt="{{ $serie->title }}"
                                     class="absolute h-full w-full object-cover"
                                     data-qa="series-image">
                            </div>

                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2" data-qa="series-title">{{ $serie->title }}</h2>

                                <div class="text-sm text-gray-600 mb-3" data-qa="series-description-container">
                                    <div class="line-clamp-2" data-qa="series-description">
                                        {{ $serie->description }}
                                    </div>
                                    @if(strlen($serie->description) > 120)
                                        <button class="text-red-600 hover:text-red-800 text-sm font-medium mt-1 toggle-description" data-qa="show-more-button">
                                            Veure més
                                        </button>
                                    @endif
                                </div>

                                <div class="flex items-center mt-3" data-qa="series-author-info">
                                    <img src="{{ $serie->user_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($serie->user_name) }}"
                                         alt="{{ $serie->user_name }}"
                                         class="h-8 w-8 rounded-full mr-3"
                                         data-qa="author-avatar">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900" data-qa="author-name">{{ $serie->user_name }}</p>
                                        <p class="text-xs text-gray-500 flex items-center" data-qa="series-publish-date">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" data-qa="time-icon">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $serie->formatted_for_humans_created_at ?? 'No publicada' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-qa="show-more-button"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const container = e.target.closest('[data-qa="series-description-container"]');
                    const description = container.querySelector('[data-qa="series-description"]');

                    if(description.style.webkitLineClamp === '2') {
                        description.style.webkitLineClamp = 'unset';
                        e.target.textContent = 'Veure menys';
                        e.target.setAttribute('data-qa-state', 'expanded');
                    } else {
                        description.style.webkitLineClamp = '2';
                        e.target.textContent = 'Veure més';
                        e.target.setAttribute('data-qa-state', 'collapsed');
                    }
                });
            });
        });
    </script>
@endpush
