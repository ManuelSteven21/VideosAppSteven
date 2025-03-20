@extends('layouts.VideosAppLayout')

@section('content')
    <h1 class="page-title">Explora Nuestro Catálogo</h1>

    <div class="video-grid">
        @foreach ($videos as $video)
            <div class="video-card hover:transform-hover">
                <a href="{{ route('videos.show', $video->id) }}" class="video-link">
                    <div class="thumbnail-container">
                        <img src="{{ $video->thumbnail_url ?? 'https://img.youtube.com/vi/'.$video->url_id.'/hqdefault.jpg' }}"
                             alt="{{ $video->title }}"
                             class="video-thumbnail">
                    </div>

                    <div class="video-info">
                        <h2 class="video-title">{{ $video->title }}</h2>

                        <div class="description-container">
                            <p class="video-description">
                                @if(strlen($video->description) > 120)
                                    <span class="short-description">{{ Str::limit($video->description, 120) }}</span>
                                    <span class="full-description hidden">{{ $video->description }}</span>
                                    <button class="toggle-description">Ver más</button>
                                @else
                                    {{ $video->description }}
                                @endif
                            </p>
                        </div>

                        @if($video->author)
                            <div class="author-info">
                                <img src="{{ $video->author->profile_photo_url }}"
                                     alt="{{ $video->author->name }}"
                                     class="author-avatar">
                                <div class="author-details">
                                    <p class="author-name">{{ $video->author->name }}</p>
                                    <p class="upload-time">
                                        <svg class="clock-icon" viewBox="0 0 24 24">
                                            <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path>
                                            <path d="M13 7h-2v6h6v-2h-4z"></path>
                                        </svg>
                                        {{ $video->published_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-description').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const container = e.target.closest('.description-container');
                container.querySelector('.short-description').classList.toggle('hidden');
                container.querySelector('.full-description').classList.toggle('hidden');
                e.target.textContent = container.querySelector('.full-description').classList.contains('hidden') ? 'Ver más' : 'Ver menos';
            });
        });
    </script>
@endpush
