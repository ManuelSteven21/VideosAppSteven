@extends('layouts.VideosAppLayout')

@section('content')
    <h1>Gestió de Vídeos</h1>

    @can('manage-videos')
        <a href="{{ route('videos.manage.create') }}" class="btn btn-primary">Crear Vídeo</a>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Títol</th>
                <th>Accions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($videos as $video)
                <tr>
                    <td>{{ $video->id }}</td>
                    <td>{{ $video->title }}</td>
                    <td>
                        <a href="{{ route('videos.manage.edit', $video->id) }}" class="btn btn-warning">Editar</a>
                        <a href="{{ route('videos.manage.delete', $video->id) }}" class="btn btn-danger">Eliminar</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No tens permís per gestionar vídeos.</p>
    @endcan
@endsection
