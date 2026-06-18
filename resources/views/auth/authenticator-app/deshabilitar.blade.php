<div class="space-y-5">
    <div>
        <x-card.title class="!text-md md:!text-2xl">Authenticator App Activo</x-card.title>
        <p class="text-sm md:text-base text-gray-500 dark:text-neutral-400">
            Información de la activación y el último uso
        </p>
    </div>
    <div class="flex flex-wrap justify-center items-center gap-5">
        <div class="size-40">
            <img class="size-40 rounded-full shadow-sm" src="{{ asset('imagenes/auth_microsoft.png') }}" alt=""
                @cspNonce>
        </div>
        <div class="block text-gray-800 dark:text-white text-sm">
            <x-table>
                <tbody>
                    <x-table.tr>
                        <x-table.td>
                            <p class="text-neutral-500">Estatus</p>
                        </x-table.td>
                        <x-table.td>
                            <x-badge color="{{ $user->google2faEnabled() ? 'teal' : 'yellow' }}">
                                <i class="bx bx-{{ $user->google2faEnabled() ? 'check' : 'block' }}"></i>
                                {{ $user->google2faEnabled() ? 'Habilitado' : 'Deshabilitado' }}
                            </x-badge>
                        </x-table.td>
                    </x-table.tr>
                    <x-table.tr>
                        <x-table.td>
                            <p class="text-neutral-500 mt-3 sm:m-0">F. Activación</p>
                        </x-table.td>
                        <x-table.td>
                            <x-tooltip
                                titulo="{{ $user->formatoNormal(config('google2fa.otp_secret_confirmed_at')) ?: '' }}">
                                <p>{{ $user->fechaHumanos(config('google2fa.otp_secret_confirmed_at')) ?: '-' }}</p>
                            </x-tooltip>
                        </x-table.td>
                    </x-table.tr>
                    <x-table.tr>
                        <x-table.td>
                            <p class="text-neutral-500 mt-3 sm:m-0">Inicio Sesión</p>
                        </x-table.td>
                        <x-table.td>
                            @if ($sesion)
                                <p>{{ $sesion }}</p>
                            @else
                                <span>-</span>
                            @endif
                        </x-table.td>
                    </x-table.tr>
                    <x-table.tr>
                        <x-table.td>
                            <p class="text-neutral-500 mt-3 sm:m-0">Ult. Código</p>
                        </x-table.td>
                        <x-table.td>
                            @if ($otp)
                                <p>{{ $otp }}</p>
                            @else
                                <span>-</span>
                            @endif
                        </x-table.td>
                    </x-table.tr>
                </tbody>
            </x-table>
        </div>
    </div>
    <div>
        <x-card.title class="!text-md md:!text-2xl">Desactivación</x-card.title>
        <p class="text-sm md:text-base text-gray-500 dark:text-neutral-400">
            Si deseas <strong>deshabilitar</strong> este método ingresa el código recibido en la app Authenticator
        </p>
    </div>
    <div>
        <div class="max-w-md mx-auto">
            <x-alerta titulo="Importante">
                <x-alerta.mensaje>
                    Si desdeas forzar la deshabilitación de este método <strong>sin ingresar código</strong>,
                    @hasrole('Patrono')
                        debe dirigirse a la oficina administrativa y solicitar la desactivación.
                    @else
                        solicita a un usuario con <strong>rol</strong> superior o al administrador para que realice
                        la desactivación
                    @endhasrole
                </x-alerta.mensaje>
            </x-alerta>
        </div>
    </div>
    <div class="flex flex-wrap items-center justify-center gap-8">
        <div class="overflow-x-auto p-3">
            <x-form-otp ruta="{{ route('perfil.2fa.authenticator-app.deshabilitar') }}" boton="Deshabilitar" />
        </div>
    </div>
</div>
