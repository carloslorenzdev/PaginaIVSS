<div class="space-y-5">
    <div>
        <x-card.title class="!text-md md:!text-2xl">Telegram App Activo</x-card.title>
        <p class="text-sm md:text-base text-gray-500 dark:text-neutral-400">
            Información de la activación y el último uso
        </p>
    </div>
    <div class="flex flex-wrap justify-center items-center gap-5">
        <div class="size-40">
            <img class="size-40 rounded-full shadow-sm" src="{{ asset('imagenes/telegram.png') }}" alt="Telegram App"
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
                            <x-badge color="{{ $user->telegram2faEnabled() ? 'teal' : 'yellow' }}">
                                <i class="bx bx-{{ $user->telegram2faEnabled() ? 'check' : 'block' }}"></i>
                                {{ $user->telegram2faEnabled() ? 'Habilitado' : 'Deshabilitado' }}
                            </x-badge>
                        </x-table.td>
                    </x-table.tr>
                    <x-table.tr>
                        <x-table.td>
                            <p class="text-neutral-500 mt-3 sm:m-0">F. Activación</p>
                        </x-table.td>
                        <x-table.td>
                            <x-tooltip
                                titulo="{{ $user->formatoNormal(config('telegram.otp_secret_confirmed')) ?: '' }}">
                                <p>{{ $user->fechaHumanos(config('telegram.otp_secret_confirmed')) ?: '-' }}</p>
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
            Si deseas <strong>deshabilitar</strong> este método realiza los siguientes pasos
        </p>
    </div>
    <div class="flex flex-col md:flex-row justify-center gap-3">
        <div class="order-2 md:order-1">
            <x-card class="p-6 space-y-3">
                <div>
                    <ol class="list-decimal list-inside text-gray-500 dark:text-neutral-400">
                        <li>
                            Click en el siguiente enlace para recibir el código de verificación.
                            <div class="flex justify-center py-5">
                                <x-button.link href="{{ route('2fa.telegram.envia-otp') }}"
                                    class="!inline-flex font-semibold rounded-lg border border-transparent shadow bg-red-600 text-white hover:bg-red-700 focus:outline-2 focus:bg-red-700">
                                    Enviar Código
                                </x-button.link>
                            </div>
                        </li>
                        <li>Ingresa el código recibido en el formulario.</li>
                        <li>Espera en unos minutos la respuesta.</li>
                    </ol>
                </div>
            </x-card>
        </div>
        <div class="order-1 md:order-2 flex flex-col items-center space-y-4">
            <div class="max-w-md">
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
            <div class="max-w-md">
                <x-alerta color='yellow' titulo="Importante">
                    <x-alerta.mensaje>
                        <p>Asegúrate de que el bot tenga la siguiente informacion:</p>
                        <p class="text-sm mt-5">Nombre: <strong>{{ $botInfo->getFirstName() }}</strong></p>
                        <p class="text-sm">Usuario: <strong>{{ '@' . $botInfo->getUsername() }}</strong></p>
                    </x-alerta.mensaje>
                </x-alerta>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <p class="text-lg text-center text-gray-800 dark:text-neutral-200">Ingresa el código recibido</p>
        <div class="flex justify-center px-3">
            <div class="overflow-x-auto p-3">
                <x-form-otp ruta="{{ route('perfil.2fa.telegram-app.deshabilitar') }}" boton="Deshabilitar" />
            </div>
        </div>
    </div>
</div>
