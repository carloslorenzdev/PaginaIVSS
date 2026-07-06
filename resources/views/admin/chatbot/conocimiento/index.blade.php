@extends('layouts/app')

@section('titulo', 'Base de Conocimiento del Chatbot')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="Base de Conocimiento del Chatbot" />
            
            <button id="btn-nuevo-registro"
                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700 transition-colors">
                <i class="bx bx-plus"></i> Nuevo Registro
            </button>
        </div>



        @if($errors->any())
            <div class="bg-red-50 border-t-2 border-red-500 rounded-lg p-4 dark:bg-red-800/30" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bx bx-x-circle text-red-400 mt-0.5"></i>
                    </div>
                    <div class="ms-3">
                        <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- LISTADO EN TARJETAS --}}
        <div class="space-y-4">
            @forelse($conocimientos as $item)
                <x-card class="relative p-5 hover:bg-gray-50 dark:hover:bg-neutral-800/50 text-gray-800 dark:text-neutral-200 transition-colors {{ $item->activo ? '' : 'opacity-60' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pr-16">
                        
                        <div class="col-span-1">
                            <div class="flex flex-col items-start gap-2">
                                <x-badge color="{{ $item->activo ? 'teal' : 'red' }}">
                                    <i class="bx {{ $item->activo ? 'bx-check-circle' : 'bx-x-circle' }} mr-1"></i> 
                                    {{ $item->activo ? 'Activo' : 'Inactivo' }}
                                </x-badge>
                                <p class="block font-bold text-gray-900 dark:text-white text-base">
                                    {{ $item->pregunta }}
                                </p>
                            </div>
                            <div class="mt-3">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500">Palabras Clave</p>
                                <p class="text-sm mt-1 text-gray-700 dark:text-neutral-300">{{ $item->palabras_clave }}</p>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500">Respuesta HTML</p>
                            <div class="text-sm mt-1 text-gray-700 dark:text-neutral-300 bg-gray-100 dark:bg-neutral-900 p-2 rounded max-h-32 overflow-y-auto">
                                {{ $item->respuesta }}
                            </div>
                        </div>

                    </div>

                    {{-- ACCIONES --}}
                    <div class="absolute top-5 right-5 flex flex-col sm:flex-row gap-2">
                        <button type="button" 
                            class="btn-edit text-gray-500 hover:text-blue-600 transition-colors bg-white hover:bg-blue-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-blue-900/30"
                            data-id="{{ $item->id }}"
                            data-update-url="{{ route('admin.chatbot.conocimiento.update', $item->id) }}"
                            data-pregunta="{{ $item->pregunta }}"
                            data-palabras_clave="{{ $item->palabras_clave }}"
                            data-respuesta="{{ $item->respuesta }}"
                            data-activo="{{ $item->activo ? '1' : '0' }}"
                            title="Editar Registro">
                            <i class="bx bx-edit text-lg"></i>
                        </button>
                        
                        <button type="button" 
                            class="btn-delete text-gray-500 hover:text-red-600 transition-colors bg-white hover:bg-red-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-red-900/30"
                            data-delete-url="{{ route('admin.chatbot.conocimiento.destroy', $item->id) }}"
                            title="Eliminar Registro">
                            <i class="bx bx-trash text-lg"></i>
                        </button>
                    </div>
                </x-card>
            @empty
                <div class="text-center py-10 bg-white border rounded-xl dark:bg-neutral-900 dark:border-neutral-700 text-gray-500 dark:text-neutral-400">
                    <i class="bx bx-bot text-4xl mb-3"></i>
                    <p>No hay conocimientos registrados en la base de datos.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $conocimientos->links() }}
        </div>
    </x-section>

    {{-- MODAL CREAR/EDITAR --}}
    <div id="modal-registro" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm transition-opacity">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative w-full max-w-lg transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all dark:bg-neutral-800 sm:my-8">
                
                <form id="form-registro" method="POST" action="{{ route('admin.chatbot.conocimiento.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    
                    <div class="flex items-center justify-between border-b px-6 py-4 dark:border-neutral-700">
                        <h3 id="modal-title" class="text-lg font-bold text-gray-900 dark:text-white">
                            Nuevo Conocimiento
                        </h3>
                        <button type="button" id="btn-cerrar-modal" class="inline-flex size-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-600">
                            <i class="bx bx-x text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-white">Pregunta / Título</label>
                            <input type="text" name="pregunta" id="input-pregunta" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required placeholder="Ej: Requisitos Pensión Vejez">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-white">Palabras Clave <span class="text-xs font-normal text-gray-500">(separadas por comas)</span></label>
                            <input type="text" name="palabras_clave" id="input-palabras" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required placeholder="Ej: pension, vejez, requisitos">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-white">Respuesta HTML</label>
                            <textarea name="respuesta" id="input-respuesta" rows="5" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required placeholder="El mensaje que enviará el bot..."></textarea>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="activo" id="input-activo" value="1" checked class="shrink-0 mt-0.5 border-gray-200 rounded text-teal-600 focus:ring-teal-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-teal-500 dark:checked:border-teal-500 dark:focus:ring-offset-gray-800">
                            <label for="input-activo" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Activar este conocimiento</label>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-x-2 border-t px-6 py-4 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800/50">
                        <button type="button" id="btn-cancelar-modal" class="rounded-lg border px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800">
                            Cancelar
                        </button>
                        <button type="submit" class="rounded-lg bg-teal-600 px-4 py-2 text-sm font-medium text-white hover:bg-teal-700 shadow-sm">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- FORMULARIO OCULTO PARA ELIMINAR --}}
    <form id="form-delete" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- MODAL ELIMINAR --}}
    <div id="modal-eliminar" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modal-eliminar-backdrop"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl p-6 animate-modal">
            <div class="flex items-center gap-3 mb-4">
                <div class="size-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-trash text-2xl text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Conocimiento</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-2">¿Confirmas que deseas eliminar este registro del chatbot?</p>
            
            <div class="flex gap-3 justify-end border-t pt-4 dark:border-neutral-700 mt-5">
                <button type="button" id="btn-cerrar-eliminar"
                    class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
                    Cancelar
                </button>
                <button type="button" id="btn-confirmar-eliminar"
                    class="py-2 px-4 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all inline-flex items-center gap-2">
                    <i class="bx bx-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Use event delegation or IIFE to handle Turbo replacements
        (function() {
            function initConocimientos() {
                const modal = document.getElementById('modal-registro');
                const form = document.getElementById('form-registro');
                const formMethod = document.getElementById('form-method');
                const modalTitle = document.getElementById('modal-title');
                
                const btnNuevo = document.getElementById('btn-nuevo-registro');
                const btnCerrar = document.getElementById('btn-cerrar-modal');
                const btnCancelar = document.getElementById('btn-cancelar-modal');
                const formDelete = document.getElementById('form-delete');
                
                const urlStore = "{{ route('admin.chatbot.conocimiento.store') }}";
                
                if (!modal || !form || !btnNuevo) return; // Prevent errors if DOM missing

                function openModal() {
                    modal.classList.remove('hidden');
                }
                
                function closeModal() {
                    modal.classList.add('hidden');
                }
                
                // Clear existing listeners by cloning and replacing the button to avoid duplicates
                const newBtnNuevo = btnNuevo.cloneNode(true);
                btnNuevo.parentNode.replaceChild(newBtnNuevo, btnNuevo);
                
                newBtnNuevo.addEventListener('click', () => {
                    form.action = urlStore;
                    formMethod.value = 'POST';
                    modalTitle.textContent = 'Nuevo Conocimiento';
                    form.reset();
                    document.getElementById('input-activo').checked = true;
                    openModal();
                });
                
                btnCerrar.addEventListener('click', closeModal);
                btnCancelar.addEventListener('click', closeModal);
                
                // Cerrar al hacer clic fuera
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModal();
                });

                // Remove previous global click listener if exists
                if (window._conocimientoClickListener) {
                    document.removeEventListener('click', window._conocimientoClickListener);
                }

                const modalEliminar = document.getElementById('modal-eliminar');
                const btnCerrarEliminar = document.getElementById('btn-cerrar-eliminar');
                const btnConfirmarEliminar = document.getElementById('btn-confirmar-eliminar');

                function closeEliminarModal() {
                    modalEliminar.classList.add('hidden');
                    modalEliminar.classList.remove('flex');
                }

                btnCerrarEliminar.addEventListener('click', closeEliminarModal);
                modalEliminar.addEventListener('click', (e) => {
                    if (e.target === modalEliminar) closeEliminarModal();
                });

                btnConfirmarEliminar.addEventListener('click', () => {
                    formDelete.submit();
                });

                // Event delegation for Edit and Delete buttons
                window._conocimientoClickListener = function(e) {
                    // Handle Edit
                    const btnEdit = e.target.closest('.btn-edit');
                    if (btnEdit) {
                        form.action = btnEdit.dataset.updateUrl;
                        formMethod.value = 'PUT';
                        modalTitle.textContent = 'Editar Conocimiento';
                        
                        document.getElementById('input-pregunta').value = btnEdit.dataset.pregunta;
                        document.getElementById('input-palabras').value = btnEdit.dataset.palabras_clave;
                        document.getElementById('input-respuesta').value = btnEdit.dataset.respuesta;
                        document.getElementById('input-activo').checked = btnEdit.dataset.activo === '1';
                        
                        openModal();
                        return;
                    }

                    // Handle Delete
                    const btnDelete = e.target.closest('.btn-delete');
                    if (btnDelete) {
                        formDelete.action = btnDelete.dataset.deleteUrl;
                        modalEliminar.classList.remove('hidden');
                        modalEliminar.classList.add('flex');
                    }
                };

                document.addEventListener('click', window._conocimientoClickListener);

                // Auto-open modal if URL has ?pregunta=
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('pregunta')) {
                    newBtnNuevo.click();
                    document.getElementById('input-pregunta').value = urlParams.get('pregunta');
                    
                    // Remove the query param so it doesn't reopen on reload
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }

            // Init on first load and on Turbo load
            initConocimientos();
            document.addEventListener('turbo:load', initConocimientos);
        })();
    </script>
@endsection
