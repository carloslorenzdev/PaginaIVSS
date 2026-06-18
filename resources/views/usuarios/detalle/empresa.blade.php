<x-card class="p-5">
    <x-card.title>
        <i class="bx bx-buildings"></i>
        Empresa
    </x-card.title>
    <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-0 sm:gap-1 md:gap-2 mt-4 text-gray-800 dark:text-white text-sm">
        <div>
            <p class="text-neutral-500">Nombre</p>
        </div>
        <div>
            <p>{{ $entidad->nombre_empresa }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">RIF</p>
        </div>
        <div>
            <p>{{ $entidad->rif }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Tipo de Empresa</p>
        </div>
        <div>
            <p>{{ $entidad->tipo?->desc_tipo_empresa }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Tipo de Sociedad</p>
        </div>
        <div>
            <p>{{ $entidad->sociedad?->desc_sociedad }}</p>
        </div>
        <div>
            <p class="text-neutral-500 mt-3 sm:m-0">Tipo de Actividad</p>
        </div>
        <div>
            <p>{{ $entidad->actividad?->desc_actividad }}</p>
        </div>
    </div>
</x-card>
