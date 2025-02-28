@extends('layouts.VideosAppLayout')

@section('content')
    <h1>Crear Vídeo</h1>

    @can('manage-videos')
        <form action="{{ route('videos.manage.store') }}" method="POST">
            @csrf

            <label for="title">Títol:</label>
            <input type="text" id="title" name="title" required value="{{ old('title') }}" data-qa="video-title">
            @error('title')
            <div class="text-danger">{{ $message }}</div>
            @enderror

            <label for="description">Descripció:</label>
            <textarea id="description" name="description" data-qa="video-description">{{ old('description') }}</textarea>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror

            <label for="url">URL del Vídeo:</label>
            <input type="url" id="url" name="url" required value="{{ old('url') }}" data-qa="video-url">
            @error('url')
            <div class="text-danger">{{ $message }}</div>
            @enderror

            <div class="mt-4">
                <button type="submit" class="btn btn-success" data-qa="submit-video">Crear</button>
                <a href="{{ route('videos.manage.index') }}" class="btn btn-secondary" data-qa="cancel-button">Cancelar</a>
            </div>
        </form>
    @else
        <p>No tens permís per afegir vídeos.</p>
    @endcan
@endsection
