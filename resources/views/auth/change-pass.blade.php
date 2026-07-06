@extends('layouts/app')

@section('titulo', 'Cambio contraseña')

@section('content')
    <div class="container mx-auto">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 animate-fade-in-up animate-duration-200">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm text-gray-800 dark:text-neutral-200">
                <div class="flex justify-center animate-fade-in-left animate-delay-100">
                    <i class="bx bx-key bx-flip-horizontal" style="font-size: 6rem"></i>
                </div>
                <h2 class="mt-5 text-center text-3xl font-bold tracking-tight text-gray-800 dark:text-neutral-200">
                    Cambio de contraseña
                </h2>
                <p class="mt-4 dark:text-gray-400">
                    Necesitamos que cambies tu clave para ingresar al sistema
                </p>
            </div>

            <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" data-hs-toggle-password-group="" action="{{ route('password.change') }}"
                    method="POST">
                    @csrf

                    <div class="max-w-sm">
                        <x-input.label for="password">Nueva Contraseña</x-input.label>
                        <x-input.password id="password" name="password" placeholder="Tu nueva contraseña"
                            toggleTarget='["#password","#password_confirmation"]' required autofocus />
                        <x-input.error campo="password" />
                    </div>
                    <div class="max-w-sm">
                        <x-input.label for="password_confirmation">
                            Confirmación Contraseña
                        </x-input.label>
                        <x-input.password id="password_confirmation" name="password_confirmation"
                            placeholder="Confirma la nueva contraseña" toggleTarget='["#password","#password_confirmation"]'
                            required />
                        <x-input.error campo="password_confirmation" />
                    </div>
                    <div>
                        <x-input.button>
                            Cambiar
                        </x-input.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Alerta de Seguridad',
                html: '<p>Por medidas de seguridad, es <strong>obligatorio</strong> que asigne una nueva contraseña personal.</p><br><p>Una vez cambiada, por favor diríjase a su <b>Perfil</b> y active la <b>Autenticación 2FA</b>.</p>',
                icon: 'warning',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#dc2626',
                allowOutsideClick: false
            });
        });
    </script>
@endsection
