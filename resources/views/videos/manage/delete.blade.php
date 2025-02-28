@extends('layouts.VideosAppLayout')

@section('content')
    <h1>Eliminar Vídeo</h1>

    @can('manage-videos')
        <p>Estàs segur que vols eliminar el vídeo: <strong>{{ $video->title }}</strong>?</p>

        <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
            <a href="{{ route('videos.manage.index') }}" class="btn btn-secondary">Cancel·lar</a>
        </form>
    @else
        <p>No tens permís per eliminar vídeos.</p>
    @endcan
@endsection
