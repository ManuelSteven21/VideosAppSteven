@extends('layouts.VideosAppLayout')

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">Editar Usuari: {{ $user->name }}</h1>

            <form action="{{ route('users.manage.update', $user->id) }}" method="POST" data-qa="user-edit-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" data-qa="name-label">Nom</label>
                    <input type="text" id="name" name="name" class="form-input"
                           value="{{ old('name', $user->name) }}" required data-qa="name-input">
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" data-qa="email-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                           value="{{ old('email', $user->email) }}" required data-qa="email-input">
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" data-qa="password-label">Contrasenya</label>
                    <input type="password" id="password" name="password"
                           class="form-input" data-qa="password-input" disabled>
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="checkbox-group">
                    <label class="checkbox-container">
                        <input type="checkbox" id="changePassword" name="changePassword"
                               data-qa="changePassword-checkbox">
                        <span class="checkmark"></span>
                        Canviar contrasenya
                    </label>
                </div>

                <div class="form-group">
                    <label for="role" data-qa="role-label">Rol</label>
                    <select id="role" name="role" class="form-select" required data-qa="role-select">
                        <option value="regular" {{ old('role', $user->role) == 'regular' ? 'selected' : '' }}
                        data-qa="role-option-regular">Usuari Regular</option>
                        <option value="video_manager" {{ old('role', $user->role) == 'video_manager' ? 'selected' : '' }}
                        data-qa="role-option-video_manager">Gestor de Vídeos</option>
                        <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}
                        data-qa="role-option-super_admin">Administrador</option>
                    </select>
                    @error('role')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="submit-button" data-qa="submit-button">Actualitzar Usuari</button>
                    <a href="{{ route('users.manage.index') }}" class="cancel-button" data-qa="cancel-button">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('changePassword').addEventListener('change', function() {
            const passwordField = document.getElementById('password');
            passwordField.disabled = !this.checked;
            if (!this.checked) passwordField.value = '';
        });
    </script>
@endsection
