@extends('layouts/app')

@section('titulo', 'Preguntas sin Respuesta')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="Preguntas sin Respuesta (Chatbot)" />
        </div>



        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 dark:bg-blue-900/30">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="bx bx-info-circle text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 dark:text-blue-400">
                        Aquí aparecen los mensajes que los usuarios han enviado al Chatbot y el sistema no ha podido interpretar. Puedes agregarlos a la Base de Conocimiento para entrenar al bot.
                    </p>
                </div>
            </div>
        </div>

        {{-- LISTADO EN TARJETAS --}}
        <div class="space-y-4">
            @forelse($preguntas as $item)
                <x-card class="relative p-5 searchable-item hover:bg-gray-50 dark:hover:bg-neutral-800/50 text-gray-800 dark:text-neutral-200 transition-colors">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pr-16">
                        <div class="col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-1">
                                <i class="bx bx-time-five mr-1"></i> Recibida: {{ $item->created_at->format('d/m/Y h:i A') }}
                            </p>
                            <p class="block font-medium text-gray-900 dark:text-white text-lg italic bg-gray-100 p-3 rounded-lg dark:bg-neutral-900/50 border-l-4 border-gray-300 dark:border-neutral-700">
                                "{{ $item->pregunta }}"
                            </p>
                        </div>
                    </div>

                    {{-- ACCIONES --}}
                    <div class="absolute top-5 right-5 flex flex-col sm:flex-row gap-2">
                        <!-- Convertir a Base de Conocimiento -->
                        <a href="{{ route('admin.chatbot.conocimiento.index', ['pregunta' => $item->pregunta]) }}" 
                           class="btn-convertir text-white hover:text-white transition-colors bg-teal-600 hover:bg-teal-700 px-3 py-2 flex items-center justify-center rounded-lg shadow-sm"
                           title="Agregar a Base de Conocimiento"
                           onclick="event.preventDefault(); document.getElementById('form-delete-{{ $item->id }}').submit(); window.location.href = this.href;">
                            <i class="bx bx-plus-circle text-lg mr-1"></i> <span class="text-sm font-semibold">Agregar</span>
                        </a>
                        
                        <!-- Eliminar/Ignorar -->
                        <button type="button" 
                            class="btn-delete-pregunta text-gray-500 hover:text-red-600 transition-colors bg-white hover:bg-red-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-red-900/30"
                            title="Ignorar y Eliminar"
                            data-form-id="form-delete-{{ $item->id }}">
                            <i class="bx bx-trash text-lg"></i>
                        </button>
                    </div>

                    <form id="form-delete-{{ $item->id }}" action="{{ route('admin.chatbot.preguntas-sin-respuesta.destroy', $item->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </x-card>
            @empty
                <div class="text-center py-10 bg-white border rounded-xl dark:bg-neutral-900 dark:border-neutral-700 text-gray-500 dark:text-neutral-400">
                    <i class="bx bx-check-shield text-5xl mb-3 text-teal-500/50"></i>
                    <h3 class="text-lg font-bold text-gray-700 dark:text-neutral-300">¡Bandeja Limpia!</h3>
                    <p class="mt-2 text-sm">El Chatbot ha podido responder a todas las consultas de los usuarios recientes.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $preguntas->links() }}
        </div>
    </x-section>

    {{-- MODAL ELIMINAR --}}
    <div id="modal-eliminar" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modal-eliminar-backdrop"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl p-6 animate-modal">
            <div class="flex items-center gap-3 mb-4">
                <div class="size-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-trash text-2xl text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ignorar y Eliminar</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-2">¿Confirmas que deseas eliminar permanentemente este registro?</p>
            
            <div class="flex gap-3 justify-end border-t pt-4 dark:border-neutral-700 mt-5">
                <button type="button" id="btn-cerrar-eliminar"
                    class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 searchable-item hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
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
        (function() {
            function initPreguntas() {
                const modalEliminar = document.getElementById('modal-eliminar');
                const btnCerrarEliminar = document.getElementById('btn-cerrar-eliminar');
                const btnConfirmarEliminar = document.getElementById('btn-confirmar-eliminar');
                let formIdToDelete = null;

                if (!modalEliminar) return;

                function closeEliminarModal() {
                    modalEliminar.classList.add('hidden');
                    modalEliminar.classList.remove('flex');
                    formIdToDelete = null;
                }

                // Clear previous listeners
                const newBtnCerrar = btnCerrarEliminar.cloneNode(true);
                btnCerrarEliminar.parentNode.replaceChild(newBtnCerrar, btnCerrarEliminar);
                newBtnCerrar.addEventListener('click', closeEliminarModal);

                const newBtnConfirmar = btnConfirmarEliminar.cloneNode(true);
                btnConfirmarEliminar.parentNode.replaceChild(newBtnConfirmar, btnConfirmarEliminar);
                newBtnConfirmar.addEventListener('click', () => {
                    if (formIdToDelete) {
                        document.getElementById(formIdToDelete).submit();
                    }
                });

                modalEliminar.addEventListener('click', (e) => {
                    if (e.target === modalEliminar) closeEliminarModal();
                });

                // Attach to delete buttons globally
                if (window._preguntasDeleteListener) {
                    document.removeEventListener('click', window._preguntasDeleteListener);
                }

                window._preguntasDeleteListener = function(e) {
                    const btnDelete = e.target.closest('.btn-delete-pregunta');
                    if (btnDelete) {
                        formIdToDelete = btnDelete.dataset.formId;
                        modalEliminar.classList.remove('hidden');
                        modalEliminar.classList.add('flex');
                    }
                };

                document.addEventListener('click', window._preguntasDeleteListener);
            }

            initPreguntas();
            document.addEventListener('turbo:load', initPreguntas);
        })();
    </script>
@endsection

