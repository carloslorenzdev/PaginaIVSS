<div class="p-5">
    <x-card.title>
        <i class="bx bxs-user-detail"></i>
        Información
    </x-card.title>
    <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-0 sm:gap-1 md:gap-2 mt-4 text-gray-800 dark:text-white text-sm">
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Estatus</p>
        </div>
        <div>
            <x-badge color="{{ $user->colorEstatus() }}">
                <i class="bx bx-{{ $user->isActivo() ? 'check' : 'block' }}"></i>
                {{ $user->estatus() }}
            </x-badge>
        </div>
        <div>
            <p class="text-neutral-500">Nombre</p>
        </div>
        <div>
            <p>{{ $user->nombre }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Usuario</p>
        </div>
        <div>
            <p class="italic">{{ $user->usuario }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Roles</p>
        </div>
        <div>
            <p>{{ $user->roles->pluck('name')->join(', ', ' y ') }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Cambio Contraseña</p>
        </div>
        <div>
            <x-tooltip titulo="{{ $user->formatoNormal('cambio_pass') ?: '' }}">
                <p>{{ $user->fechaHumanos('cambio_pass') ?: '-' }}</p>
            </x-tooltip>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Bloqueado</p>
        </div>
        <div>
            <x-tooltip titulo="{{ $user->formatoNormal('bloqueado') ?: '' }}">
                <p>{{ $user->fechaHumanos('bloqueado') ?: '-' }}</p>
            </x-tooltip>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">F. Registro</p>
        </div>
        <div>
            <x-tooltip titulo="{{ $user->formatoNormal('created_at') }}">
                <p>{{ $user->fechaHumanos('created_at') }}</p>
            </x-tooltip>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Últ. Actualización</p>
        </div>
        <div>
            <x-tooltip titulo="{{ $user->formatoNormal('updated_at') ?: '' }}">
                <p>{{ $user->fechaHumanos('updated_at') ?: '-' }}</p>
            </x-tooltip>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Creado por</p>
        </div>
        <div>
            <p>{{ $user->creador->nombre ?: '-' }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Modificado por</p>
        </div>
        <div>
            <p>{{ $user->modificador?->nombre ?: '-' }}</p>
        </div>
    </div>
</div>
