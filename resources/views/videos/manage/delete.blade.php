@extends('layouts.VideosAppLayout')

@section('content')
    <div class="confirmation-container">
        <div class="confirmation-card">
            <h1 class="confirmation-title">Eliminar Vídeo</h1>

            @can('manage-videos')
                <div class="confirmation-content">
                    <div class="warning-alert">
                        <svg class="warning-icon" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        <div class="warning-content">
                            <p class="warning-text">Estàs segur que vols eliminar el vídeo:</p>
                            <h3 class="video-title">{{ $video->title }}</h3>
                        </div>
                    </div>

                    <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" class="confirmation-form">
                        @csrf
                        @method('DELETE')
                        <div class="button-group">
                            <button type="submit" class="danger-button">
                                <svg class="button-icon" viewBox="0 0 24 24">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                </svg>
                                Sí, eliminar
                            </button>
                            <a href="{{ route('videos.manage.index') }}" class="cancel-button">
                                <svg class="button-icon" viewBox="0 0 24 24">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                </svg>
                                Cancel·lar
                            </a>
                        </div>
                    </form>
                </div>
            @else
                <div class="permission-warning">
                    <svg class="warning-icon" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h2v2h-2zm0-16h2v6h-2z"/>
                    </svg>
                    <p>No tens permís per eliminar vídeos.</p>
                </div>
            @endcan
        </div>
    </div>
@endsection
