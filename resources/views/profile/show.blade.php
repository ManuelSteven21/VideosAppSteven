@extends('layouts.VideosAppLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Encabezado personalizado -->
        <div class="bg-white shadow-sm border-b border-gray-200 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <h2 class="text-2xl font-bold text-gray-900">
                    Configuració del Perfil
                </h2>
            </div>
        </div>

        <div class="space-y-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="bg-white shadow rounded-lg p-6">
                    @livewire('profile.update-profile-information-form')
                </div>

                <div class="border-t border-gray-200"></div>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="bg-white shadow rounded-lg p-6">
                    @livewire('profile.update-password-form')
                </div>

                <div class="border-t border-gray-200"></div>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="bg-white shadow rounded-lg p-6">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <div class="border-t border-gray-200"></div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="border-t border-gray-200"></div>

                <div class="bg-white shadow rounded-lg p-6">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Adaptación de los componentes de Jetstream */
        .bg-white.shadow.rounded-lg {
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .border-gray-200 {
            border-color: #edf2f7;
        }

        /* Botones primarios */
        button[type='submit'].bg-red-600 {
            background-color: #dc2626;
        }

        button[type='submit'].bg-red-600:hover {
            background-color: #b91c1c;
        }

        /* Campos de formulario */
        .rounded-md.input, .rounded-md.textarea {
            border-radius: 0.375rem;
            border: 1px solid #e2e8f0;
        }

        /* Mensajes de confirmación */
        .bg-green-100 {
            background-color: #f0fff4;
            border-color: #68d391;
        }
    </style>
@endpush
