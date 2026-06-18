<div class="flex flex-col md:flex-row justify-end items-center flex-wrap gap-x-2">
    @if ($user->isActivo())
        <x-modal.button data-ruta="{{ route('usuarios.restablecer', $user) }}" data-usuario="{{ $user->usuario }}"
            data-tipo="Restablecer Contraseña"
            class="text-red-500 hover:text-red-800 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
            <i class="bx bx-reset"></i>
            Restablecer Contraseña
        </x-modal.button>
        <x-modal.button data-ruta="{{ route('usuarios.bloquear', $user) }}" data-usuario="{{ $user->usuario }}"
            data-tipo="Bloquear"
            class="text-red-500 hover:text-red-800 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
            <i class="bx bx-block"></i>
            Bloquear
        </x-modal.button>
        @if ($user->hasEnabled2fa())
            <x-button.link href="{{ route('usuarios.desactivar-2fa', $user) }}"
                class="rounded-lg text-red-500 hover:text-red-800 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
                <i class='bx bx-shield'></i>
                Desactivar 2FA
            </x-button.link>
        @endif
        <x-button.link href="{{ route('usuarios.editar', $user) }}"
            class="rounded-lg text-red-500 hover:text-red-800 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
            <i class='bx bx-edit-alt'></i>
            Editar
        </x-button.link>
    @else
        <x-modal.button data-ruta="{{ route('usuarios.desbloquear', $user) }}" data-usuario="{{ $user->usuario }}"
            data-tipo="Desbloquear"
            class="text-red-500 hover:text-red-800 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
            <i class='bx bx-lock-open-alt'></i>
            Desloquear
        </x-modal.button>
    @endif
</div>
