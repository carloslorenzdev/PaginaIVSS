<x-card.title>
    <i class="bx bx-shield"></i>
    Autenticación de Dos Factores (2FA)
</x-card.title>
<div class="flex items-center justify-between">
    <x-card.subtitle>
        Agrega una capa de seguridad para acceder al sistema
    </x-card.subtitle>
    <x-button.link href="{{ route('perfil.2fa.informacion') }}"
        class="!gap-x-0.5 text-red-600 hover:text-red-800 focus:text-red-600 dark:text-neutral-500 dark:hover:text-red-500 dark:focus:text-red-500">
        Saber más
        <i class="bx bx-chevron-right"></i>
    </x-button.link>
</div>
<div class="flex flex-col mt-5">
    @foreach ($twoFactors as $item)
        @if ($item['color'] == 'gray')
            <x-button disabled
                class="font-medium text-start border border-x-0 first:border-t-0 last:border-b-0 border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-red-600 dark:border-neutral-700 hover:dark:bg-neutral-700">
                <i class="bx {{ $item['icono'] }} text-gray-800 dark:text-white"></i>
                <div class="flex justify-between items-center w-full">
                    <div>
                        <p class="text-sm text-gray-800 dark:text-white">{{ $item['nombre'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-neutral-400">{{ $item['descripcion'] }}</p>
                    </div>
                    <div>
                        <x-badge color="{{ $item['color'] }}">
                            <i class="bx {{ $item['icono_estatus'] }}"></i>
                            {{ $item['estatus'] }}
                        </x-badge>
                    </div>
                </div>
            </x-button>
        @else
            <x-button.link href="{{ $item['ruta'] }}"
                class="font-medium border border-x-0 first:border-t-0 last:border-b-0 border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-red-600 dark:border-neutral-700 hover:dark:bg-neutral-700">
                <i class="bx {{ $item['icono'] }} text-gray-800 dark:text-white"></i>
                <div class="flex justify-between items-center w-full">
                    <div>
                        <p class="text-sm text-gray-800 dark:text-white">{{ $item['nombre'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-neutral-400">{{ $item['descripcion'] }}</p>
                    </div>
                    <div>
                        <x-badge color="{{ $item['color'] }}">
                            <i class="bx {{ $item['icono_estatus'] }}"></i>
                            {{ $item['estatus'] }}
                        </x-badge>
                    </div>
                </div>
            </x-button.link>
        @endif
    @endforeach
</div>
