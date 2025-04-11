@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Crear Vídeo</h1>

            <form action="{{ route('videos.manage.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo: Títol -->
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Títol:</label>
                    <input type="text" id="title" name="title" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" required value="{{ old('title') }}" data-qa="video-title">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Descripció -->
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripció:</label>
                    <textarea id="description" name="description" rows="4" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" data-qa="video-description">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: URL del Vídeo -->
                <div class="space-y-2">
                    <label for="url" class="block text-sm font-medium text-gray-700">URL del Vídeo:</label>
                    <input type="url" id="url" name="url" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" required value="{{ old('url') }}" data-qa="video-url">
                    @error('url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Selección de Sèrie (opcional) -->
                <div class="space-y-2">
                    <label for="series_id" class="block text-sm font-medium text-gray-700">Sèrie (opcional):</label>
                    <select id="series_id" name="series_id" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" data-qa="video-series-select">
                        <option value="">-- Sense sèrie --</option>
                        @foreach($series as $serie)
                            <option value="{{ $serie->id }}" @if(old('series_id') == $serie->id) selected @endif>{{ $serie->title }}</option>
                        @endforeach
                    </select>
                    @error('series_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ url()->previous() }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" data-qa="cancel-button">
                        Cancel·lar
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" data-qa="submit-video">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
