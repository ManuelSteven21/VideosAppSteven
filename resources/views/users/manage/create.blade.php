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
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Crear Usuari</h1>

            <form action="{{ route('users.manage.store') }}" method="POST" class="space-y-6" data-qa="user-create-form">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contrasenya</label>
                    <input type="password" id="password" name="password" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select id="role" name="role" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        <option value="regular" {{ old('role') == 'regular' ? 'selected' : '' }}>Usuari Regular</option>
                        <option value="video_manager" {{ old('role') == 'video_manager' ? 'selected' : '' }}>Gestor de Vídeos</option>
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Administrador</option>
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
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
