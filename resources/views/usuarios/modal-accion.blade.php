<x-modal id='modal-example'>
    <x-modal.body class="text-center sm:p-4 pt-0">
        <span id="icono-modal"
            class="mb-2 inline-flex items-center justify-center size-[72px] rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100">
            <i class="bx bxs-error" style="font-size: 32px;"></i>
        </span>
        <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-neutral-200" id="descripcion-modal">
        </h3>
        <p class="text-gray-500 dark:text-neutral-500">
            ¿Está seguro de <span id="tipo"></span> al usuario <span class="font-bold"></span>?
        </p>
    </x-modal.body>
    <x-modal.footer id="modal-example" class="justify-end" btnClose="No, cancelar">
        <form action="#" method="POST" id="formModal">
            @csrf
            @method('POST')
            <x-input.button class="font-normal">
                Sí, bloquear
            </x-input.button>
        </form>
    </x-modal.footer>
</x-modal>

@push('page-scripts')
    @vite(['resources/js/modal-usuario.js'])
@endPush
