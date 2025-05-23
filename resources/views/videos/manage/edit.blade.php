@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        {{-- Flash Message --}}
        @if (session('success') || session('error'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                class="mb-6 px-4 py-3 rounded-md shadow-md
                    {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}"
            >
                <p class="text-sm font-medium">
                    {{ session('success') ?? session('error') }}
                </p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Vídeo</h1>

            <form action="{{ route('videos.manage.update', $video->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Títol --}}
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Títol:</label>
                    <input type="text" id="title" name="title"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                           required value="{{ old('title', $video->title) }}" data-qa="video-title">
                    @error('title')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripció --}}
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripció:</label>
                    <textarea id="description" name="description" rows="4"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                              data-qa="video-description">{{ old('description', $video->description) }}</textarea>
                    @error('description')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL --}}
                <div class="space-y-2">
                    <label for="url" class="block text-sm font-medium text-gray-700">URL del Vídeo:</label>
                    <input type="url" id="url" name="url"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                           required value="{{ old('url', $video->url) }}" data-qa="video-url">
                    @error('url')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sèrie --}}
                <div class="space-y-2">
                    <label for="series_id" class="block text-sm font-medium text-gray-700">Sèrie (opcional):</label>
                    <select id="series_id" name="series_id"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                            data-qa="video-series-select">
                        <option value="">-- Sense sèrie --</option>
                        @forelse($series as $serie)
                            <option value="{{ $serie->id }}" {{ old('series_id', $video->series_id) == $serie->id ? 'selected' : '' }}>
                                {{ $serie->title }}
                            </option>
                        @empty
                            <option disabled>No hi ha sèries disponibles</option>
                        @endforelse
                    </select>
                    @error('series_id')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botons --}}
                <div class="flex flex-col md:flex-row justify-end md:space-x-3 space-y-2 md:space-y-0 pt-4">
                    <a href="{{ url()->previous() }}"
                       class="w-full md:w-auto text-center md:text-left px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-red-500"
                       data-qa="cancel-button">
                        Cancel·lar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-red-500"
                            data-qa="submit-video">
                        Guardar Canvis
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
