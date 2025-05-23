@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8" data-qa="edit-series-form-container">
        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800" data-qa="edit-series-title">Editar Sèrie</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm" data-qa="form-error-box">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li data-qa="form-error">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('series.manage.update', $series->id) }}" method="POST" class="space-y-6" data-qa="edit-series-form">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Títol <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $series->title) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                           data-qa="input-title">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripció</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                              data-qa="input-description">{{ old('description', $series->description) }}</textarea>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">URL de la imatge</label>
                    <input type="url" name="image" id="image" value="{{ old('image', $series->image) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
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
                        Guardar Canvis
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
