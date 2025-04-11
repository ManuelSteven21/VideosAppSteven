@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Gestió de Sèries</h1>

            @can('manage-series')
                <a href="{{ route('series.manage.create') }}" class="flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Crear Sèrie
                </a>
            @endcan
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @can('manage-series')
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imatge</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Títol</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Autor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Publicació</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Accions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($series as $serie)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <img src="{{ $serie->image }}" alt="{{ $serie->title }}" class="w-20 h-12 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $serie->title }}</td>
                            <td class="px-6 py-4 flex items-center gap-2">
                                <img src="{{ $serie->user_photo_url ?? asset('images/default-avatar.png') }}" alt="{{ $serie->user_name }}" class="w-6 h-6 rounded-full">
                                <span class="text-sm text-gray-800">{{ $serie->user_name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $serie->formatted_published_at}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('series.manage.edit', $serie->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                                        <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <a href="{{ route('series.manage.delete', $serie->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md text-sm text-white bg-red-600 hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                        Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No hi ha cap sèrie disponible.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-600">No tens permís per gestionar sèries.</p>
            </div>
        @endcan
    </div>
@endsection
