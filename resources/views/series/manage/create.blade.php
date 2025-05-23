@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8" data-qa="create-series-form-container">
        {{-- Flash messages --}}
        @if (session('success') || session('error'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                class="mb-6 px-4 py-3 rounded-md shadow-md text-sm font-medium max-w-xl mx-auto
                    {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}"
            >
                {{ session('success') ?? session('error') }}
            </div>
        @endif

        {{-- Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded border border-red-300 shadow-sm" data-qa="form-error-box">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li data-qa="form-error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800" data-qa="create-series-title">Crear Nova Sèrie</h1>

            <form action="{{ route('series.manage.store') }}" method="POST" class="space-y-6" data-qa="create-series-form">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Títol <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                           data-qa="input-title">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripció</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                              data-qa="input-description">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">URL de la imatge</label>
                    <input type="url" name="image" id="image" value="{{ old('image') }}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                           data-qa="input-image-url">
                </div>

                <div class="flex flex-col md:flex-row justify-end md:space-x-3 space-y-2 md:space-y-0 pt-4">
                    <a href="{{ url()->previous() }}"
                       class="w-full md:w-auto text-center md:text-left px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-red-500"
                       data-qa="cancel-button">
                        Cancel·lar
                    </a>
                    <button type="submit"
                            class="w-full md:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-red-500"
                            data-qa="submit-series">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
