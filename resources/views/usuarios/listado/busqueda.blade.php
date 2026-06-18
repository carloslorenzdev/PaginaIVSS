<form action="" method="get">
    <div class="grid grid-cols-12 gap-3 my-4">
        <div class="col-span-12 sm:col-span-8 md:col-span-6">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
                    <i class="bx bx-search-alt text-gray-400 dark:text-white/60"></i>
                </div>
                <x-input class="ps-10 pe-4" type="search" name="q" aria-expanded="false"
                    placeholder="Buscar usuario" value="{{ request()->get('q') }}" />
            </div>
        </div>
        <div class="col-span-12 sm:col-span-4 md:col-span-6">
            <div class="flex items-center justify-start gap-x-3 h-full">
                <x-input.button>Buscar</x-input.button>
            </div>
        </div>
    </div>
</form>
@if (request()->getQueryString())
    <div class="flex items-center justify-start gap-x-1 my-3">
        @php
            $limpiar = false;
        @endphp
        @if (count(request()->query()))
            <small class="text-gray-500">{{ $usuarios->total() }} resultados</small>
        @endif
        @if ($limpiar || request()->getQueryString())
            <x-button.link href="{{ request()->url() }}"
                class="p-1! gap-x-1! rounded-lg text-red-500 hover:text-red-800 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
                <small>
                    <i class="bx bx-x" style="font-size: 0.9rem"></i>
                    Limpiar
                </small>
            </x-button.link>
        @endif
    </div>
@endif
