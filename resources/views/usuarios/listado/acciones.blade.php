<x-dropdown>
    <x-slot:boton id="hs-dropdown-{{ $user->usuario }}"
        class="p-1 rounded-lg z-0 hover:border-red-500 focus:border-red-600">
        <i class='bx bx-dots-vertical-rounded'></i>
    </x-slot:boton>
    <div class="p-1 space-y-0.5 rounded-lg shadow-lg">
        <x-nav.link href="{{ route('usuarios.detalle', $user) }}">
            <i class="bx bx-show"></i>
            Detalle
        </x-nav.link>
        @if ($user->isActivo())
            <button type="button" class="btn-edit-user w-full text-left flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700"
                data-usuario="{{ $user->usuario }}"
                data-nombre="{{ $user->nombre }}"
                data-email="{{ $user->email }}"
                data-rol="{{ $user->roles->first()?->name ?? '' }}">
                <i class="bx bx-edit-alt"></i>
                Editar
            </button>
            <x-modal.button data-ruta="{{ route('usuarios.restablecer', $user) }}" data-usuario="{{ $user->usuario }}"
                data-tipo="Restablecer Contraseña"
                class="w-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-900">
                <i class="bx bx-reset"></i>
                Restablecer Contraseña
            </x-modal.button>
            <x-modal.button data-ruta="{{ route('usuarios.bloquear', $user) }}" data-usuario="{{ $user->usuario }}"
                data-tipo="Bloquear"
                class="w-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-900">
                <i class="bx bx-block"></i>
                Bloquear
            </x-modal.button>
        @else
            <x-modal.button data-ruta="{{ route('usuarios.desbloquear', $user) }}" data-usuario="{{ $user->usuario }}"
                data-tipo="Desbloquear"
                class="w-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-900">
                <i class='bx bx-lock-open-alt'></i>
                Desloquear
            </x-modal.button>
        @endif

        @can('usuarios.eliminar')
            <div class="border-t border-gray-200 dark:border-neutral-700 my-1"></div>
            <x-modal.button data-ruta="{{ route('usuarios.eliminar', $user) }}" data-usuario="{{ $user->usuario }}"
                data-tipo="Eliminar" data-method="DELETE"
                class="w-full text-red-600 hover:bg-red-50 focus:bg-red-50 dark:text-red-500 dark:hover:bg-red-900/30 dark:focus:bg-red-900/30">
                <i class='bx bx-trash'></i>
                Eliminar
            </x-modal.button>
        @endcan
    </div>
</x-dropdown>
