@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8" data-qa="edit-series-form-container">
        <h1 class="text-2xl font-bold text-gray-800 mb-6" data-qa="edit-series-title">Editar Sèrie</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" data-qa="form-error-box">
                <ul class="list-disc list-inside">
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
                <label for="title" class="block text-sm font-medium text-gray-700">Títol</label>
                <input type="text" name="title" id="title" value="{{ old('title', $series->title) }}"
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

            <div class="flex justify-end">
                <a href="{{ route('series.manage.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 mr-2"
                   data-qa="button-cancel">
                    Cancel·lar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                        data-qa="button-submit">
                    Actualitzar
                </button>
            </div>
        </form>
    </div>
@endsection
