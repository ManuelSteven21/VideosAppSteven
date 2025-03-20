@extends('layouts.VideosAppLayout')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar Vídeo</h1>

            @can('manage-videos')
                <form action="{{ route('videos.manage.update', $video->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Títol:</label>
                        <input type="text" id="title" name="title"
                               class="form-input" value="{{ $video->title }}" required>
                        @error('title')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Descripció:</label>
                        <textarea id="description" name="description"
                                  class="form-input form-textarea">{{ $video->description }}</textarea>
                        @error('description')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="url">URL del Vídeo:</label>
                        <input type="url" id="url" name="url"
                               class="form-input" value="{{ $video->url }}" required>
                        @error('url')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="button-group">
                        <button type="submit" class="submit-button">Guardar Canvis</button>
                        <a href="{{ route('videos.manage.index') }}" class="cancel-button">Cancel·lar</a>
                    </div>
                </form>
            @else
                <p class="permission-warning">No tens permís per editar vídeos.</p>
            @endcan
        </div>
    </div>
@endsection
