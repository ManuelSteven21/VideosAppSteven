@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        {{-- Flash messages --}}
        @if (session('success') || session('error'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                class="mb-6 px-4 py-3 rounded-md shadow-md text-sm font-medium
                    {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}"
            >
                {{ session('success') ?? session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Editar Usuari: {{ $user->name }}</h1>

            <form action="{{ route('users.manage.update', $user->id) }}" method="POST" class="space-y-6" data-qa="user-edit-form">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ showPassword: false }">
                    <button type="button"
                            @click="showPassword = !showPassword"
                            class="flex items-center text-sm font-medium text-red-600 hover:text-red-800">
                        <svg x-show="!showPassword" class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <svg x-show="showPassword" class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                        <span x-text="showPassword ? 'Amagar camp' : 'Restablir contrasenya'"></span>
                    </button>

                    <div x-show="showPassword" class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Nova Contrasenya</label>
                        <input type="password" id="password" name="password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select id="role" name="role" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        @php
                            $currentRole = old('role', $user->getRoleNames()->first() ?? 'regular');
                        @endphp
                        <option value="regular" {{ $currentRole === 'regular' ? 'selected' : '' }}>Usuari Regular</option>
                        <option value="video_manager" {{ $currentRole === 'video_manager' ? 'selected' : '' }}>Gestor de Vídeos</option>
                        <option value="super_admin" {{ $currentRole === 'super_admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('role')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col md:flex-row justify-end md:space-x-3 space-y-2 md:space-y-0 pt-4">
                    <a href="{{ route('users.manage.index') }}"
                       class="w-full md:w-auto text-center md:text-left px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-red-500">
                        Cancel·lar
                    </a>
                    <button type="submit"
                            class="w-full md:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-red-500">
                        Actualitzar Usuari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordField() {
            const passwordField = document.getElementById('passwordField');
            const passwordIcon = document.getElementById('passwordIcon');
            const passwordText = document.getElementById('passwordText');

            if (passwordField.style.display === 'none') {
                // Mostrar campo
                passwordField.style.display = 'block';
                passwordIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
                passwordText.textContent = 'Amagar camp';
                document.getElementById('password').focus();
            } else {
                // Ocultar campo
                passwordField.style.display = 'none';
                passwordIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>`;
                passwordText.textContent = 'Restablir contrasenya';
                document.getElementById('password').value = '';
            }
        }
    </script>
@endsection
