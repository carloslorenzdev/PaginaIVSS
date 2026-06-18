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
                Descarga la aplicación
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                Te recomendamos que descargues una de las siguientes aplicaciones en tu teléfono Android o iOS
            </p>
            <div class="flex justify-center gap-x-3 mt-5">
                <x-card class="p-3 pr-5">
                    <div class="flex gap-x-2">
                        <div class="size-14 rounded-lg overflow-hidden">
                            <img src="{{ asset('imagenes/auth_microsoft.png') }}" alt="Microsoft Authenticator"
                                @cspNonce>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                                Microsoft Authenticator
                            </p>
                            <div class="inline-flex items-center gap-x-3 text-sm text-gray-500 dark:text-neutral-400">
                                <x-button.link target="_blank"
                                    href="https://play.google.com/store/apps/details?id=com.azure.authenticator"
                                    class="hover:text-red-600 focus:ring-1 focus:border focus:border-red-500 rounded-sm">
                                    <i class="bx bxl-android"></i>
                                    Descargar Android
                                </x-button.link>
                                <x-button.link target="_blank"
                                    href="https://apps.apple.com/es/app/microsoft-authenticator/id983156458"
                                    class="hover:text-red-600 focus:ring-1 focus:border focus:border-red-500 rounded-sm">
                                    <i class="bx bxl-apple"></i>
                                    Descargar iOS
                                </x-button.link>
                            </div>
                        </div>
                    </div>
                </x-card>
                <x-card class="p-3 pr-5">
                    <div class="flex gap-x-2">
                        <div class="size-14 rounded-lg overflow-hidden">
                            <img src="{{ asset('imagenes/auth_google.png') }}" alt="Google Authenticator" @cspNonce>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                                Google Authenticator
                            </p>
                            <div class="inline-flex items-center gap-x-3 text-sm text-gray-500 dark:text-neutral-400">
                                <x-button.link target="_blank"
                                    href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2"
                                    class="hover:text-red-600 focus:ring-1 focus:border focus:border-red-500 rounded-sm">
                                    <i class="bx bxl-android"></i>
                                    Descargar Android
                                </x-button.link>
                                <x-button.link target="_blank"
                                    href="https://apps.apple.com/es/app/google-authenticator/id388497605"
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
                <x-badge color="sky" class="!font-bold">2</x-badge>
            </div>
        </div>
        <div class="grow pb-8 group-last:pb-0">
            <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                Vinculación
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                Ingresa a la aplicación y agrega una nueva cuenta donde puedes escanear <strong>QR</strong>
                o ingresar la <strong>clave secreta</strong>
            </p>

            <div class="flex justify-center mt-5 gap-x-5">
                <x-card class="p-4 space-y-3">
                    <div class="size-40 mx-auto">
                        <img src="data:image/svg+xml;base64,{{ $data['qr'] }}" alt="QR Code" @cspNonce>
                    </div>
                    <div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                            Clave secreta
                        </p>
                        <p class="font-semibold text-md text-gray-800 dark:text-neutral-200">{{ $data['clave'] }}</p>
                    </div>
                </x-card>
                <div class="max-w-md">
                    <x-alerta titulo="Importante">
                        <x-alerta.mensaje>
                            Al registrar manualmente, en el <strong>nombre de la cuenta</strong> colocar
                            <strong>{{ config('app.name') }}</strong>
                        </x-alerta.mensaje>
                    </x-alerta>
                </div>
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
                Verificación
            </h3>

            <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                Luego de <strong>escanear</strong> o <strong>agregar manualmente</strong> la cuenta en la aplicación
                ingresa el código aleatorio que te muestra la aplicacion. El código debe tener un formato similar
                <strong>E.j.: 123-456</strong>
            </p>
            <div class="max-w-md mx-auto mt-8">
                @if ($enabled)
                    <x-form-otp ruta="{{ route('perfil.2fa.authenticator-app.habilitar') }}" />
                @endif
            </div>
        </div>
    </div>
</div>
