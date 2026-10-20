<div x-data="revistasData"
     x-on:close-modal.window="cerrarTodo"
     x-on:keydown.escape.window="cerrarTodo">
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
            <div>
                <x-titulo titulo="Revistas Digitales" class="text-gradient font-extrabold text-3xl" />
                <x-breadcrumb class="mt-2">
                    <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                        Panel
                    </x-breadcrumb.item>
                    <x-breadcrumb.current>
                        Revistas Digitales
                    </x-breadcrumb.current>
                </x-breadcrumb>
            </div>
            
            @can('revistas.crear')
                <button type="button"
                    @click="abrirCrear"
                    wire:loading.attr="disabled"
                    class="rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white hover:from-teal-700 hover:to-teal-600 shadow-md hover:shadow-lg shadow-teal-500/30 hover:-translate-y-0.5 transition-all duration-300 font-semibold px-5 py-2.5 flex items-center gap-2 disabled:opacity-50">
                    <i class="bx bx-upload text-lg" wire:loading.remove wire:target="openCreateModal"></i>
                    <i class="bx bx-loader-alt bx-spin text-lg" wire:loading wire:target="openCreateModal"></i>
                    <span>Subir Revista</span>
                </button>
            @endcan
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

        {{-- SEARCH BAR --}}
        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-4 shadow-sm">
            <div class="relative">
                <input type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar revista por título, edición o descripción..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200">
                <i class="bx bx-search absolute left-3.5 top-3 text-lg text-gray-400"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-neutral-700 p-5 bg-gray-50/50 dark:bg-neutral-800/50">
                <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-teal-100 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center">
                        <i class="bx bx-book-open text-lg"></i>
                    </div>
                    Listado de Revistas
                </h3>
            </div>

            <div class="p-5 space-y-4">
                @forelse($revistas as $revista)
                    <div class="bg-white dark:bg-neutral-900/40 border border-gray-100 dark:border-neutral-700/70 rounded-2xl p-4 sm:p-5 hover:shadow-md transition-all duration-300 relative group" wire:key="revista-{{ $revista->id }}">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                @if($revista->imagen_preview)
                                    <div class="size-16 sm:size-20 rounded-xl overflow-hidden border border-gray-200 dark:border-neutral-700 flex-shrink-0 bg-gray-50 dark:bg-neutral-800">
                                        <img src="{{ asset('storage/' . $revista->imagen_preview) }}" alt="Preview" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="size-16 sm:size-20 rounded-xl border border-blue-200 dark:border-blue-900/40 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                                        <i class="bx bx-book-open text-3xl"></i>
                                    </div>
                                @endif

                                <div>
                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                        <span class="inline-flex items-center gap-1 py-0.5 px-2 rounded-md text-xs font-semibold {{ $revista->publicada ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 dark:bg-neutral-700 dark:text-neutral-400' }}">
                                            <span class="size-1.5 rounded-full {{ $revista->publicada ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                            {{ $revista->publicada ? 'Publicada' : 'Borrador' }}
                                        </span>
                                        @if($revista->edicion)
                                            <span class="inline-flex items-center gap-1 py-0.5 px-2 rounded-md text-xs font-medium bg-gray-100 text-gray-700 dark:bg-neutral-800 dark:text-neutral-300">
                                                {{ $revista->edicion }}
                                            </span>
                                        @endif
                                        <span class="text-xs text-gray-400">
                                            {{ $revista->fecha_publicacion ? $revista->fecha_publicacion->format('d/m/Y') : 'Sin fecha' }}
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-gray-900 dark:text-white text-base">
                                        {{ $revista->titulo }}
                                    </h4>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                        <span class="flex items-center gap-1">
                                            <i class="bx bx-download"></i> {{ $revista->descargas ?? 0 }} descargas
                                        </span>
                                    </div>
                                    @if($revista->descripcion)
                                        <p class="text-xs text-gray-600 dark:text-neutral-300 mt-2 line-clamp-2 max-w-2xl">{{ $revista->descripcion }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-2 self-end lg:self-center">
                                @if($revista->archivo_pdf)
                                    <a href="{{ asset('storage/' . $revista->archivo_pdf) }}" target="_blank"
                                        class="p-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-colors"
                                        title="Ver PDF">
                                        <i class="bx bx-show text-lg"></i>
                                    </a>
                                @endif

                                @can('revistas.editar')
                                    <button type="button"
                                        wire:click="togglePublicacion({{ $revista->id }})"
                                        wire:loading.attr="disabled"
                                        class="p-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-colors"
                                        title="{{ $revista->publicada ? 'Ocultar' : 'Publicar' }}">
                                        <i class="bx {{ $revista->publicada ? 'bx-hide text-yellow-600' : 'bx-show text-green-600' }} text-lg" wire:loading.remove wire:target="togglePublicacion({{ $revista->id }})"></i>
                                        <i class="bx bx-loader-alt bx-spin text-lg" wire:loading wire:target="togglePublicacion({{ $revista->id }})"></i>
                                    </button>
                                    
                                    <button type="button"
                                        @click="abrirEditar({{ $revista->id }})"
                                        wire:loading.attr="disabled"
                                        class="p-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-teal-600 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700 transition-colors"
                                        title="Editar">
                                        <i class="bx bx-edit text-lg" wire:loading.remove wire:target="openEditModal({{ $revista->id }})"></i>
                                        <i class="bx bx-loader-alt bx-spin text-lg text-teal-600" wire:loading wire:target="openEditModal({{ $revista->id }})"></i>
                                    </button>
                                @endcan

                                @can('revistas.eliminar')
                                    <button type="button"
                                        @click="abrirEliminar({{ $revista->id }})"
                                        wire:loading.attr="disabled"
                                        class="p-2.5 rounded-xl border border-gray-200 bg-white hover:bg-red-50 text-red-600 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 transition-colors"
                                        title="Eliminar">
                                        <i class="bx bx-trash text-lg" wire:loading.remove wire:target="confirmDelete({{ $revista->id }})"></i>
                                        <i class="bx bx-loader-alt bx-spin text-lg text-red-600" wire:loading wire:target="confirmDelete({{ $revista->id }})"></i>
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <i class="bx bx-book-open text-5xl text-gray-300 dark:text-neutral-600 mb-3"></i>
                        <p class="text-sm font-semibold text-gray-600 dark:text-neutral-400">No se encontraron revistas registradas.</p>
                    </div>
                @endforelse
            </div>

            <div class="p-5 border-t border-gray-100 dark:border-neutral-700">
                {{ $revistas->links() }}
            </div>
        </div>
    </x-section>

    {{-- MODAL CREATE / EDIT (INSTANTÁNEO) --}}
    <div x-show="modalOpen"
         x-cloak
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrar"></div>
        <div class="relative w-full max-w-lg bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 animate-modal">
            <div class="p-6 border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-900/50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600">
                        <i class="bx bx-book-open text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ $editingId ? 'Editar Revista' : 'Subir Nueva Revista' }}
                    </h3>
                </div>
                <button type="button" @click="cerrar" class="size-8 inline-flex justify-center items-center rounded-full bg-gray-100 dark:bg-neutral-700 text-gray-600 dark:text-neutral-300 hover:bg-gray-200">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>

            {{-- SPINNER AL CARGAR EDICIÓN --}}
            <div wire:loading.flex wire:target="openEditModal" class="items-center justify-center p-12">
                <div class="flex flex-col items-center gap-3">
                    <i class="bx bx-loader-alt bx-spin text-3xl text-teal-600"></i>
                    <span class="text-xs text-gray-500 font-medium">Cargando revista...</span>
                </div>
            </div>

            <form wire:submit="save" wire:loading.remove wire:target="openEditModal">
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-1.5 text-gray-700 dark:text-neutral-300">Título de la Revista <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="titulo" class="w-full py-2.5 px-4 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200" placeholder="Ej. Revista Médica IVSS">
                        @error('titulo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1.5 text-gray-700 dark:text-neutral-300">Edición / Volumen</label>
                        <input type="text" wire:model="edicion" class="w-full py-2.5 px-4 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200" placeholder="Ej. Vol. 12 - N° 3">
                        @error('edicion') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1.5 text-gray-700 dark:text-neutral-300">Fecha de Publicación <span class="text-red-500">*</span></label>
                        <input type="date" wire:model="fecha_publicacion" class="w-full py-2.5 px-4 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200">
                        @error('fecha_publicacion') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1.5 text-gray-700 dark:text-neutral-300">
                            Archivo PDF {{ $editingId ? '(Opcional si no desea cambiarlo)' : '*' }}
                        </label>
                        <input type="file" wire:model="archivo_pdf" accept="application/pdf" class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm dark:bg-neutral-900 dark:text-neutral-300 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        <p class="text-xs text-gray-500 mt-1">Formatos admitidos: PDF (máx. 20MB)</p>
                        @error('archivo_pdf') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror

                        <div wire:loading wire:target="archivo_pdf" class="mt-2 text-xs text-teal-600 font-semibold flex items-center gap-1.5">
                            <i class="bx bx-loader-alt bx-spin"></i> Cargando archivo PDF...
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 bg-gray-50/50 dark:bg-neutral-900/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                    <button type="button" @click="cerrar" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 transition-all">Cancelar</button>
                    <button type="submit" wire:loading.attr="disabled" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg transition-all inline-flex items-center gap-2 disabled:opacity-50">
                        <span wire:loading.remove wire:target="save"><i class="bx bx-save text-lg"></i> Guardar</span>
                        <span wire:loading wire:target="save"><i class="bx bx-loader-alt bx-spin text-lg"></i> Procesando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DELETE (INSTANTÁNEO) --}}
    <div x-show="deleteModalOpen"
         x-cloak
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrarEliminar"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 animate-modal">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="size-14 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0 text-red-600">
                        <i class="bx bx-trash text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Eliminar Revista</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl p-4 border border-gray-100 dark:border-neutral-700">
                    <div wire:loading.flex wire:target="confirmDelete" class="items-center justify-center py-2">
                        <i class="bx bx-loader-alt bx-spin text-2xl text-red-600"></i>
                    </div>
                    <div wire:loading.remove wire:target="confirmDelete">
                        <p class="text-sm text-gray-700 dark:text-neutral-300 mb-1">¿Confirmas que deseas eliminar la revista:</p>
                        <p class="font-extrabold text-gray-900 dark:text-white italic">"{{ $deletingTitulo ?: 'esta revista' }}"</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 justify-end bg-gray-50/50 dark:bg-neutral-900/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                <button type="button" @click="cerrarEliminar" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 transition-all">Cancelar</button>
                <button type="button" wire:click="delete" wire:loading.attr="disabled" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg transition-all inline-flex items-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove wire:target="delete"><i class="bx bx-trash text-lg"></i> Eliminar</span>
                    <span wire:loading wire:target="delete"><i class="bx bx-loader-alt bx-spin text-lg"></i> Eliminando...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script nonce="{{ app('csp-nonce') }}">
(function() {
    function initRevistas() {
        if (window.Alpine && typeof window.Alpine.data === 'function') {
            window.Alpine.data('revistasData', () => ({
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
    initRevistas();
    document.addEventListener('alpine:init', initRevistas);
    document.addEventListener('livewire:navigated', initRevistas);
})();
</script>
