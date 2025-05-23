@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" data-qa="series-page">
        <!-- Flash Message -->
        @if (session('success') || session('error'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                class="mb-6 px-4 py-3 rounded-md shadow-md text-sm font-medium max-w-xl mx-auto
                {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}"
            >
                {{ session('success') ?? session('error') }}
            </div>
        @endif

        <div class="flex flex-col space-y-6">
            <!-- Capçalera -->
            <div class="space-y-4">
                <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                    <h1 class="text-3xl font-bold text-gray-900" data-qa="page-title">Explora les nostres sèries</h1>

                    @can('create-series')
                        <a href="{{ route('series.manage.create') }}"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Nova sèrie
                        </a>
                    @endcan
                </div>

                <!-- Cercador -->
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
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1016.65 2a7.5 7.5 0 000 14.65z"/>
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Contingut o missatge -->
            @if ($series->count())
                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" data-qa="series-grid">
                    @foreach ($series as $serie)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden" data-qa="series-card">
                            <a href="{{ route('series.show', $serie->id) }}" class="block">
                                <div class="relative pb-[56.25%]">
                                    <img src="{{ $serie->image }}" alt="{{ $serie->title }}"
                                         class="absolute h-full w-full object-cover">
                                </div>

                                <div class="p-4">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $serie->title }}</h2>

                                    <div class="text-sm text-gray-600 mb-3">
                                        <div class="line-clamp-2" data-qa="series-description">
                                            {{ $serie->description }}
                                        </div>
                                        @if(strlen($serie->description) > 120)
                                            <button class="text-red-600 hover:text-red-800 text-sm font-medium mt-1 toggle-description">
                                                Veure més
                                            </button>
                                        @endif
                                    </div>

                                    <div class="flex items-center mt-3">
                                        <img src="{{ $serie->user_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($serie->user_name) }}"
                                             alt="{{ $serie->user_name }}"
                                             class="h-8 w-8 rounded-full mr-3">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $serie->user_name }}</p>
                                            <p class="text-xs text-gray-500 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
            @else
                <div class="bg-white text-center text-gray-600 rounded-md shadow-md p-6">
                    No hi ha cap sèrie disponible.
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-description').forEach(button => {
                button.addEventListener('click', function(e) {
                    const description = e.target.closest('div').querySelector('[data-qa="series-description"]');
                    const isExpanded = description.style.webkitLineClamp === 'unset';
                    description.style.webkitLineClamp = isExpanded ? '2' : 'unset';
                    e.target.textContent = isExpanded ? 'Veure més' : 'Veure menys';
                });
            });
        });
    </script>
@endpush
