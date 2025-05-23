@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">Gestió de Sèries</h1>

            @can('manage-series')
                <a href="{{ route('series.manage.create') }}" class="flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 text-sm font-medium">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Crear Sèrie
                </a>
            @endcan
        </div>

        @if(session('success') || session('error'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                class="mb-4 px-4 py-3 rounded-md shadow-md max-w-xl mx-auto
                    {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}"
            >
                <p class="text-sm font-medium">
                    {{ session('success') ?? session('error') }}
                </p>
            </div>
        @endif

        @can('manage-series')

            <!-- Vista mòbil -->
            <div class="md:hidden space-y-4 p-4">
                @forelse($series as $serie)
                    <div class="bg-gray-50 rounded-md shadow p-4 space-y-2">
                        <div class="flex items-center gap-3">
                            <img src="{{ $serie->image }}" alt="{{ $serie->title }}" class="w-20 h-12 object-cover rounded">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $serie->title }}</p>
                                <p class="text-xs text-gray-600">{{ $serie->formatted_published_at }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <img src="{{ $serie->user_photo_url ?? asset('images/default-avatar.png') }}" alt="{{ $serie->user_name }}" class="w-6 h-6 rounded-full">
                            <p class="text-sm text-gray-700">{{ $serie->user_name }}</p>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('series.manage.edit', $serie->id) }}"
                               class="inline-flex items-center justify-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span>Editar</span>
                            </a>
                            <a href="{{ route('series.manage.delete', $serie->id) }}"
                               class="inline-flex items-center justify-center gap-1 px-3 py-1 border border-transparent rounded-md text-sm text-white bg-red-600 hover:bg-red-700">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                </svg>
                                <span>Eliminar</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 italic">No hi ha cap sèrie disponible.</p>
                @endforelse
            </div>

            <!-- Vista escriptori -->
            <div class="hidden md:block bg-white rounded-lg shadow-md overflow-x-auto">
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
                                {{ $serie->formatted_published_at }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('series.manage.edit', $serie->id) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <a href="{{ route('series.manage.delete', $serie->id) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 border border-transparent rounded-md text-sm text-white bg-red-600 hover:bg-red-700">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
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
