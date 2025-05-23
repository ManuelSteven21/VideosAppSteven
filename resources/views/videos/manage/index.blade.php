@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- Flash Message --}}
        @if (session('success') || session('error'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                class="mb-6 px-4 py-3 rounded-md shadow
                    {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}"
            >
                <p class="text-sm font-medium">
                    {{ session('success') ?? session('error') }}
                </p>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Gestió de Vídeos</h1>

            @can('manage-videos')
                <a href="{{ route('videos.manage.create') }}"
                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <span class="flex items-center">
                        <svg class="h-5 w-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="hidden sm:inline">Nou vídeo</span>
                    </span>
                </a>
            @endcan
        </div>

    @can('manage-videos')
            @if($videos->count())
                {{-- Vista mòbil: Cards --}}
                <div class="sm:hidden p-4 space-y-4">
                    @foreach ($videos as $video)
                        <div class="bg-gray-50 rounded-md shadow-md p-4">
                            <div class="mb-2">
                                <p class="text-xs text-gray-500">#{{ $video->id }}</p>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">{{ $video->title }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $video->description }}</p>
                            </div>

                            <div class="flex justify-end gap-2">
                                <a href="{{ route('videos.manage.edit', $video->id) }}"
                                   class="inline-flex items-center justify-center p-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                   title="Editar">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('videos.manage.delete', $video->id) }}"
                                   class="inline-flex items-center justify-center p-2 border border-transparent rounded-md text-white bg-red-600 hover:bg-red-700"
                                   title="Eliminar">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Vista desktop: Taula --}}
                <div class="hidden sm:block bg-white rounded-lg shadow-md overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Títol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripció</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Accions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($videos as $video)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $video->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $video->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ Str::limit($video->description, 100) }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('videos.manage.edit', $video->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span>Editar</span>
                                        </a>
                                        <a href="{{ route('videos.manage.delete', $video->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1 border border-transparent rounded-md text-sm text-white bg-red-600 hover:bg-red-700">
                                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                            </svg>
                                            <span>Eliminar</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-600">
                    No hi ha cap vídeo creat.
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-600">
                No tens permís per gestionar vídeos.
            </div>
        @endcan
    </div>
@endsection
