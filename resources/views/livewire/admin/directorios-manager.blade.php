<div x-data="directoriosData"
     x-on:close-modal.window="cerrarTodo"
     x-on:keydown.escape.window="cerrarTodo">
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="{{ $titulo }}" class="text-gradient font-extrabold text-3xl" />
            
            @can('directorios.crear')
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

        {{-- FILTERS / SEARCH --}}
        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-4 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2 relative">
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Buscar por nombre, dirección o teléfono..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200">
                    <i class="bx bx-search absolute left-3.5 top-3 text-lg text-gray-400"></i>
                </div>
                <div>
                    <select wire:model.live="filtroEstado"
                        class="w-full py-2.5 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200">
                        <option value="">Todos los Estados</option>
                        @foreach($estadosList as $est)
                            <option value="{{ $est->estado }}">{{ $est->estado }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- SKELETON PLACEHOLDERS --}}
        <div wire:loading wire:target="search, filtroEstado, gotoPage, previousPage, nextPage">
            <x-skeleton.list :count="5" />
        </div>

        {{-- LISTADO EN TARJETAS --}}
        <div wire:loading.remove wire:target="search, filtroEstado, gotoPage, previousPage, nextPage" class="space-y-4">
            @forelse($directorios as $item)
                <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 relative group" wire:key="directorio-{{ $item->id }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 pr-16">
                        
                        {{-- ESTADO, MUNICIPIO Y NOMBRE --}}
                        <div class="col-span-full lg:col-span-2">
                            <div class="flex flex-col items-start gap-2.5">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-teal-50 text-teal-700 dark:bg-teal-900/20 dark:text-teal-400 border border-teal-100 dark:border-teal-900/50">
                                        <i class="bx bx-map text-sm"></i> {{ $item->estado }}
                                    </span>
                                    @if($item->municipio)
                                        <span class="inline-flex items-center py-1 px-2 rounded-lg text-xs font-medium bg-gray-100 text-gray-700 dark:bg-neutral-800 dark:text-neutral-300">
                                            {{ $item->municipio }}
                                        </span>
                                    @endif
                                    @if($item->parroquia)
                                        <span class="text-xs text-gray-400 dark:text-neutral-500">
                                            ({{ $item->parroquia }})
                                        </span>
                                    @endif
                                </div>
                                <p class="block font-bold text-gray-900 dark:text-white text-lg">
                                    {{ $item->nombre }}
                                </p>
                            </div>
                        </div>

                        {{-- DIRECCIÓN --}}
                        <div class="col-span-full sm:col-span-1 md:col-span-2 lg:col-span-2">
                            <span class="text-xs font-semibold text-gray-400 dark:text-neutral-500 uppercase tracking-wider block mb-1">
                                Ubicación / Dirección
                            </span>
                            <p class="text-sm text-gray-600 dark:text-neutral-300 line-clamp-2">
                                {{ $item->direccion }}
                            </p>
                        </div>

                        {{-- CONTACTO Y TIPO --}}
                        <div class="col-span-full sm:col-span-1 lg:col-span-1 flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 dark:text-neutral-500 uppercase tracking-wider block mb-1">
                                    Contacto
                                </span>
                                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200">
                                    {{ $item->telefono ?: 'Sin teléfono' }}
                                </p>
                            </div>
                        </div>

                    </div>

                    {{-- ACCIONES --}}
                    <div class="absolute top-5 right-5 flex flex-col sm:flex-row gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-300">
                        @can('directorios.editar')
                            <button type="button" 
                                @click="abrirEditar({{ $item->id }})"
                                wire:loading.attr="disabled"
                                class="text-gray-500 hover:text-teal-600 transition-all bg-gray-50 hover:bg-teal-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-teal-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-teal-900/30 dark:hover:border-teal-800/50 shadow-sm"
                                title="Editar Registro">
                                <i class="bx bx-edit text-xl" wire:loading.remove wire:target="openEditModal({{ $item->id }})"></i>
                                <i class="bx bx-loader-alt bx-spin text-xl text-teal-600" wire:loading wire:target="openEditModal({{ $item->id }})"></i>
                            </button>
                        @endcan
                        
                        @can('directorios.eliminar')
                            <button type="button" 
                                @click="abrirEliminar({{ $item->id }})"
                                wire:loading.attr="disabled"
                                class="text-gray-500 hover:text-red-600 transition-all bg-gray-50 hover:bg-red-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-red-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 dark:hover:border-red-800/50 shadow-sm"
                                title="Eliminar Registro">
                                <i class="bx bx-trash text-xl" wire:loading.remove wire:target="confirmDelete({{ $item->id }})"></i>
                                <i class="bx bx-loader-alt bx-spin text-xl text-red-600" wire:loading wire:target="confirmDelete({{ $item->id }})"></i>
                            </button>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="p-16 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 rounded-2xl">
                    <div class="size-20 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-5 shadow-sm border border-gray-100 dark:border-neutral-700">
                        <i class="bx bx-search text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No hay registros</h3>
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">No se han encontrado registros para este directorio.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $directorios->links() }}
        </div>
    </x-section>

    {{-- MODAL CREATE/EDIT (INSTANTÁNEO) --}}
    <div x-show="modalOpen"
         x-cloak
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrar"></div>
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl dark:bg-neutral-800 overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 animate-modal">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-building-house text-xl text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-xl">
                        {{ $editingId ? 'Editar Registro' : 'Nuevo Registro' }}
                    </h3>
                </div>
                <button type="button" @click="cerrar" class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-neutral-700 text-gray-500 hover:bg-gray-200 hover:text-gray-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:hover:text-neutral-200 transition-colors">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>

            {{-- SPINNER AL CARGAR EDICIÓN --}}
            <div wire:loading.flex wire:target="openEditModal" class="items-center justify-center p-12">
                <div class="flex flex-col items-center gap-3">
                    <i class="bx bx-loader-alt bx-spin text-3xl text-teal-600"></i>
                    <span class="text-xs text-gray-500 font-medium">Cargando datos del registro...</span>
                </div>
            </div>

            <form wire:submit="save" wire:loading.remove wire:target="openEditModal">
                <div class="space-y-5 p-6">
                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Tipo <span class="text-red-500">*</span></label>
                        <select wire:model="tipo" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm">
                            <option value="centro_salud">Centro de Salud</option>
                            <option value="farmacia">Farmacia</option>
                            <option value="oficina_administrativa">Oficina Administrativa</option>
                        </select>
                        @error('tipo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Estado <span class="text-red-500">*</span></label>
                            <select wire:model.live="id_estado" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm">
                                <option value="">Seleccione estado...</option>
                                @foreach($estadosList as $est)
                                    <option value="{{ $est->idestado }}">{{ $est->estado }}</option>
                                @endforeach
                            </select>
                            @error('id_estado') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300 flex items-center justify-between">
                                <span>Municipio</span>
                                <span wire:loading wire:target="id_estado" class="text-xs text-teal-600 flex items-center gap-1 font-normal">
                                    <i class="bx bx-loader-alt bx-spin"></i>
                                </span>
                            </label>
                            <select wire:model.live="id_municipio"
                                    wire:loading.attr="disabled"
                                    wire:target="id_estado"
                                    {{ empty($municipios) || count($municipios) === 0 ? 'disabled' : '' }}
                                    class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm disabled:opacity-50">
                                <option value="">{{ empty($municipios) || count($municipios) === 0 ? 'Elija un estado...' : 'Seleccione municipio...' }}</option>
                                @foreach($municipios as $mun)
                                    <option value="{{ $mun['idmunicipio'] }}">{{ $mun['municipio'] }}</option>
                                @endforeach
                            </select>
                            @error('id_municipio') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300 flex items-center justify-between">
                                <span>Parroquia</span>
                                <span wire:loading wire:target="id_municipio" class="text-xs text-teal-600 flex items-center gap-1 font-normal">
                                    <i class="bx bx-loader-alt bx-spin"></i>
                                </span>
                            </label>
                            <select wire:model.live="id_parroquia"
                                    wire:loading.attr="disabled"
                                    wire:target="id_municipio"
                                    {{ empty($parroquias) || count($parroquias) === 0 ? 'disabled' : '' }}
                                    class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm disabled:opacity-50">
                                <option value="">{{ empty($parroquias) || count($parroquias) === 0 ? 'Elija municipio...' : 'Seleccione parroquia...' }}</option>
                                @foreach($parroquias as $parr)
                                    <option value="{{ $parr['idparroquia'] }}">{{ $parr['parroquia'] }}</option>
                                @endforeach
                            </select>
                            @error('id_parroquia') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nombre" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm">
                        @error('nombre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Dirección <span class="text-red-500">*</span></label>
                        <textarea wire:model="direccion" rows="3" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm"></textarea>
                        @error('direccion') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Teléfono (Opcional)</label>
                        <input type="text" wire:model="telefono" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm">
                        @error('telefono') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 px-6 py-4">
                    <button type="button" @click="cerrar" class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" wire:loading.attr="disabled" wire:target="save" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2 disabled:opacity-50">
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
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrarEliminar"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 animate-modal">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="size-14 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0 border border-red-200 dark:border-red-800/50">
                        <i class="bx bx-trash text-3xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Eliminar Registro</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-neutral-900/50 p-4 rounded-xl border border-gray-100 dark:border-neutral-700">
                    <div wire:loading.flex wire:target="confirmDelete" class="items-center justify-center py-2">
                        <i class="bx bx-loader-alt bx-spin text-2xl text-red-600"></i>
                    </div>
                    <div wire:loading.remove wire:target="confirmDelete">
                        <p class="text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">¿Confirmas que deseas eliminar permanentemente el registro:</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white italic">"{{ $deletingNombre ?: 'este registro' }}"</p>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3 justify-end bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                <button type="button" @click="cerrarEliminar"
                    class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                    Cancelar
                </button>
                <button type="button" wire:click="delete" wire:loading.attr="disabled" wire:target="delete"
                    class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove wire:target="delete">
                        <i class="bx bx-trash text-lg"></i> Eliminar
                    </span>
                    <span wire:loading wire:target="delete" class="inline-flex items-center gap-2">
                        <i class="bx bx-loader-alt bx-spin text-lg"></i> Eliminando...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script nonce="{{ app('csp-nonce') }}">
(function() {
    function initDirectorios() {
        if (window.Alpine && typeof window.Alpine.data === 'function') {
            window.Alpine.data('directoriosData', () => ({
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
    initDirectorios();
    document.addEventListener('alpine:init', initDirectorios);
    document.addEventListener('livewire:navigated', initDirectorios);
})();
</script>
