<div x-data="carruselData"
     x-on:close-modal.window="cerrarEliminar"
     x-on:keydown.escape.window="cerrarEliminar">
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
            <div>
                <x-titulo titulo="Gestionar Carrusel" class="text-gradient font-extrabold text-3xl" />
                <x-breadcrumb class="mt-2">
                    <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                        Panel
                    </x-breadcrumb.item>
                    <x-breadcrumb.current>
                        Carrusel
                    </x-breadcrumb.current>
                </x-breadcrumb>
            </div>
        </div>

        {{-- FLASH MESSAGES --}}
        @if (session()->has('success'))
            <div class="bg-teal-50 border border-teal-200 text-teal-800 dark:bg-teal-900/30 dark:border-teal-800 dark:text-teal-200 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="bx bx-check-circle text-xl text-teal-600 dark:text-teal-400"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-teal-500 hover:text-teal-700">
                    <i class="bx bx-x text-lg"></i>
                </button>
            </div>
        @endif

        {{-- VELOCIDAD DEL CARRUSEL --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 p-6 mb-8 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-indigo-500 to-purple-500"></div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 ml-2">
                <div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                        <i class="bx bx-timer text-indigo-500 text-xl"></i> Velocidad del Carrusel
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1.5 font-medium">Ajusta el tiempo que dura cada imagen en pantalla antes de pasar a la siguiente.</p>
                </div>
                <form wire:submit="guardarVelocidad" class="flex items-center gap-3 w-full md:w-auto">
                    <div class="flex-grow md:w-64">
                        <select wire:model="intervalo" class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                            <option value="2000">2 Segundos (Rápido)</option>
                            <option value="3000">3 Segundos</option>
                            <option value="5000">5 Segundos (Normal)</option>
                            <option value="8000">8 Segundos (Lento)</option>
                            <option value="12000">12 Segundos</option>
                        </select>
                    </div>
                    <button type="submit" wire:loading.attr="disabled" class="py-2.5 px-5 shrink-0 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-gray-800 text-white hover:bg-gray-900 shadow-md hover:shadow-lg transition-all dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100 disabled:opacity-50">
                        <span wire:loading.remove wire:target="guardarVelocidad">Guardar</span>
                        <span wire:loading wire:target="guardarVelocidad"><i class="bx bx-loader-alt bx-spin"></i> Guardando...</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- LISTADO DE IMÁGENES DEL CARRUSEL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($carruseles as $carrusel)
                <div class="bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden flex flex-col group/card border border-gray-100 dark:border-neutral-700 shadow-sm hover:shadow-xl hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300 relative" wire:key="carrusel-{{ $carrusel->id }}">
                    <div class="relative h-48 w-full bg-gray-50 dark:bg-neutral-900/50 overflow-hidden">
                        <img src="{{ asset('storage/' . $carrusel->imagen_ruta) }}" alt="Carrusel" class="w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-105">
                        
                        {{-- BOTONES ACCIÓN (Hover) --}}
                        <div class="absolute top-3 right-3 opacity-100 sm:opacity-0 sm:group-hover/card:opacity-100 transition-opacity duration-300 flex gap-2">
                            @can('carrusel.editar')
                                <button type="button" wire:click="startEdit({{ $carrusel->id }})" wire:loading.attr="disabled" class="bg-white/90 dark:bg-neutral-800/90 text-indigo-600 dark:text-indigo-400 w-10 h-10 rounded-xl flex items-center justify-center hover:bg-indigo-600 hover:text-white shadow-lg backdrop-blur-sm transition-all" title="Editar detalles">
                                    <i class="bx bx-pencil text-lg" wire:loading.remove wire:target="startEdit({{ $carrusel->id }})"></i>
                                    <i class="bx bx-loader-alt bx-spin text-lg" wire:loading wire:target="startEdit({{ $carrusel->id }})"></i>
                                </button>
                            @endcan
                            @can('carrusel.eliminar')
                                <button type="button" @click="abrirEliminar({{ $carrusel->id }})" wire:loading.attr="disabled" class="bg-white/90 dark:bg-neutral-800/90 text-red-600 dark:text-red-400 w-10 h-10 rounded-xl flex items-center justify-center hover:bg-red-600 hover:text-white shadow-lg backdrop-blur-sm transition-all" title="Eliminar del carrusel">
                                    <i class="bx bx-trash text-lg" wire:loading.remove wire:target="confirmDelete({{ $carrusel->id }})"></i>
                                    <i class="bx bx-loader-alt bx-spin text-lg" wire:loading wire:target="confirmDelete({{ $carrusel->id }})"></i>
                                </button>
                            @endcan
                        </div>
                    </div>

                    <div class="p-5 flex-grow flex flex-col bg-white dark:bg-neutral-800">
                        @if($editingId === $carrusel->id)
                            {{-- FORMULARIO DE EDICIÓN INLINE --}}
                            <form wire:submit="guardarEdicion" class="space-y-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 dark:text-neutral-300 mb-1">Título</label>
                                    <input type="text" wire:model="editTitulo" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-xs focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300" placeholder="Título de la imagen...">
                                    @error('editTitulo') <p class="text-[10px] text-red-500 mt-0.5">{{ $message }}</p> @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 dark:text-neutral-300 mb-1">Orden</label>
                                        <input type="number" wire:model="editOrden" min="0" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-xs focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                                        @error('editOrden') <p class="text-[10px] text-red-500 mt-0.5">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 dark:text-neutral-300 mb-1">Enlace</label>
                                        <input type="url" wire:model="editEnlace" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-xs focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300" placeholder="https://...">
                                        @error('editEnlace') <p class="text-[10px] text-red-500 mt-0.5">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 pt-2">
                                    <button type="button" wire:click="cancelEdit" class="py-1.5 px-3 text-xs font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">Cancelar</button>
                                    <button type="submit" wire:loading.attr="disabled" class="py-1.5 px-3 text-xs font-bold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50">
                                        <span wire:loading.remove wire:target="guardarEdicion">Guardar</span>
                                        <span wire:loading wire:target="guardarEdicion"><i class="bx bx-loader-alt bx-spin"></i> Guardando...</span>
                                    </button>
                                </div>
                            </form>
                        @else
                            {{-- VISTA DE LECTURA --}}
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-2.5 py-1 rounded-md dark:bg-indigo-900/40 dark:text-indigo-300 w-fit shrink-0 flex items-center gap-1">
                                        <i class="bx bx-sort-alt-2"></i> Orden: {{ $carrusel->orden }}
                                    </span>
                                    @if($carrusel->enlace)
                                        <span class="truncate text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-md flex items-center">
                                            <i class="bx bx-link-external mr-1"></i> {{ $carrusel->enlace }}
                                        </span>
                                    @else
                                        <span class="truncate text-xs font-medium text-gray-400 dark:text-neutral-500 flex items-center">
                                            <i class="bx bx-unlink mr-1"></i> Sin enlace
                                        </span>
                                    @endif
                                </div>
                                <h3 class="font-bold text-gray-800 dark:text-neutral-200 text-base line-clamp-1">
                                    {{ $carrusel->titulo ?: 'Imagen sin título' }}
                                </h3>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700 rounded-2xl bg-gray-50/50">
                    <i class="bx bx-slideshow text-5xl text-gray-400 mb-3"></i>
                    <p class="text-base font-bold text-gray-800 dark:text-white mb-1">No hay elementos en el carrusel</p>
                    <p class="text-xs text-gray-500">Agrega noticias marcadas para destacar en el carrusel o sube imágenes.</p>
                </div>
            @endforelse
        </div>
    </x-section>

    {{-- MODAL DELETE (INSTANTÁNEO) --}}
    <div x-show="deleteModalOpen"
         x-cloak
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrarEliminar"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 p-6 animate-modal">
            <div class="flex items-center gap-4 mb-4">
                <div class="size-12 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600">
                    <i class="bx bx-trash text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-lg">Eliminar Imagen</h4>
                    <p class="text-xs text-gray-500">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-6">
                ¿Confirmas que deseas eliminar esta imagen del carrusel principal?
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" @click="cerrarEliminar" class="py-2 px-4 text-xs font-bold rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50">Cancelar</button>
                <button type="button" wire:click="delete" wire:loading.attr="disabled" class="py-2 px-4 text-xs font-bold rounded-xl bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 inline-flex items-center gap-2">
                    <span wire:loading.remove wire:target="delete">Eliminar</span>
                    <span wire:loading wire:target="delete"><i class="bx bx-loader-alt bx-spin"></i> Eliminando...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script nonce="{{ app('csp-nonce') }}">
(function() {
    function initCarrusel() {
        if (window.Alpine && typeof window.Alpine.data === 'function') {
            window.Alpine.data('carruselData', () => ({
                deleteModalOpen: false,
                abrirEliminar(id) {
                    this.deleteModalOpen = true;
                    if (this.$wire) this.$wire.confirmDelete(id);
                },
                cerrarEliminar() {
                    this.deleteModalOpen = false;
                }
            }));
        }
    }
    initCarrusel();
    document.addEventListener('alpine:init', initCarrusel);
    document.addEventListener('livewire:navigated', initCarrusel);
})();
</script>
