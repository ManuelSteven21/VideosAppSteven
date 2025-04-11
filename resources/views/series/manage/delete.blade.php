@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-md mx-auto px-4 py-8" data-qa="delete-series-container">
        <div class="bg-white rounded-lg shadow-md overflow-hidden" data-qa="delete-series-card">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4" data-qa="delete-series-title">Eliminar Sèrie</h1>

                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6" data-qa="delete-series-warning">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700" data-qa="delete-confirm-text">
                                Estàs segur que vols eliminar la sèrie:
                            </p>
                            <h3 class="text-lg font-medium text-red-800 mt-1" data-qa="series-title-to-delete">{{ $series->title }}</h3>
                        </div>
                    </div>
                </div>

                <form action="{{ route('series.manage.destroy', $series->id) }}" method="POST" class="space-y-4" data-qa="delete-series-form">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end space-x-3">
                        <a href="{{ url()->previous() }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                           data-qa="button-cancel-delete">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                            Cancel·lar
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                data-qa="button-confirm-delete">
                            <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                            </svg>
                            Sí, eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
