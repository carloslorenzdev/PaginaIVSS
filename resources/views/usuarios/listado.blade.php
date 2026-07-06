@extends('layouts/app')

@section('titulo', 'Usuarios')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="Usuarios" />
            
            <button id="btn-nuevo-usuario"
                class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition-colors">
                <i class="bx bx-user-plus"></i> Nuevo Registro
            </button>
        </div>

        @hasrole('admin|director')
            @include('usuarios/listado/indicadores')
        @endhasrole
        
        <div class="grid grid-cols-1 gap-4">
            <div>
                @include('usuarios/listado/busqueda')
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden rounded-lg space-y-3 pb-3">
                    @include('usuarios/listado/tabla')
                </div>
            </div>
        </div>
        
        @include('usuarios/modal-accion')
        {{ $usuarios->onEachSide(1)->links() }}
    </x-section>

    {{-- MODAL CREATE/EDIT USUARIO --}}
    <div id="modal-usuario" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modal-usuario-backdrop"></div>
        <div class="relative w-full max-w-2xl rounded-2xl bg-white shadow-2xl dark:bg-neutral-800 animate-modal">
            <div class="flex items-center justify-between border-b px-6 py-4 dark:border-neutral-700">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-user text-xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 id="modal-usuario-title" class="font-bold text-gray-900 dark:text-white">Nuevo Registro</h3>
                </div>
                <button type="button" id="btn-close-modal-usuario" class="text-gray-400 hover:text-gray-600 dark:hover:text-neutral-200 transition-colors">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>
            <form id="form-usuario" action="/usuarios/registrar" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-usuario-method" value="POST">
                
                <div class="p-6">
                    <div class="grid xs:grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input.label for="nombre" value="Nombre Completo" />
                            <x-input type="text" id="input-nombre" name="nombre" placeholder="María Alejandra" required />
                        </div>
                        <div>
                            <x-input.label for="usuario" value="Usuario" />
                            <x-input type="text" id="input-usuario" name="usuario" placeholder="malejandra" required />
                        </div>
                        <div class="col-span-full">
                            <x-input.label for="email" value="Correo Electrónico" />
                            <x-input type="email" id="input-email" name="email" placeholder="ejemplo@ivss.gob.ve" required />
                        </div>
                        <div id="password-container" class="col-span-full grid grid-cols-1 sm:grid-cols-2 gap-4 hidden">
                            <div>
                                <x-input.label for="password" value="Contraseña" />
                                <x-input type="password" id="input-password" name="password" placeholder="Min. 8 caracteres" />
                            </div>
                            <div>
                                <x-input.label for="password_confirmation" value="Confirmar Contraseña" />
                                <x-input type="password" id="input-password-confirmation" name="password_confirmation" placeholder="Repite la contraseña" />
                            </div>
                        </div>
                        
                        <div class="col-span-full mt-2">
                            <x-input.label value="Rol" />
                            <div class="flex flex-wrap gap-2">
                                @foreach ($roles as $rol)
                                    <label class="flex p-3 bg-white border border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 cursor-pointer hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                                        <input type="radio" name="rol" value="{{ $rol->name }}" class="input-rol shrink-0 mt-0.5 border-gray-300 rounded-full text-red-600 focus:ring-red-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-red-500 dark:checked:border-red-500">
                                        <span class="text-sm text-gray-700 ms-3 dark:text-neutral-300 font-medium">
                                            {{ str()->of($rol->name)->title() }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t px-6 py-4 dark:border-neutral-700">
                    <button type="button" id="btn-cancelar-usuario" class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">Cancelar</button>
                    <button type="submit" class="py-2 px-4 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('page-scripts')
    @hasrole('admin|director')
        @vite('resources/js/countup-indicadores.js')
    @endhasrole
    @vite('resources/js/admin-usuarios.js')

    <style nonce="{{ app('csp-nonce') }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endpush
