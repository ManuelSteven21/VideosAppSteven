@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Tarjeta de información del usuario -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Detalls de l'Usuari: {{ $user->name }}</h1>
                <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                    Tornar
                </a>
            </div>

            <div class="px-6 py-4">
                <div class="flex items-start space-x-6">
                    <img src="{{ $user->profile_photo_url ?? asset('images/default-avatar.png') }}"
                         alt="{{ $user->name }}"
                         class="w-24 h-24 rounded-full object-cover border-2 border-gray-200">

                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-500">Nom</span>
                                <span class="text-gray-900">{{ $user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-500">Email</span>
                                <span class="text-gray-900">{{ $user->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-500">Super Admin</span>
                                <span class="text-gray-900">{{ $user->super_admin ? 'Sí' : 'No' }}</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-500">Rols</span>
                                <div class="flex flex-wrap gap-1 justify-end">
                                    @foreach ($user->getRoleNames() as $role)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($role) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-500">Creat el</span>
                                <span class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-500">Actualitzat</span>
                                <span class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de vídeos con estilo grid como en el index -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Vídeos de l'Usuari ({{ $user->videos->count() }})</h2>
            </div>

            @if($user->videos->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    @foreach($user->videos as $video)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <a href="{{ route('videos.show', $video->id) }}" class="block">
                                <!-- Miniaturas -->
                                <div class="relative pb-[56.25%]">
                                    @if($video->thumbnail && Storage::exists('public/'.$video->thumbnail))
                                        <img src="{{ asset('storage/' . $video->thumbnail) }}"
                                             alt="Miniatura de {{ $video->title }}"
                                             class="absolute h-full w-full object-cover">
                                    @else
                                        <!-- Mostrar el iframe directamente si no hay miniatura -->
                                        <iframe
                                            src="https://www.youtube.com/embed/{{ $video->url_id }}?autoplay=0&showinfo=0&controls=0"
                                            class="absolute h-full w-full"
                                            frameborder="0"
                                            allowfullscreen>
                                        </iframe>
                                    @endif
                                </div>
                                <!-- Detalles del vídeo -->
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $video->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $video->description }}</p>

                                    <!-- Información del autor -->
                                    <div class="flex items-center mt-3">
                                        <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                                             alt="{{ $user->name }}"
                                             class="h-8 w-8 rounded-full mr-3">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $video->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM12 6c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                    <p class="mt-2 text-gray-600">Aquest usuari no té vídeos publicats</p>
                </div>
            @endif
        </div>
    </div>
@endsection
