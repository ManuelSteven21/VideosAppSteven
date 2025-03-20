@extends('layouts.VideosAppLayout')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Crear Usuari</h1>

            <form action="{{ route('users.manage.store') }}" method="POST" data-qa="user-create-form">
                @csrf

                <div class="form-group">
                    <label for="name" data-qa="name-label">Nom</label>
                    <input type="text" id="name" name="name" class="form-input"
                           value="{{ old('name') }}" required data-qa="name-input">
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" data-qa="email-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                           value="{{ old('email') }}" required data-qa="email-input">
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" data-qa="password-label">Contrasenya</label>
                    <input type="password" id="password" name="password"
                           class="form-input" required data-qa="password-input">
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role" data-qa="role-label">Rol</label>
                    <select id="role" name="role" class="form-select" required data-qa="role-select">
                        <option value="regular" {{ old('role') == 'regular' ? 'selected' : '' }}
                        data-qa="role-option-regular">Usuari Regular</option>
                        <option value="video_manager" {{ old('role') == 'video_manager' ? 'selected' : '' }}
                        data-qa="role-option-video_manager">Gestor de Vídeos</option>
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}
                        data-qa="role-option-super_admin">Administrador</option>
                    </select>
                    @error('role')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="submit-button" data-qa="submit-button">Crear Usuari</button>
                    <a href="{{ route('users.manage.index') }}" class="cancel-button" data-qa="cancel-button">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
