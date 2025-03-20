@extends('layouts.VideosAppLayout')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Crear Vídeo</h1>

            @can('manage-videos')
                <form action="{{ route('videos.manage.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="title">Títol:</label>
                        <input type="text" id="title" name="title" class="form-input" required
                               value="{{ old('title') }}" data-qa="video-title">
                        @error('title')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Descripció:</label>
                        <textarea id="description" name="description" class="form-input form-textarea"
                                  data-qa="video-description">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="url">URL del Vídeo:</label>
                        <input type="url" id="url" name="url" class="form-input" required
                               value="{{ old('url') }}" data-qa="video-url">
                        @error('url')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="button-group">
                        <button type="submit" class="submit-button" data-qa="submit-video">Crear</button>
                        <a href="{{ route('videos.manage.index') }}" class="cancel-button" data-qa="cancel-button">Cancelar</a>
                    </div>
                </form>
            @else
                <p class="permission-warning">No tens permís per afegir vídeos.</p>
            @endcan
        </div>
    </div>
@endsection
