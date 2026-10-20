<div x-data="chatbotConocimientoData(@js($modalOpen))"
     x-on:close-modal.window="cerrarTodo"
     x-on:keydown.escape.window="cerrarTodo">
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <x-titulo titulo="Base de Conocimiento del Chatbot" class="text-gradient font-extrabold text-3xl" />
                <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Administra las respuestas automatizadas del asistente virtual del IVSS.</p>
            </div>
            
            @can('chatbot_conocimiento.crear')
                <button type="button" 
                    @click="abrirCrear"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all transform hover:-translate-y-0.5 disabled:opacity-50">
                    <i class="bx bx-plus text-lg" wire:loading.remove wire:target="openCreateModal"></i>
                    <i class="bx bx-loader-alt bx-spin text-lg" wire:loading wire:target="openCreateModal"></i>
                    <span>Nuevo Registro</span>
                </button>
            @endcan
        </div>

        @if(session('success'))
            <div class="bg-teal-50 border border-teal-200 rounded-xl p-4 dark:bg-teal-900/20 dark:border-teal-900/50 shadow-sm flex items-center justify-between" role="alert">
                <div class="flex items-center gap-3">
                    <i class="bx bx-check-circle text-teal-600 dark:text-teal-400 text-xl"></i>
                    <span class="text-sm font-bold text-teal-800 dark:text-teal-300">{{ session('success') }}</span>
                </div>
                <button type="button" wire:click="$refresh" class="text-teal-500 hover:text-teal-700">
                    <i class="bx bx-x text-lg"></i>
                </button>
            </div>
        @endif

        <!-- Barra de Búsqueda y Filtros -->
        <div class="flex flex-col sm:flex-row items-center gap-4 bg-white dark:bg-neutral-800/80 p-4 rounded-xl border border-gray-100 dark:border-neutral-700 shadow-sm">
            <div class="relative flex-1 w-full">
                <i class="bx bx-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" wire:loading.remove wire:target="search"></i>
                <div class="spinner-border spinner-border-sm text-teal-500 absolute left-3.5 top-1/2 -translate-y-1/2" wire:loading wire:target="search"></div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Buscar por pregunta, palabra clave o respuesta..." 
                       class="py-2.5 pl-10 pr-10 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-xs">
                @if($search)
                    <button wire:click="$set('search', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="bx bx-x text-lg"></i>
                    </button>
                @endif
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 shrink-0">Estado:</span>
                <select wire:model.live="filtroActivo" class="py-2 px-3 text-sm border-gray-200 rounded-xl focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                    <option value="todos">Todos</option>
                    <option value="activos">Solo Activos</option>
                    <option value="inactivos">Solo Inactivos</option>
                </select>
            </div>
        </div>

        {{-- LISTADO EN TARJETAS --}}
        <div class="space-y-4">
            @forelse($conocimientos as $item)
                <div wire:key="conocimiento-{{ $item->id }}" class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 relative group {{ $item->activo ? '' : 'opacity-60 grayscale-[30%]' }}">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pr-20">
                        
                        <div class="col-span-1">
                            <div class="flex flex-col items-start gap-2.5">
                                @can('chatbot_conocimiento.editar')
                                    <button type="button" wire:click="toggleActivo({{ $item->id }})" title="Clic para cambiar estado" class="cursor-pointer">
                                        @if($item->activo)
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-teal-50 text-teal-700 dark:bg-teal-900/20 dark:text-teal-400 border border-teal-100 dark:border-teal-900/50 hover:bg-teal-100 transition-colors">
                                                <i class="bx bx-check-circle text-sm"></i> Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 border border-red-100 dark:border-red-900/50 hover:bg-red-100 transition-colors">
                                                <i class="bx bx-x-circle text-sm"></i> Inactivo
                                            </span>
                                        @endif
                                    </button>
                                @else
                                    @if($item->activo)
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-teal-50 text-teal-700 dark:bg-teal-900/20 dark:text-teal-400 border border-teal-100 dark:border-teal-900/50">
                                            <i class="bx bx-check-circle text-sm"></i> Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 border border-red-100 dark:border-red-900/50">
                                            <i class="bx bx-x-circle text-sm"></i> Inactivo
                                        </span>
                                    @endif
                                @endcan

                                <p class="block font-bold text-gray-900 dark:text-white text-lg">
                                    {{ $item->pregunta }}
                                </p>
                            </div>
                            <div class="mt-4">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1">Palabras Clave</p>
                                <p class="text-sm font-medium text-gray-700 dark:text-neutral-300 bg-gray-50 dark:bg-neutral-800/50 px-3 py-2 rounded-lg border border-gray-100 dark:border-neutral-700/50 inline-block">{{ $item->palabras_clave }}</p>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1">Respuesta</p>
                            <div class="text-sm font-medium text-gray-600 dark:text-neutral-300 bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/30 p-3 rounded-lg max-h-36 overflow-y-auto leading-relaxed custom-scrollbar">
                                {!! nl2br(e($item->respuesta)) !!}
                            </div>
                        </div>

                    </div>

                    {{-- ACCIONES --}}
                    <div class="absolute top-5 right-5 flex flex-col sm:flex-row gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-300">
                        @can('chatbot_conocimiento.editar')
                            <button type="button" 
                                @click="abrirEditar({{ $item->id }})"
                                wire:loading.attr="disabled"
                                class="text-gray-500 hover:text-teal-600 transition-all bg-gray-50 hover:bg-teal-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-teal-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-teal-900/30 dark:hover:border-teal-800/50 shadow-sm disabled:opacity-50"
                                title="Editar Registro">
                                <i class="bx bx-edit text-xl" wire:loading.remove wire:target="openEditModal({{ $item->id }})"></i>
                                <i class="bx bx-loader-alt bx-spin text-lg text-teal-600" wire:loading wire:target="openEditModal({{ $item->id }})"></i>
                            </button>
                        @endcan
                        
                        @can('chatbot_conocimiento.eliminar')
                            <button type="button" 
                                @click="abrirEliminar({{ $item->id }})"
                                wire:loading.attr="disabled"
                                class="text-gray-500 hover:text-red-600 transition-all bg-gray-50 hover:bg-red-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-red-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 dark:hover:border-red-800/50 shadow-sm disabled:opacity-50"
                                title="Eliminar Registro">
                                <i class="bx bx-trash text-xl" wire:loading.remove wire:target="confirmDelete({{ $item->id }})"></i>
                                <i class="bx bx-loader-alt bx-spin text-lg text-red-600" wire:loading wire:target="confirmDelete({{ $item->id }})"></i>
                            </button>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="p-16 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 rounded-2xl">
                    <div class="size-20 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-5 shadow-sm border border-gray-100 dark:border-neutral-700">
                        <i class="bx bx-bot text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No se encontraron conocimientos</h3>
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">
                        @if($search)
                            No hay resultados para "{{ $search }}".
                        @else
                            No hay conocimientos registrados en la base de datos.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $conocimientos->links() }}
        </div>
    </x-section>

    {{-- MODAL CREAR / EDITAR REACTIVO (Alpine x-show instantáneo) --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-[70] overflow-y-auto overflow-x-hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700 animate-modal">
            
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0 text-teal-600 dark:text-teal-400">
                        <i class="bx bx-brain text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $editingId ? 'Editar Conocimiento' : 'Nuevo Conocimiento' }}
                    </h3>
                </div>
                <button type="button" @click="cerrar" class="inline-flex size-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-600 transition-colors">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>
            
            {{-- LOADER MIENTRAS CARGA DATOS DE EDICIÓN --}}
            <div wire:loading.flex wire:target="openEditModal, openCreateModal" class="p-8 items-center justify-center gap-3 text-teal-600 dark:text-teal-400">
                <i class="bx bx-loader-alt bx-spin text-2xl"></i>
                <span class="text-sm font-semibold">Cargando conocimiento...</span>
            </div>

            <form wire:submit="save" wire:loading.remove wire:target="openEditModal, openCreateModal">
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">Pregunta / Título</label>
                        <input type="text" wire:model="pregunta" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" placeholder="Ej: Requisitos Pensión Vejez">
                        @error('pregunta') <span class="text-xs text-red-500 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">Palabras Clave <span class="text-xs font-normal text-gray-500 ml-1">(separadas por comas)</span></label>
                        <input type="text" wire:model="palabras_clave" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" placeholder="Ej: pension, vejez, requisitos">
                        @error('palabras_clave') <span class="text-xs text-red-500 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">Respuesta</label>
                        <textarea wire:model="respuesta" rows="5" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm custom-scrollbar" placeholder="El mensaje que enviará el bot..."></textarea>
                        @error('respuesta') <span class="text-xs text-red-500 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center pt-2">
                        <label class="flex items-center cursor-pointer relative bg-gray-50 dark:bg-neutral-800/50 border border-gray-100 dark:border-neutral-700 px-4 py-2.5 rounded-xl w-full">
                            <input type="checkbox" wire:model="activo" class="rounded text-teal-600 focus:ring-teal-500 h-5 w-5 border-gray-300">
                            <span class="ml-3 text-sm font-bold text-gray-700 dark:text-neutral-300">Activar este conocimiento</span>
                        </label>
                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-x-3 border-t px-6 py-4 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800/50">
                    <button type="button" @click="cerrar" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:bg-neutral-900 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" wire:loading.attr="disabled" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2">
                        <span wire:loading.remove wire:target="save">
                            <i class="bx bx-save text-lg"></i> Guardar
                        </span>
                        <span wire:loading wire:target="save">
                            <i class="bx bx-loader-alt bx-spin text-lg"></i> Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL ELIMINAR REACTIVO (Alpine x-show instantáneo) --}}
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-[80] overflow-y-auto overflow-x-hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 animate-modal">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="size-14 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0 border border-red-200 dark:border-red-800/50">
                        <i class="bx bx-trash text-3xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Eliminar Conocimiento</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl p-4 border border-gray-100 dark:border-neutral-700/50">
                    <p class="text-sm font-medium text-gray-700 dark:text-neutral-300">¿Confirmas que deseas eliminar permanentemente:</p>
                    <div wire:loading wire:target="confirmDelete" class="py-2 text-red-500 flex items-center gap-2 text-xs font-semibold">
                        <i class="bx bx-loader-alt bx-spin"></i> Cargando...
                    </div>
                    <strong wire:loading.remove wire:target="confirmDelete" class="text-gray-900 dark:text-white mt-1 block">"{{ $deletingPregunta ?: '...' }}"</strong>
                </div>
            </div>
            
            <div class="flex gap-3 justify-end bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                <button type="button" @click="cerrarEliminar"
                    class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                    Cancelar
                </button>
                <button type="button" wire:click="delete" wire:loading.attr="disabled"
                    class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2">
                    <span wire:loading.remove wire:target="delete">
                        <i class="bx bx-trash text-lg"></i> Eliminar
                    </span>
                    <span wire:loading wire:target="delete">
                        <i class="bx bx-loader-alt bx-spin text-lg"></i> Eliminando...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script nonce="{{ app('csp-nonce') }}">
(function() {
    function initChatbotConocimiento() {
        if (window.Alpine && typeof window.Alpine.data === 'function') {
            window.Alpine.data('chatbotConocimientoData', (inicialOpen = false) => ({
                modalOpen: Boolean(inicialOpen),
                deleteModalOpen: false,
                abrirCrear() {
                    this.modalOpen = true;
                    if (this.$wire) this.$wire.openCreateModal();
                },
                abrirEditar(id) {
                    this.modalOpen = true;
                    if (this.$wire) this.$wire.openEditModal(id);
                },
                cerrar() {
                    this.modalOpen = false;
                },
                abrirEliminar(id) {
                    this.deleteModalOpen = true;
                    if (this.$wire) this.$wire.confirmDelete(id);
                },
                cerrarEliminar() {
                    this.deleteModalOpen = false;
                },
                cerrarTodo() {
                    this.modalOpen = false;
                    this.deleteModalOpen = false;
                }
            }));
        }
    }
    initChatbotConocimiento();
    document.addEventListener('alpine:init', initChatbotConocimiento);
    document.addEventListener('livewire:navigated', initChatbotConocimiento);
})();
</script>
