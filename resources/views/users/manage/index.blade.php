@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Capçalera -->
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between md:items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Gestió d'Usuaris</h1>

                @if(auth()->user()->can('manage-users'))
                    <a href="{{ route('users.manage.create') }}" class="inline-flex items-center justify-center gap-2 px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Crear Usuari</span>
                    </a>
                @endif
            </div>

            <!-- Missatge d'èxit o error -->
            @if(session('success') || session('error'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 4000)"
                    class="mx-6 mt-4 px-4 py-3 rounded-md shadow text-sm font-medium
                        {{ session('success') ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}"
                >
                    {{ session('success') ?? session('error') }}
                </div>
            @endif

            <!-- Contingut -->
            @can('manage-users')
                <!-- Vista per a mòbil -->
                <div class="md:hidden space-y-4 p-4">
                    @foreach($users as $user)
                        <div class="bg-gray-50 rounded-md shadow p-4">
                            <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            <div class="flex flex-wrap gap-1 my-2">
                                @foreach ($user->getRoleNames() as $role)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-200 text-gray-800">{{ ucfirst($role) }}</span>
                                @endforeach
                            </div>
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('users.manage.edit', $user->id) }}" class="p-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50" title="Editar">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('users.manage.delete', $user->id) }}" class="p-2 border border-transparent rounded-md text-white bg-red-600 hover:bg-red-700" title="Eliminar">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Vista per a desktop -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Accions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($user->getRoleNames() as $role)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">{{ ucfirst($role) }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('users.manage.edit', $user->id) }}" class="inline-flex items-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span>Editar</span>
                                        </a>
                                        <a href="{{ route('users.manage.delete', $user->id) }}" class="inline-flex items-center gap-1 px-3 py-1 border border-transparent rounded-md text-sm text-white bg-red-600 hover:bg-red-700">
                                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
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
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No tens permisos</h3>
                    <p class="mt-1 text-sm text-gray-500">No tens permisos per gestionar usuaris.</p>
                </div>
            @endcan
        </div>
    </div>
@endsection
