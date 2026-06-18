<x-dropdown>
    <x-slot:boton id="hs-dropdown-account"
        class="rounded-full !py-1 !ps-1 !pe-1 !sm:pe-3 border border-gray-500 hover:border-red-500 hover:bg-red-50 dark:hover:border-red-500 dark:hover:bg-red-800/30">
        <span
            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full uppercase text-[0.7rem] font-medium bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white">
            {{ auth()->user()->iniciales }}
        </span>
        <span class="hidden sm:block">
            <i class="bx bx-chevron-down transition-all hs-dropdown-open:rotate-180"></i>
        </span>
    </x-slot:boton>

    <x-slot:header class="bg-red-50 dark:bg-red-800/30">
        <p class="text-sm text-gray-500 dark:text-neutral-400">
            {{ str(auth()->user()->nombre)->limit(30) }}
        </p>
        <p class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
            {{ auth()->user()->usuario }}
        </p>
    </x-slot:header>

    <div class="p-1.5 space-y-0.5">
        <div
            class="w-full sm:hidden inline-flex items-center rounded-lg text-sm text-gray-800 hover:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700">
            @include('layouts/sections/navbar/mode-theme')
            <x-button class="w-full hs-dark-mode-active:hidden text-start" data-hs-theme-click-value="dark">
                Tema Oscuro
            </x-button>
            <x-button class="w-full not-hs-dark-mode-active:hidden text-start" data-hs-theme-click-value="light">
                Tema Claro
            </x-button>
        </div>
        <x-nav.link href="{{ route('perfil.detalle') }}" active="{{ routeActive('perfil.detalle') }}">
            <i class="bx bx-user"></i>
            Mi Perfil
        </x-nav.link>
        <form action="{{ route('logout') }}" class="w-full" method="POST">
            @csrf
            <x-button
                class="rounded-lg text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-900 w-full"
                type="submit">
                <i class="bx bx-log-out"></i>
                Salir
            </x-button>
        </form>
    </div>
</x-dropdown>
