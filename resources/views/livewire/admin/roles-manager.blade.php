<div x-data="rolesData"
     x-on:close-modal.window="cerrarTodo"
     x-on:keydown.escape.window="cerrarTodo">
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Roles del Sistema" class="text-gradient font-extrabold text-3xl" />
            
            @can('roles.crear')
                <button type="button"
                    @click="abrirCrear"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all transform hover:-translate-y-0.5 disabled:opacity-50">
                    <i class="bx bx-plus text-lg" wire:loading.remove wire:target="openCreateModal"></i>
                    <i class="bx bx-loader-alt bx-spin text-lg" wire:loading wire:target="openCreateModal"></i>
                    <span>Nuevo Rol</span>
                </button>
            @endcan
        </div>

        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Roles del Sistema
            </x-breadcrumb.current>
        </x-breadcrumb>

        {{-- ALERT MESSAGES --}}
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

        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/30 dark:border-red-800 dark:text-red-200 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="bx bx-x-circle text-xl text-red-600 dark:text-red-400"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <i class="bx bx-x text-lg"></i>
                </button>
            </div>
        @endif

        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-2xl p-6 md:p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-neutral-800 pb-5">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400">
                        <i class="bx bx-shield-quarter text-xl"></i>
                    </div>
                    Listado de Roles
                </h3>
            </div>

            {{-- SKELETON PLACEHOLDERS --}}
            <div wire:loading wire:target="save, delete">
                <x-skeleton.list :count="4" />
            </div>

            <div wire:loading.remove wire:target="save, delete" class="space-y-4">
                @foreach($roles as $rol)
                    <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 relative group" wire:key="rol-{{ $rol->id }}">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                            
                            {{-- NOMBRE --}}
                            <div class="flex-1 min-w-0 flex items-center gap-4">
                                <div class="size-12 rounded-xl bg-gray-50 dark:bg-neutral-800 flex items-center justify-center flex-shrink-0 border border-gray-100 dark:border-neutral-700">
                                    <i class="bx bx-shield-alt-2 text-2xl text-gray-500 dark:text-neutral-400"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-lg truncate">
                                        {{ \Illuminate\Support\Str::title($rol->name) }}
                                    </p>
                                    <p class="text-xs font-medium text-gray-500 dark:text-neutral-400 truncate mt-0.5">
                                        Rol interno del sistema
                                    </p>
                                </div>
                            </div>

                            {{-- ESTADÍSTICAS, ACCIONES --}}
                            <div class="flex flex-wrap items-center gap-6 lg:gap-8">
                                
                                {{-- USUARIOS CON ESTE ROL --}}
                                <div class="bg-blue-50/50 dark:bg-blue-900/10 px-4 py-2 rounded-xl border border-blue-100 dark:border-blue-900/30">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-0.5">Usuarios</p>
                                    <p class="text-sm font-extrabold text-blue-600 dark:text-blue-400 flex items-center gap-1.5">
                                        <i class="bx bx-group"></i> {{ $rol->users_count }}
                                    </p>
                                </div>

                                {{-- PERMISOS ASIGNADOS --}}
                                <div class="bg-purple-50/50 dark:bg-purple-900/10 px-4 py-2 rounded-xl border border-purple-100 dark:border-purple-900/30">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-0.5">Permisos</p>
                                    <p class="text-sm font-extrabold text-purple-600 dark:text-purple-400 flex items-center gap-1.5">
                                        <i class="bx bx-check-shield"></i> {{ $rol->permissions_count }}
                                    </p>
                                </div>

                                {{-- ACCIONES --}}
                                <div class="flex items-center gap-2 border-l border-gray-100 dark:border-neutral-800 pl-6">
                                    @if($rol->name !== 'admin')
                                        @can('roles.editar')
                                            <button type="button" 
                                                @click="abrirEditar({{ $rol->id }})"
                                                wire:loading.attr="disabled"
                                                class="text-gray-500 hover:text-blue-600 transition-all bg-gray-50 hover:bg-blue-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-blue-200 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-blue-900/30 dark:hover:border-blue-800/50 disabled:opacity-50"
                                                title="Editar Nombre">
                                                <i class="bx bx-edit text-xl" wire:loading.remove wire:target="openEditModal({{ $rol->id }})"></i>
                                                <i class="bx bx-loader-alt bx-spin text-lg text-blue-600" wire:loading wire:target="openEditModal({{ $rol->id }})"></i>
                                            </button>
                                        @endcan

                                        @can('roles.eliminar')
                                            <button type="button"
                                                @click="abrirEliminar({{ $rol->id }})"
                                                wire:loading.attr="disabled"
                                                class="text-gray-500 hover:text-red-600 transition-all bg-gray-50 hover:bg-red-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-red-200 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 dark:hover:border-red-800/50 disabled:opacity-50"
                                                title="Eliminar Rol">
                                                <i class="bx bx-trash text-xl" wire:loading.remove wire:target="confirmDelete({{ $rol->id }})"></i>
                                                <i class="bx bx-loader-alt bx-spin text-lg text-red-600" wire:loading wire:target="confirmDelete({{ $rol->id }})"></i>
                                            </button>
                                        @endcan
                                    @else
                                        <div class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-center">
                                            <span class="text-xs font-bold text-gray-500 dark:text-neutral-500 italic uppercase">Sistema</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-section>

    {{-- MODAL CREAR/EDITAR (Alpine x-show instantáneo) --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrar"></div>
        <div class="relative w-full max-w-lg bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 animate-modal">
            <div class="p-6 border-b border-gray-100 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-900/50">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400">
                            <i class="bx bx-shield-plus text-xl"></i>
                        </div>
                        <span>{{ $editingId ? 'Editar Rol' : 'Nuevo Rol' }}</span>
                    </h3>
                    <button type="button" @click="cerrar" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:hover:text-neutral-200 transition-colors">
                        <i class="bx bx-x text-xl"></i>
                    </button>
                </div>
            </div>
            
            <div wire:loading.flex wire:target="openEditModal" class="p-8 items-center justify-center gap-3 text-teal-600">
                <i class="bx bx-loader-alt bx-spin text-2xl"></i>
                <span class="text-sm font-semibold">Cargando rol...</span>
            </div>

            <form wire:submit="save" wire:loading.remove wire:target="openEditModal">
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-neutral-300">Nombre del Rol <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="name" class="w-full py-2.5 px-4 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 dark:placeholder-neutral-500 shadow-sm" placeholder="ej. editor, supervisor">
                        <p class="text-xs font-medium text-gray-500 mt-2 flex items-center gap-1.5"><i class="bx bx-info-circle"></i> Utilice minúsculas preferiblemente.</p>
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-3 bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                    <button type="button" @click="cerrar" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">Cancelar</button>
                    <button type="submit" wire:loading.attr="disabled" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2 transform hover:-translate-y-0.5">
                        <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2">
                            <i class="bx bx-save text-lg"></i> Guardar
                        </span>
                        <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                            <i class="bx bx-loader-alt bx-spin text-lg"></i> Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL ELIMINAR (Alpine x-show instantáneo) --}}
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrarEliminar"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 animate-modal">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="size-14 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0 border border-red-200 dark:border-red-800/50">
                        <i class="bx bx-trash text-3xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Eliminar Rol</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl p-4 border border-gray-100 dark:border-neutral-700/50">
                    <p class="text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">¿Confirmas que deseas eliminar permanentemente el rol:</p>
                    <div wire:loading wire:target="confirmDelete" class="py-2 text-red-500 flex items-center gap-2 text-xs font-semibold">
                        <i class="bx bx-loader-alt bx-spin"></i> Cargando...
                    </div>
                    <p wire:loading.remove wire:target="confirmDelete" class="font-extrabold text-gray-900 dark:text-white italic bg-white dark:bg-neutral-800 px-3 py-2 rounded-lg border border-gray-200 dark:border-neutral-600 shadow-sm">{{ $deletingNombre ?: '...' }}</p>
                </div>
            </div>
            
            <div class="flex gap-3 justify-end bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                <button type="button" @click="cerrarEliminar"
                    class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                    Cancelar
                </button>
                <button type="button" wire:click="delete" wire:loading.attr="disabled"
                    class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2 transform hover:-translate-y-0.5">
                    <span wire:loading.remove wire:target="delete" class="inline-flex items-center gap-2">
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
    function initRoles() {
        if (window.Alpine && typeof window.Alpine.data === 'function') {
            window.Alpine.data('rolesData', () => ({
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
    initRoles();
    document.addEventListener('alpine:init', initRoles);
    document.addEventListener('livewire:navigated', initRoles);
})();
</script>
