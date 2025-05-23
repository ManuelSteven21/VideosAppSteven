@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-md mx-auto px-4 py-8">
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

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Capçalera -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Eliminar Usuari</h1>
            </div>

            <!-- Missatge d'advertència -->
            <div class="px-6 py-4">
                <div class="bg-yellow-50 border border-yellow-300 rounded-md p-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-yellow-500 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm text-yellow-800">
                                Esteu segur que voleu eliminar l’usuari:
                            </p>
                            <h3 class="text-lg font-semibold text-yellow-900 mt-1">{{ $user->name }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulari d'eliminació -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <form action="{{ route('users.manage.destroy', $user->id) }}" method="POST" class="flex flex-col sm:flex-row justify-end gap-3" data-qa="user-delete-form">
                    @csrf
                    @method('DELETE')

                    <a href="{{ route('users.manage.index') }}"
                       class="flex justify-center items-center gap-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition"
                       data-qa="cancel-button">
                        <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                        </svg>
                        Cancel·lar
                    </a>

                    <button type="submit"
                            class="flex justify-center items-center gap-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition"
                            data-qa="delete-button">
                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                        </svg>
                        Eliminar Usuari
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
