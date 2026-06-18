<x-card class="p-5">
    <x-card.title>
        <i class="bx bx-id-card"></i>
        Funcionario
    </x-card.title>
    <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-0 sm:gap-1 md:gap-2 mt-4 text-gray-800 dark:text-white text-sm">
        <div>
            <p class="text-neutral-500">Cédula</p>
        </div>
        <div>
            <p>{{ $entidad->formatoCedula() }}</p>
        </div>
        <div>
            <p class="text-neutral-500">Nombres</p>
        </div>
        <div>
            <p>{{ $entidad->nombres }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Apellidos</p>
        </div>
        <div>
            <p>{{ $entidad->apellidos }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Cargo</p>
        </div>
        <div>
            <p>{{ $entidad->cargo }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">F. Registro</p>
        </div>
        <div>
            <x-tooltip titulo="{{ $entidad->formatoNormal('created_at') }}">
                <p>{{ $entidad->fechaHumanos('created_at') }}</p>
            </x-tooltip>
        </div>
        @hasrole('Admin')
            <div>
                <p class="text-neutral-500 mt-3 sm:m-0">Últ. Actualización</p>
            </div>
            <div>
                <x-tooltip titulo="{{ $entidad->formatoNormal('updated_at') ?: '' }}">
                    <p>{{ $entidad->fechaHumanos('updated_at') ?: '-' }}</p>
                </x-tooltip>
            </div>
            <div>
                <p class="text-neutral-500 mt-3 sm:m-0">Creado por</p>
            </div>
            <div>
                <p>{{ $entidad->creador->nombre ?: '-' }}</p>
            </div>
            <div>
                <p class="text-neutral-500 mt-3 sm:m-0">Modificado por</p>
            </div>
            <div>
                <p>{{ $entidad->modificador?->nombre ?: '-' }}</p>
            </div>
        @endhasrole
    </div>
</x-card>
