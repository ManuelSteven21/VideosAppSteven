@extends('layouts.VideosAppLayout')

@section('content')
    <h1>Editar Vídeo</h1>

    @can('manage-videos')
        <form action="{{ route('videos.manage.update', $video->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="title">Títol:</label>
            <input type="text" id="title" name="title" value="{{ $video->title }}" required>

            <label for="description">Descripció:</label>
            <textarea id="description" name="description">{{ $video->description }}</textarea>

            <label for="url">URL del Vídeo:</label>
            <input type="url" id="url" name="url" value="{{ $video->url }}" required>

            <button type="submit" class="btn btn-warning">Guardar Canvis</button>
            <a href="{{ route('videos.manage.index') }}" class="btn btn-secondary">Cancel·lar</a>
        </form>
    @else
        <p>No tens permís per editar vídeos.</p>
    @endcan
@endsection
