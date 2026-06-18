<div class="mt-5 p-5 space-y-3 text-gray-800 dark:text-white">
    <h3 class="text-2xl">Métodos soportados</h3>
    <p class="text-base text-gray-800 dark:text-neutral-200">
        Estos son los métodos soportados dentro del sistema que se encuentran disponibles y recomendamos que actives al
        menos uno de ellos
    </p>
    <div class="flex flex-col md:flex-row justify-center gap-x-5">
        <div class="mx-auto max-w-md my-5">
            <x-alerta titulo="Importante">
                <x-alerta.mensaje>
                    Para activar uno de ellos, deberás seguir los pasos indicados según el método de autenticación
                    elegido
                </x-alerta.mensaje>
            </x-alerta>
        </div>
        <div class="mx-auto max-w-md my-5">
            <x-alerta titulo="Importante">
                <x-alerta.mensaje>
                    Al activar cualquiera de estas opciones, se te solicitará un <strong>código temporal</strong> para
                    verificar tu identidad, al iniciar sesión o después de un tiempo determinado mientras estés dentro
                    del sistema
                </x-alerta.mensaje>
            </x-alerta>
        </div>
    </div>
    <div class="px-4 mx-auto">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
            @foreach ($twoFactors as $item)
                @if ($item['estatus'])
                    <x-button.link class="group focus:ring-2 focus:ring-red-600" href="{{ $item['ruta'] }}">
                        <x-card class="p-4">
                            <div class="flex gap-x-5">
                                <div
                                    class="group-hover:text-red-600 text-gray-800 dark:group-hover:text-red-500 dark:text-neutral-200">
                                    <i class="bx {{ $item['icono'] }}"></i>
                                </div>
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-red-600 font-semibold text-gray-800 dark:group-hover:text-red-500 dark:text-neutral-200">
                                        {{ $item['nombre'] }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        {{ $item['descripcion'] }}
                                    </p>
                                </div>
                            </div>
                        </x-card>
                    </x-button.link>
                @else
                    <x-button disabled class="group focus:ring-2 focus:ring-red-600 text-start">
                        <x-card class="p-4">
                            <div class="flex gap-x-5">
                                <div
                                    class="group-hover:text-red-600 text-gray-800 dark:group-hover:text-red-500 dark:text-neutral-200">
                                    <i class="bx {{ $item['icono'] }}"></i>
                                </div>
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-red-600 font-semibold text-gray-800 dark:group-hover:text-red-500 dark:text-neutral-200">
                                        {{ $item['nombre'] }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        {{ $item['descripcion'] }}
                                    </p>
                                </div>
                            </div>
                        </x-card>
                    </x-button>
                @endif
            @endforeach
        </div>
    </div>
</div>
