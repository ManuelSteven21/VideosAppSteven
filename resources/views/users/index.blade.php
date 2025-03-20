@extends('layouts.VideosAppLayout')

@section('content')
    <div class="management-container">
        <div class="management-header-container">
            <h1 class="management-header">Gestió d'Usuaris</h1>
        </div>

        <!-- Formulari de cerca -->
        <form action="{{ route('users.index') }}" method="GET" class="search-form" data-qa="user-search-form">
            <div class="search-group">
                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Cerca per nom o email..."
                    value="{{ request()->get('search') }}"
                    data-qa="search-input"
                >
                <button type="submit" class="search-button" data-qa="search-button">
                    <svg class="search-icon" viewBox="0 0 24 24">
                        <path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 001.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 00-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 005.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Taula d'usuaris -->
        <div class="table-container">
            <table class="management-table">
                <thead>
                <tr>
                    <th class="id-column">ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rols</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="id-column">{{ $user->id }}</td>
                        <td>
                            <a href="{{ route('users.show', $user->id) }}" class="user-link" data-qa="user-detail-link">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="role-list">
                                @foreach ($user->getRoleNames() as $role)
                                    <span class="role-item">{{ ucfirst($role) }}</span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
