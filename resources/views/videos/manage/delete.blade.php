@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-md mx-auto px-4 py-8">
        {{-- Flash Message --}}
        @if (session('success') || session('error'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                class="mb-6 px-4 py-3 rounded-md shadow-md
                    {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}"
            >
                <p class="text-sm font-medium">
                    {{ session('success') ?? session('error') }}
                </p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 space-y-6">
                <h1 class="text-2xl font-bold text-gray-800">Eliminar Vídeo</h1>

                <div class="bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                Estàs segur que vols eliminar el vídeo següent?
                            </p>
                            <h3 class="text-lg font-medium text-red-800 mt-1">{{ $video->title }}</h3>
                        </div>
                    </div>
                </div>

                <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <div class="flex flex-col md:flex-row justify-end md:space-x-3 space-y-2 md:space-y-0 pt-4">
                        <a href="{{ url()->previous() }}"
                           class="w-full md:w-auto text-center md:text-left inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                            Cancel·lar
                        </a>
                        <button type="submit"
                                class="w-full md:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-red-500">
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
