@extends('layouts/app')

@section('titulo', 'Roles del Sistema')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="Roles del Sistema" />
            
            <button id="btn-nuevo" data-url="{{ route('usuarios.roles.store') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700 transition-colors">
                <i class="bx bx-plus"></i> Nuevo Rol
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

        <x-card class="p-5">
            <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-neutral-700 pb-3">
                <x-card.title>
                    <i class="bx bx-shield-quarter"></i> Listado de Roles
                </x-card.title>
            </div>

            <div class="space-y-4">
                @foreach($roles as $rol)
                    <x-card class="p-4 hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            
                            {{-- NOMBRE --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 dark:text-white text-base truncate">
                                    {{ Str::title($rol->name) }}
                                </p>
                                <p class="text-xs mt-1 text-gray-500 dark:text-neutral-400 truncate">
                                    Rol interno del sistema
                                </p>
                            </div>

                            {{-- ESTADÍSTICAS, ACCIONES --}}
                            <div class="flex flex-wrap items-center gap-6 lg:gap-8">
                                
                                {{-- USUARIOS CON ESTE ROL --}}
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-1">Usuarios</p>
                                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400 flex items-center">
                                        <i class="bx bx-group mr-1"></i> {{ $rol->users()->count() }}
                                    </p>
                                </div>

                                {{-- PERMISOS ASIGNADOS --}}
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-1">Permisos</p>
                                    <p class="text-sm font-medium text-purple-600 dark:text-purple-400 flex items-center">
                                        <i class="bx bx-check-shield mr-1"></i> {{ $rol->permissions()->count() }}
                                    </p>
                                </div>

                                {{-- ACCIONES --}}
                                <div class="flex items-center gap-2 border-l border-gray-200 dark:border-neutral-700 pl-6">
                                    @if($rol->name !== 'admin')
                                        <button type="button" 
                                            class="btn-edit text-gray-500 hover:text-blue-600 transition-colors bg-white hover:bg-blue-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-blue-900/30"
                                            data-url="{{ route('usuarios.roles.update', $rol) }}"
                                            data-nombre="{{ $rol->name }}"
                                            title="Editar Nombre">
                                            <i class="bx bx-edit text-lg"></i>
                                        </button>

                                        <button type="button"
                                            class="btn-delete text-gray-500 hover:text-red-600 transition-colors bg-white hover:bg-red-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-red-900/30"
                                            data-url="{{ route('usuarios.roles.destroy', $rol) }}"
                                            data-nombre="{{ Str::title($rol->name) }}"
                                            title="Eliminar Rol">
                                            <i class="bx bx-trash text-lg"></i>
                                        </button>
                                    @else
                                        <span class="text-xs font-semibold text-gray-400 italic">No editable</span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </x-card>
                @endforeach
            </div>
        </x-card>
    </x-section>

    {{-- MODAL CREAR/EDITAR --}}
    <div id="modal-form" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modal-backdrop"></div>
        <div class="relative w-full max-w-lg bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl animate-modal overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2" id="modal-title">
                    <i class="bx bx-shield-plus text-teal-600"></i> Nuevo Rol
                </h3>
                <button type="button" id="btn-close-modal" class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>
            
            <form id="form-role" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Nombre del Rol <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="input-nombre" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required maxlength="255" placeholder="ej. editor, supervisor">
                        <p class="text-xs text-gray-500 mt-1">Utilice minúsculas preferiblemente.</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 border-t px-6 py-4 dark:border-neutral-700">
                    <button type="button" id="btn-cancelar" class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">Cancelar</button>
                    <button type="submit" class="py-2 px-4 text-sm font-semibold rounded-lg bg-teal-600 text-white hover:bg-teal-700 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL ELIMINAR --}}
    <div id="modal-eliminar" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modal-eliminar-backdrop"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl p-6 animate-modal">
            <div class="flex items-center gap-3 mb-4">
                <div class="size-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-trash text-2xl text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Rol</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-2">¿Confirmas que deseas eliminar permanentemente el rol:</p>
            <p class="font-semibold text-gray-900 dark:text-white mb-5 italic" id="modal-eliminar-nombre"></p>
            
            <form id="form-eliminar" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3 justify-end border-t pt-4 dark:border-neutral-700">
                    <button type="button" id="btn-cerrar-eliminar"
                        class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="py-2 px-4 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-trash"></i> Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            function initRoles() {
                const modalForm = document.getElementById('modal-form');
                const formRole = document.getElementById('form-role');
                const formMethod = document.getElementById('form-method');
                const inputNombre = document.getElementById('input-nombre');
                const modalTitle = document.getElementById('modal-title');
                
                const btnNuevo = document.getElementById('btn-nuevo');
                const btnCerrar = document.getElementById('btn-close-modal');
                const btnCancelar = document.getElementById('btn-cancelar');

                if (!modalForm || !formRole || !btnNuevo) return;

                function openModal() { modalForm.classList.remove('hidden'); modalForm.classList.add('flex'); }
                function closeModal() { modalForm.classList.add('hidden'); modalForm.classList.remove('flex'); }

                const newBtnNuevo = btnNuevo.cloneNode(true);
                btnNuevo.parentNode.replaceChild(newBtnNuevo, btnNuevo);
                
                newBtnNuevo.addEventListener('click', function() {
                    formRole.action = this.getAttribute('data-url');
                    formMethod.value = 'POST';
                    modalTitle.innerHTML = '<i class="bx bx-shield-plus text-teal-600"></i> Nuevo Rol';
                    formRole.reset();
                    openModal();
                });

                btnCerrar.addEventListener('click', closeModal);
                btnCancelar.addEventListener('click', closeModal);
                modalForm.addEventListener('click', (e) => { if (e.target === modalForm) closeModal(); });

                // Modal Eliminar
                const modalEliminar = document.getElementById('modal-eliminar');
                const btnCerrarEliminar = document.getElementById('btn-cerrar-eliminar');
                const formEliminar = document.getElementById('form-eliminar');
                
                function closeEliminar() { modalEliminar.classList.add('hidden'); modalEliminar.classList.remove('flex'); }
                btnCerrarEliminar.addEventListener('click', closeEliminar);
                modalEliminar.addEventListener('click', (e) => { if (e.target === modalEliminar) closeEliminar(); });

                // Event Delegation
                if (window._rolesClickListener) {
                    document.removeEventListener('click', window._rolesClickListener);
                }

                window._rolesClickListener = function(e) {
                    const btnEdit = e.target.closest('.btn-edit');
                    if (btnEdit) {
                        formRole.action = btnEdit.getAttribute('data-url');
                        formMethod.value = 'PUT';
                        modalTitle.innerHTML = '<i class="bx bx-edit text-teal-600"></i> Editar Rol';
                        inputNombre.value = btnEdit.getAttribute('data-nombre');
                        openModal();
                        return;
                    }

                    const btnDelete = e.target.closest('.btn-delete');
                    if (btnDelete) {
                        formEliminar.action = btnDelete.getAttribute('data-url');
                        document.getElementById('modal-eliminar-nombre').innerText = '"' + btnDelete.getAttribute('data-nombre') + '"';
                        modalEliminar.classList.remove('hidden');
                        modalEliminar.classList.add('flex');
                    }
                };

                document.addEventListener('click', window._rolesClickListener);
            }

            initRoles();
            document.addEventListener('turbo:load', initRoles);
        })();
    </script>
    
    <style nonce="{{ app('csp-nonce') }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endsection
