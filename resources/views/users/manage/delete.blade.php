@extends('layouts.VideosAppLayout')

@section('content')
    <div class="confirmation-container">
        <div class="confirmation-card">
            <h1 class="confirmation-title">Eliminar Usuari</h1>

            <div class="warning-alert">
                <svg class="warning-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <div class="warning-content">
                    <div class="warning-text">Esteu segur que voleu eliminar l'usuari:</div>
                    <div class="user-title">{{ $user->name }}</div>
                </div>
            </div>

            <form action="{{ route('users.manage.destroy', $user->id) }}" method="POST" data-qa="user-delete-form">
                @csrf
                @method('DELETE')

                <div class="button-group">
                    <button type="submit" class="danger-button" data-qa="delete-button">
                        <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                        </svg>
                        Eliminar Usuari
                    </button>

                    <a href="{{ route('users.manage.index') }}" class="cancel-button" data-qa="cancel-button">
                        <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                        </svg>
                        Cancel·lar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
