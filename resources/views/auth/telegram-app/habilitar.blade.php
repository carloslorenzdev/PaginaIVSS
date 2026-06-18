<div>
    <div class="group relative flex gap-x-5">
        <div
            class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
            <div class="relative z-10 size-6 flex justify-center items-center">
                <x-badge color="sky" class="!font-bold">1</x-badge>
            </div>
        </div>
        <div class="grow pb-8 group-last:pb-0">
            <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                Descarga la aplicación (Si aplica)
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                Deber tener la aplicación descargada y en funcionamiento. Si aún no la tienes, la puedes descargar con
                los siguientes enlaces para tu teléfono Android o iOS
            </p>
            <div class="flex justify-center gap-x-3 mt-5">
                <x-card class="p-3 pr-5">
                    <div class="flex gap-x-2">
                        <div class="size-14 rounded-lg overflow-hidden">
                            <img src="{{ asset('imagenes/telegram.png') }}" alt="Telegram App" @cspNonce>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                                Telegram
                            </p>
                            <div class="inline-flex items-center gap-x-3 text-sm text-gray-500 dark:text-neutral-400">
                                <x-button.link target="_blank"
                                    href="https://play.google.com/store/apps/details?id=org.telegram.messenger"
                                    class="hover:text-red-600 focus:ring-1 focus:border focus:border-red-500 rounded-sm">
                                    <i class="bx bxl-android"></i>
                                    Descargar Android
                                </x-button.link>
                                <x-button.link target="_blank"
                                    href="https://apps.apple.com/es/app/telegram-messenger/id686449807"
                                    class="hover:text-red-600 focus:ring-1 focus:border focus:border-red-500 rounded-sm">
                                    <i class="bx bxl-apple"></i>
                                    Descargar iOS
                                </x-button.link>
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
    <div class="group relative flex gap-x-5">
        <div
            class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
            <div class="relative z-10 size-6 flex justify-center items-center">
                <x-badge color="sky" class="!font-bold">2a</x-badge>
            </div>
        </div>
        <div class="grow pb-8 group-last:pb-0">
            <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                Vinculación Automática (recomendada)
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                Escanea el QR que te llevará al chat del bot, luego espera unos minutos la respuesta.
            </p>

            <div class="flex justify-center mt-5 gap-x-5">
                <x-card class="p-6 space-y-3">
                    <div>
                        <ol class="list-decimal list-inside text-gray-500 dark:text-neutral-400">
                            <li>
                                Escanea el siguiente QR
                                <div class="size-40 mx-auto rounded-lg my-3 overflow-hidden">
                                    <img src="data:image/svg+xml;base64,{{ $data['qr'] }}" alt="QR Code" @cspNonce>
                                </div>
                            </li>
                            <li>
                                Luego de llegar al chat, dar click al botón <strong>Iniciar</strong> solo si te aparece
                            </li>
                            <li>Se enviará en automático el mensaje <strong>/start</strong></li>
                            <li>Espera en unos minutos la respuesta.</li>
                        </ol>
                    </div>
                </x-card>
                <div class="space-y-4">
                    <div class="max-w-md">
                        <x-alerta color='yellow' titulo="Importante">
                            <x-alerta.mensaje>
                                <p>Asegúrate de que el bot tenga la siguiente informacion:</p>
                                <p class="text-sm mt-5">Nombre: <strong>{{ $botInfo->getFirstName() }}</strong></p>
                                <p class="text-sm">Usuario: <strong>{{ '@' . $botInfo->getUsername() }}</strong></p>
                            </x-alerta.mensaje>
                        </x-alerta>
                    </div>
                    <div class="max-w-md">
                        <x-alerta titulo="Alternativa">
                            <x-alerta.mensaje>
                                <p>Si no puedes escanear el QR da click al siguiente enlace</p>
                                <div class="inline-flex gap-x-3">
                                    @if ($data['isDesktop'])
                                        <x-button.link href="{{ $data['link'] }}" target='_blank'
                                            class="text-blue-500 hover:text-blue-700">
                                            <i class="bx bx-link-external"></i>
                                            Ir a <strong>{{ '@' . $botInfo->getUsername() }}</strong>
                                        </x-button.link>
                                    @else
                                        <x-button.link href="{{ $data['device'] }}"
                                            class="text-blue-500 hover:text-blue-700">
                                            <i class="bx bx-link-external"></i>
                                            Ir a <strong>{{ '@' . $botInfo->getUsername() }}</strong>
                                        </x-button.link>
                                    @endif
                                </div>
                            </x-alerta.mensaje>
                        </x-alerta>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="group relative flex gap-x-5">
        <div
            class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
            <div class="relative z-10 size-6 flex justify-center items-center">
                <x-badge color="sky" class="!font-bold">2b</x-badge>
            </div>
        </div>
        <div class="grow pb-8 group-last:pb-0">
            <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                Verificación Manual (opcional)
            </h3>

            <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                Si la <strong>Verificación Automática</strong> no te funcionó, realiza los siguentes pasos.
            </p>
            <div class="max-w-lg mx-auto mt-8">
                <x-card class="p-6">
                    <ol class="list-decimal list-inside space-y-4 text-gray-800 dark:text-neutral-200">
                        <li>
                            Busca el chat del bot con el nombre
                            <strong>
                                <span>@</span>{{ $botInfo->getUsername() }}
                            </strong>
                        </li>
                        <li>
                            Luego de entrar al chat, dar click al botón <strong>Iniciar</strong> solo si te aparece
                        </li>
                        <li>
                            Escribe y envía el siguiente mensaje:
                            <p class="ms-5 my-6">
                                <span class="px-5 py-3 font-semibold rounded-lg bg-gray-300 dark:bg-neutral-900">
                                    /start {{ $data['clave'] }}
                                </span>
                            </p>
                        </li>
                        <li>Espera unos minutos la respuesta</li>
                    </ol>
                </x-card>
            </div>
        </div>
    </div>
    <div class="group relative flex gap-x-5">
        <div
            class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
            <div class="relative z-10 size-6 flex justify-center items-center">
                <x-badge color="sky" class="!font-bold">3</x-badge>
            </div>
        </div>
        <div class="grow pb-8 group-last:pb-0">
            <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                Refrescar la página
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                Luego de recibir un mensaje exitoso refresca la página o da click en el siguiente botón
            </p>
            <div class="flex flex-col justify-center items-center mt-8 space-y-3">
                <div class="max-w-md">
                    <x-alerta titulo="Importante" color="yellow">
                        <x-alerta.mensaje>
                            Una vez la vinculación sea exitosa, no <strong>eliminar</strong> el chat con el bot, de lo
                            contrario deberás realizar de nuevo el proceso
                        </x-alerta.mensaje>
                    </x-alerta>
                </div>
                <x-button.link href="{{ route('perfil.2fa.telegram-app.configuracion') }}"
                    class="font-semibold rounded-lg border border-transparent shadow bg-red-600 text-white hover:bg-red-700 focus:outline-2 focus:bg-red-700">
                    <i class="bx bx-refresh"></i>
                    Refrescar
                </x-button.link>
            </div>
        </div>
    </div>
</div>
