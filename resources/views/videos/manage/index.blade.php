@extends('layouts.VideosAppLayout')

@section('content')
    <div class="management-container">
        <div class="management-header-container">
            <h1 class="management-header">Gestió de Vídeos</h1>

            @can('manage-videos')
                <a href="{{ route('videos.manage.create') }}" class="action-button create-button">
                    <svg class="icon" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Crear Vídeo
                </a>
            @endcan
        </div>

        @can('manage-videos')
            <div class="table-container">
                <table class="management-table">
                    <thead>
                    <tr>
                        <th class="id-column">ID</th>
                        <th>Títol</th>
                        <th class="actions-column">Accions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($videos as $video)
                        <tr>
                            <td class="id-column">{{ $video->id }}</td>
                            <td>{{ $video->title }}</td>
                            <td class="actions-cell">
                                <div class="button-group">
                                    <a href="{{ route('videos.manage.edit', $video->id) }}" class="action-button edit-button">
                                        <svg class="icon" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        Editar
                                    </a>
                                    <a href="{{ route('videos.manage.delete', $video->id) }}" class="action-button delete-button">
                                        <svg class="icon" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="permission-warning">No tens permís per gestionar vídeos.</p>
        @endcan
    </div>
@endsection
