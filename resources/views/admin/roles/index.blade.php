@extends('layouts/app')

@section('titulo', 'Roles del Sistema')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Roles del Sistema" class="text-gradient font-extrabold text-3xl" />
            
            <button id="btn-nuevo" data-url="{{ route('usuarios.roles.store') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all transform hover:-translate-y-0.5">
                <i class="bx bx-plus text-lg"></i> Nuevo Rol
            </button>
        </div>

        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Roles del Sistema
            </x-breadcrumb.current>
        </x-breadcrumb>

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

        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-2xl p-6 md:p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-neutral-800 pb-5">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400">
                        <i class="bx bx-shield-quarter text-xl"></i>
                    </div>
                    Listado de Roles
                </h3>
            </div>

            <div class="space-y-4">
                @foreach($roles as $rol)
                    <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 relative group">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                            
                            {{-- NOMBRE --}}
                            <div class="flex-1 min-w-0 flex items-center gap-4">
                                <div class="size-12 rounded-xl bg-gray-50 dark:bg-neutral-800 flex items-center justify-center flex-shrink-0 border border-gray-100 dark:border-neutral-700">
                                    <i class="bx bx-shield-alt-2 text-2xl text-gray-500 dark:text-neutral-400"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-lg truncate">
                                        {{ Str::title($rol->name) }}
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
                                        <i class="bx bx-group"></i> {{ $rol->users()->count() }}
                                    </p>
                                </div>

                                {{-- PERMISOS ASIGNADOS --}}
                                <div class="bg-purple-50/50 dark:bg-purple-900/10 px-4 py-2 rounded-xl border border-purple-100 dark:border-purple-900/30">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-0.5">Permisos</p>
                                    <p class="text-sm font-extrabold text-purple-600 dark:text-purple-400 flex items-center gap-1.5">
                                        <i class="bx bx-check-shield"></i> {{ $rol->permissions()->count() }}
                                    </p>
                                </div>

                                {{-- ACCIONES --}}
                                <div class="flex items-center gap-2 border-l border-gray-100 dark:border-neutral-800 pl-6">
                                    @if($rol->name !== 'admin')
                                        <button type="button" 
                                            class="btn-edit text-gray-500 hover:text-blue-600 transition-all bg-gray-50 hover:bg-blue-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-blue-200 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-blue-900/30 dark:hover:border-blue-800/50"
                                            data-url="{{ route('usuarios.roles.update', $rol) }}"
                                            data-nombre="{{ $rol->name }}"
                                            title="Editar Nombre">
                                            <i class="bx bx-edit text-xl"></i>
                                        </button>

                                        <button type="button"
                                            class="btn-delete text-gray-500 hover:text-red-600 transition-all bg-gray-50 hover:bg-red-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-red-200 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 dark:hover:border-red-800/50"
                                            data-url="{{ route('usuarios.roles.destroy', $rol) }}"
                                            data-nombre="{{ Str::title($rol->name) }}"
                                            title="Eliminar Rol">
                                            <i class="bx bx-trash text-xl"></i>
                                        </button>
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

    {{-- MODAL CREAR/EDITAR --}}
    <div id="modal-form" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" id="modal-backdrop"></div>
        <div class="relative w-full max-w-lg bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 animate-modal">
            <div class="p-6 border-b border-gray-100 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-900/50">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3" id="modal-title">
                        <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400">
                            <i class="bx bx-shield-plus text-xl"></i>
                        </div>
                        <span>Nuevo Rol</span>
                    </h3>
                    <button type="button" id="btn-close-modal" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600 transition-colors">
                        <span class="sr-only">Cerrar</span>
                        <i class="bx bx-x text-xl"></i>
                    </button>
                </div>
            </div>
            
            <form id="form-role" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-neutral-300">Nombre del Rol <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="input-nombre" class="w-full py-2.5 px-4 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 dark:placeholder-neutral-500 shadow-sm" required maxlength="255" placeholder="ej. editor, supervisor">
                        <p class="text-xs font-medium text-gray-500 mt-2 flex items-center gap-1.5"><i class="bx bx-info-circle"></i> Utilice minúsculas preferiblemente.</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                    <button type="button" id="btn-cancelar" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">Cancelar</button>
                    <button type="submit" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2 transform hover:-translate-y-0.5">
                        <i class="bx bx-save text-lg"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL ELIMINAR --}}
    <div id="modal-eliminar" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" id="modal-eliminar-backdrop"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 animate-modal">
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
                    <p class="font-extrabold text-gray-900 dark:text-white italic bg-white dark:bg-neutral-800 px-3 py-2 rounded-lg border border-gray-200 dark:border-neutral-600 shadow-sm" id="modal-eliminar-nombre"></p>
                </div>
            </div>
            
            <form id="form-eliminar" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3 justify-end bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                    <button type="button" id="btn-cerrar-eliminar"
                        class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2 transform hover:-translate-y-0.5">
                        <i class="bx bx-trash text-lg"></i> Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/admin-roles.js')
    <script nonce="{{ app('csp-nonce') ?? '' }}">
        // FIX: Manual cleanup for modals because of Turbo lifecycle
        document.addEventListener('turbo:before-cache', () => {
            const modalForm = document.getElementById('modal-form');
            const modalEliminar = document.getElementById('modal-eliminar');
            if (modalForm) {
                modalForm.classList.add('hidden');
                modalForm.classList.remove('flex');
            }
            if (modalEliminar) {
                modalEliminar.classList.add('hidden');
                modalEliminar.classList.remove('flex');
            }
        });
    </script>
    
    <style nonce="{{ app('csp-nonce') }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endsection

