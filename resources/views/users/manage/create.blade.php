@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-md mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Crear Usuari</h1>
            </div>

            <div class="p-6">
                <form action="{{ route('users.manage.store') }}" method="POST" class="space-y-6" data-qa="user-create-form">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700" data-qa="name-label">Nom</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                               data-qa="name-input">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700" data-qa="email-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                               data-qa="email-input">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700" data-qa="password-label">Contrasenya</label>
                        <input type="password" id="password" name="password" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                               data-qa="password-input">
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700" data-qa="role-label">Rol</label>
                        <select id="role" name="role" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 rounded-md shadow-sm"
                                data-qa="role-select">
                            <option value="regular" {{ old('role') == 'regular' ? 'selected' : '' }} data-qa="role-option-regular">Usuari Regular</option>
                            <option value="video_manager" {{ old('role') == 'video_manager' ? 'selected' : '' }} data-qa="role-option-video_manager">Gestor de Vídeos</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }} data-qa="role-option-super_admin">Administrador</option>
                        </select>
                        @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('users.manage.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                           data-qa="cancel-button">
                            Cancel·lar
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                data-qa="submit-button">
                            Crear Usuari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
