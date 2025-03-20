@extends('layouts.VideosAppLayout')

@section('content')
    <div class="user-details-container">
        <h1 class="user-details-title">Detalls de l'Usuari: {{ $user->name }}</h1>

        <!-- Taula d'informació de l'usuari -->
        <table class="user-info-table">
            <tr>
                <th>Nom</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Rols</th>
                <td>
                    <div class="role-list">
                        @foreach ($user->getRoleNames() as $role)
                            <span class="role-item">{{ ucfirst($role) }}</span>
                        @endforeach
                    </div>
                </td>
            </tr>
            <tr>
                <th>Super Admin</th>
                <td>{{ $user->super_admin ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <th>Creat el</th>
                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Última actualització</th>
                <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>

        <!-- Secció de vídeos de l'usuari -->
        @if($user->videos->isNotEmpty())
            <div class="user-videos-section">
                <h2 class="section-title">Vídeos de l'Usuari ({{ $user->videos->count() }})</h2>
                <div class="video-grid">
                    @foreach($user->videos as $video)
                        <div class="video-card">
                            <a href="{{ route('videos.show', $video->id) }}" class="video-link">
                                @if($video->thumbnail)
                                    <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Miniatura" class="video-thumbnail">
                                @else
                                    <div class="thumbnail-placeholder">
                                        <svg class="placeholder-icon" viewBox="0 0 24 24">
                                            <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="video-info">
                                    <h3 class="video-title">{{ $video->title }}</h3>
                                    <p class="video-description">{{ Str::limit($video->description, 100) }}</p>
                                    <div class="video-meta">
                                        <span class="meta-item">{{ $video->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="no-videos">
                <svg class="empty-icon" viewBox="0 0 24 24">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM12 6c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                </svg>
                <p>Aquest usuari no té vídeos publicats</p>
            </div>
        @endif

        <a href="{{ route('users.index') }}" class="return-button">
            <svg class="button-icon" viewBox="0 0 24 24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Tornar a la llista
        </a>
    </div>
@endsection
