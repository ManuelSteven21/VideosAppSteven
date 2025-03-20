@extends('layouts.VideosAppLayout')

@section('content')
    <div class="video-container">
        <h1 class="video-title">{{ $video->title }}</h1>
        <p class="video-description">{{ $video->description }}</p>

        <div class="video-iframe-container">
            <iframe
                src="{{ $video->url }}"
                class="video-iframe"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>
        </div>

        <div class="video-meta">
            <p class="meta-item">
                <span class="meta-label">Publicado en:</span>
                <span class="meta-value">{{ $video->formatted_published_at }}</span>
                (<span class="meta-time">{{ $video->formatted_for_humans_published_at }}</span>)
            </p>
            <p class="meta-item">
                <span class="meta-label">ID de la serie:</span>
                <span class="meta-value">{{ $video->series_id }}</span>
            </p>
        </div>

        <!-- Botons de navegació afegits -->
        <div class="video-navigation">
            @if($previous)
                <a href="{{ route('videos.show', $previous->id) }}" class="navigation-button prev">
                    <svg class="button-icon" viewBox="0 0 24 24">
                        <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                    </svg>
                    Anterior
                </a>
            @else
                <span class="navigation-button disabled">Anterior</span>
            @endif

            @if($next)
                <a href="{{ route('videos.show', $next->id) }}" class="navigation-button next">
                    Següent
                    <svg class="button-icon" viewBox="0 0 24 24">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
                </a>
            @else
                <span class="navigation-button disabled">Següent</span>
            @endif
        </div>
    </div>
@endsection
