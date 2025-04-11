@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8" data-qa="create-series-form-container">
        <h1 class="text-2xl font-bold text-gray-800 mb-6" data-qa="create-series-title">Crear Nova Sèrie</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded" data-qa="form-error-box">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li data-qa="form-error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('series.manage.store') }}" method="POST" class="space-y-6" data-qa="create-series-form">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Títol <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                       data-qa="input-title">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descripció</label>
                <textarea name="description" id="description" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                          data-qa="input-description">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">URL de la imatge</label>
                <input type="url" name="image" id="image" value="{{ old('image') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                       data-qa="input-image-url">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('series.manage.index') }}"
                   class="inline-flex items-center px-4 py-2 mr-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50"
                   data-qa="button-cancel">
                    Cancel·lar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700"
                        data-qa="button-submit">
                    Crear
                </button>
            </div>
        </form>
    </div>
@endsection
