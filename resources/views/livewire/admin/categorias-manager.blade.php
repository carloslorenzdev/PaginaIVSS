<div x-data="categoriasData"
     x-on:close-modal.window="cerrarTodo"
     x-on:keydown.escape.window="cerrarTodo">
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Categorías de Noticias" class="text-gradient font-extrabold text-3xl" />
            
            @can('categorias.crear')
                <button type="button"
                    @click="abrirCrear"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all transform hover:-translate-y-0.5 disabled:opacity-50">
                    <i class="bx bx-plus text-lg" wire:loading.remove wire:target="openCreateModal"></i>
                    <i class="bx bx-loader-alt bx-spin text-lg" wire:loading wire:target="openCreateModal"></i>
                    <span>Nueva Categoría</span>
                </button>
            @endcan
        </div>

        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Categorías
            </x-breadcrumb.current>
        </x-breadcrumb>

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

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 dark:bg-red-900/20 dark:border-red-900/50 shadow-sm flex items-center justify-between" role="alert">
                <div class="flex items-center gap-3">
                    <i class="bx bx-error-circle text-red-600 dark:text-red-400 text-xl"></i>
                    <span class="text-sm font-bold text-red-800 dark:text-red-300">{{ session('error') }}</span>
                </div>
                <button type="button" wire:click="$refresh" class="text-red-500 hover:text-red-700">
                    <i class="bx bx-x text-lg"></i>
                </button>
            </div>
        @endif

        <!-- Barra de Búsqueda -->
        <div class="bg-white dark:bg-neutral-800/80 p-4 rounded-xl border border-gray-100 dark:border-neutral-700 shadow-sm flex items-center gap-4">
            <div class="relative flex-1">
                <i class="bx bx-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" wire:loading.remove wire:target="search"></i>
                <div class="spinner-border spinner-border-sm text-teal-500 absolute left-3.5 top-1/2 -translate-y-1/2" wire:loading wire:target="search"></div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Buscar categoría por nombre o descripción..." 
                       class="py-2.5 pl-10 pr-10 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-xs">
                @if($search)
                    <button wire:click="$set('search', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="bx bx-x text-lg"></i>
                    </button>
                @endif
            </div>
        </div>

        <!-- Grid de Categorías -->
        <div class="bg-white dark:bg-neutral-800/80 rounded-2xl border border-gray-100 dark:border-neutral-700 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-neutral-700 flex justify-between items-center bg-gray-50/50 dark:bg-neutral-800/50">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-neutral-400">
                    Total Categorías: {{ $categorias->total() }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 p-6">
                @forelse($categorias as $cat)
                    <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700 rounded-2xl p-5 hover:shadow-md transition-all duration-300 flex flex-col justify-between group relative overflow-hidden" wire:key="cat-{{ $cat->id }}">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-xl bg-teal-50 text-teal-600 dark:bg-teal-900/30 dark:text-teal-400 flex items-center justify-center font-bold text-lg border border-teal-100 dark:border-teal-900/50">
                                        {{ substr($cat->nombre, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white text-base leading-tight">
                                            {{ $cat->nombre }}
                                        </h3>
                                        <span class="text-xs text-gray-400 font-mono">/{{ $cat->slug }}</span>
                                    </div>
                                </div>
                                
                                <span class="size-2 rounded-full {{ $cat->activa ? 'bg-emerald-500 ring-4 ring-emerald-50' : 'bg-gray-300 dark:bg-neutral-600' }}" title="{{ $cat->activa ? 'Activa' : 'Inactiva' }}"></span>
                            </div>

                            @if($cat->descripcion)
                                <p class="text-xs text-gray-500 dark:text-neutral-400 line-clamp-2 leading-relaxed">
                                    {{ $cat->descripcion }}
                                </p>
                            @else
                                <p class="text-xs text-gray-400 italic">Sin descripción registrada.</p>
                            @endif
                        </div>

                        <div class="pt-4 mt-4 border-t border-gray-100 dark:border-neutral-700/60 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-neutral-700 dark:text-neutral-300" title="Orden">
                                    <i class="bx bx-sort-alt-2"></i> {{ $cat->orden }}
                                </span>
                                
                                <button type="button" wire:click="toggleActiva({{ $cat->id }})" class="inline-flex items-center gap-1 py-0.5 px-2 rounded-md text-xs font-semibold {{ $cat->activa ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 dark:bg-neutral-700 dark:text-neutral-400' }}">
                                    {{ $cat->activa ? 'Activa' : 'Inactiva' }}
                                </button>
                            </div>

                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-1">
                                    <span class="inline-flex items-center gap-1 py-1 px-2.5 rounded-lg text-xs font-bold bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400" title="Noticias asociadas">
                                        <i class="bx bx-news text-sm"></i> {{ $cat->noticias_count }}
                                    </span>
                                </div>

                                {{-- ACCIONES --}}
                                <div class="flex items-center gap-2">
                                    @can('categorias.editar')
                                        <button type="button" 
                                            @click="abrirEditar({{ $cat->id }})"
                                            wire:loading.attr="disabled"
                                            class="text-gray-500 hover:text-teal-600 transition-all bg-gray-50 hover:bg-teal-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-teal-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-teal-900/30 dark:hover:border-teal-800/50 shadow-sm"
                                            title="Editar Categoría">
                                            <i class="bx bx-edit text-xl" wire:loading.remove wire:target="openEditModal({{ $cat->id }})"></i>
                                            <i class="bx bx-loader-alt bx-spin text-xl text-teal-600" wire:loading wire:target="openEditModal({{ $cat->id }})"></i>
                                        </button>
                                    @endcan
                                    
                                    @can('categorias.eliminar')
                                        <button type="button" 
                                            @click="abrirEliminar({{ $cat->id }})"
                                            wire:loading.attr="disabled"
                                            class="text-gray-500 hover:text-red-600 transition-all bg-gray-50 hover:bg-red-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-red-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 dark:hover:border-red-800/50 shadow-sm"
                                            title="Eliminar Categoría">
                                            <i class="bx bx-trash text-xl" wire:loading.remove wire:target="confirmDelete({{ $cat->id }})"></i>
                                            <i class="bx bx-loader-alt bx-spin text-xl text-red-600" wire:loading wire:target="confirmDelete({{ $cat->id }})"></i>
                                        </button>
                                    @endcan
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 rounded-2xl">
                        <div class="size-16 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4 shadow-sm border border-gray-100 dark:border-neutral-700">
                            <i class="bx bx-category text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">No se encontraron categorías</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">
                            @if($search) No hay coincidencias para "{{ $search }}". @else No hay categorías registradas en el sistema. @endif
                        </p>
                    </div>
                @endforelse
            </div>
            
            <div class="p-5 border-t border-gray-100 dark:border-neutral-700 bg-gray-50/30 dark:bg-neutral-800/30">
                {{ $categorias->links() }}
            </div>
        </div>
    </x-section>

    {{-- MODAL CREAR / EDITAR (INSTANTÁNEO) --}}
    <div x-show="modalOpen"
         x-cloak
         class="fixed inset-0 z-[70] overflow-y-auto overflow-x-hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrar"></div>
        <div class="relative w-full max-w-lg transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700 animate-modal z-10">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0 text-teal-600 dark:text-teal-400">
                        <i class="bx bx-category text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $editingId ? 'Editar Categoría' : 'Nueva Categoría' }}
                    </h3>
                </div>
                <button type="button" @click="cerrar" class="inline-flex size-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-600 transition-colors">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>

            {{-- LOADER MIENTRAS CARGA DATOS DE EDICIÓN --}}
            <div wire:loading.flex wire:target="openEditModal" class="p-8 items-center justify-center gap-3 text-teal-600 dark:text-teal-400">
                <i class="bx bx-loader-alt bx-spin text-2xl"></i>
                <span class="text-sm font-semibold">Cargando categoría...</span>
            </div>

            <form wire:submit="save" wire:loading.remove wire:target="openEditModal">
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">Nombre de la Categoría</label>
                        <input type="text" wire:model="nombre" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" placeholder="Ej: Salud, Institucional, Operativos...">
                        @error('nombre') <span class="text-xs text-red-500 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">Descripción (Opcional)</label>
                        <textarea wire:model="descripcion" rows="3" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" placeholder="Breve descripción..."></textarea>
                        @error('descripcion') <span class="text-xs text-red-500 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">Orden de Visualización</label>
                            <input type="number" wire:model="orden" min="0" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm">
                            @error('orden') <span class="text-xs text-red-500 mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center pt-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="activa" class="rounded text-teal-600 focus:ring-teal-500 h-5 w-5 border-gray-300">
                                <span class="ml-3 text-sm font-bold text-gray-700 dark:text-neutral-300">Activa</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-x-3 border-t px-6 py-4 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800/50">
                    <button type="button" @click="cerrar" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:bg-neutral-900 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" wire:loading.attr="disabled" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2 disabled:opacity-50">
                        <span wire:loading.remove wire:target="save">
                            <i class="bx bx-save text-lg"></i> {{ $editingId ? 'Actualizar' : 'Guardar' }}
                        </span>
                        <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                            <i class="bx bx-loader-alt bx-spin text-lg"></i> Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL ELIMINAR (INSTANTÁNEO) --}}
    <div x-show="deleteModalOpen"
         x-cloak
         class="fixed inset-0 z-[80] overflow-y-auto overflow-x-hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrarEliminar"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 animate-modal z-10">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="size-14 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0 border border-red-200 dark:border-red-800/50">
                        <i class="bx bx-trash text-3xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Eliminar Categoría</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl p-4 border border-gray-100 dark:border-neutral-700/50">
                    <div wire:loading.flex wire:target="confirmDelete" class="items-center justify-center py-4">
                        <i class="bx bx-loader-alt bx-spin text-2xl text-red-600"></i>
                    </div>
                    <div wire:loading.remove wire:target="confirmDelete">
                        @if($deletingNoticiasCount > 0)
                            <p class="text-sm font-bold text-red-600 dark:text-red-400">
                                <i class="bx bx-error-circle mr-1"></i> No se puede eliminar: Esta categoría tiene {{ $deletingNoticiasCount }} noticias asociadas.
                            </p>
                        @else
                            <p class="text-sm font-medium text-gray-700 dark:text-neutral-300">
                                ¿Confirmas que deseas eliminar permanentemente la categoría <strong>"{{ $deletingNombre ?: 'esta categoría' }}"</strong>?
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3 justify-end bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                <button type="button" @click="cerrarEliminar"
                    class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                    Cancelar
                </button>
                @if($deletingNoticiasCount === 0)
                    <button type="button" wire:click="delete" wire:loading.attr="disabled"
                        class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2 disabled:opacity-50">
                        <span wire:loading.remove wire:target="delete">
                            <i class="bx bx-trash text-lg"></i> Eliminar
                        </span>
                        <span wire:loading wire:target="delete">
                            <i class="bx bx-loader-alt bx-spin text-lg"></i> Eliminando...
                        </span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPT ALPINE Y REGISTRO COMPONENTE --}}
    <script nonce="{{ app('csp-nonce') }}">
    (function() {
        function initCategorias() {
            if (window.Alpine && typeof window.Alpine.data === 'function') {
                window.Alpine.data('categoriasData', () => ({
                    modalOpen: false,
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
        initCategorias();
        document.addEventListener('alpine:init', initCategorias);
        document.addEventListener('livewire:navigated', initCategorias);
    })();
    </script>
</div>
