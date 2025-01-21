<x-videos-app-layout title="Video: {{ $video->title }}">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">{{ $video->title }}</h1>
        <p class="text-gray-600 text-lg mb-6">{{ $video->description }}</p>

        <div class="flex justify-center mb-6">
            <iframe
                src="{{ $video->url }}"
                class="rounded-lg shadow-lg border border-gray-300"
                width="560"
                height="315"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>
        </div>

        <div class="text-sm text-gray-500">
            <p>Published on: <span class="text-gray-700">{{ $video->formatted_published_at }}</span></p>
            <p>Series ID: <span class="text-gray-700">{{ $video->series_id }}</span></p>
        </div>
    </div>
</x-videos-app-layout>
