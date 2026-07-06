@extends('layouts/app')

@section('titulo', 'Categorías')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="Categorías" />
            
            <button id="btn-nueva-categoria" data-url="{{ route('admin.categorias.guardar') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700 transition-colors">
                <i class="bx bx-plus"></i> Nueva Categoría
            </button>
        </div>

        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Categorías
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
                    <i class="bx bx-list-ul"></i> Listado de Categorías
                </x-card.title>
            </div>

            <div class="space-y-4">
                @forelse($categorias as $cat)
                    <x-card class="p-4 hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            
                            {{-- NOMBRE Y DESCRIPCIÓN --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 dark:text-white text-base truncate">
                                    {{ $cat->nombre }}
                                </p>
                                <p class="text-sm mt-1 text-gray-500 dark:text-neutral-400 truncate">
                                    {{ $cat->descripcion ?: 'Sin descripción' }}
                                </p>
                            </div>

                            {{-- ESTADO, NOTICIAS, ACCIONES --}}
                            <div class="flex flex-wrap items-center gap-6 lg:gap-8">
                                
                                {{-- ESTADO --}}
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-1">Estado</p>
                                    @if ($cat->activa)
                                        <x-badge color="emerald" class="py-0.5 px-2 text-xs">
                                            <i class="bx bx-check mr-1"></i> Activa
                                        </x-badge>
                                    @else
                                        <x-badge color="red" class="py-0.5 px-2 text-xs">
                                            <i class="bx bx-block mr-1"></i> Inactiva
                                        </x-badge>
                                    @endif
                                </div>

                                {{-- NOTICIAS --}}
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-1">Noticias</p>
                                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400 flex items-center">
                                        <i class="bx bx-news mr-1"></i> {{ $cat->noticias_count ?? 0 }}
                                    </p>
                                </div>

                                {{-- ACCIONES --}}
                                <div class="flex items-center gap-2 border-l border-gray-200 dark:border-neutral-700 pl-6">
                                    <button type="button" 
                                        class="btn-edit text-gray-500 hover:text-blue-600 transition-colors bg-white hover:bg-blue-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-blue-900/30"
                                        data-url="{{ route('admin.categorias.index') }}/{{ $cat->id }}"
                                        data-id="{{ $cat->id }}"
                                        data-nombre="{{ $cat->nombre }}"
                                        data-descripcion="{{ $cat->descripcion }}"
                                        data-orden="{{ $cat->orden }}"
                                        data-activa="{{ $cat->activa }}"
                                        title="Editar Categoría">
                                        <i class="bx bx-edit text-lg"></i>
                                    </button>
                                    
                                    <button type="button" 
                                        class="btn-delete text-gray-500 hover:text-red-600 transition-colors bg-white hover:bg-red-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-red-900/30"
                                        data-url="{{ route('admin.categorias.eliminar', $cat->id) }}"
                                        data-nombre="{{ $cat->nombre }}"
                                        title="Eliminar Categoría">
                                        <i class="bx bx-trash text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-card>
                @empty
                    <div class="p-12 text-center border-2 border-dashed border-gray-300 dark:border-neutral-700 rounded-2xl">
                        <div class="size-16 mx-auto bg-gray-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4">
                            <i class="bx bx-list-ul text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No hay categorías</h3>
                        <p class="mt-1 text-gray-500 dark:text-neutral-400">Aún no se han registrado categorías.</p>
                    </div>
                @endforelse
            </div>
        </x-card>
    </x-section>

    {{-- MODAL CREATE/EDIT --}}
    <div id="modal-create" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modal-backdrop"></div>
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl dark:bg-neutral-800 animate-modal">
            <div class="flex items-center justify-between border-b px-6 py-4 dark:border-neutral-700">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-full bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-list-ul text-xl text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <h3 id="modal-title" class="font-bold text-gray-900 dark:text-white">Nueva Categoría</h3>
                </div>
                <button type="button" id="btn-close-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-neutral-200 transition-colors">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>
            <form id="form-categoria" action="{{ route('admin.categorias.guardar') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="space-y-4 p-6">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="input-nombre" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required maxlength="255">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Descripción</label>
                        <textarea name="descripcion" id="input-descripcion" rows="3" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Orden</label>
                            <input type="number" name="orden" id="input-orden" min="0" value="0" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="flex items-center cursor-pointer relative">
                                <input type="checkbox" name="activa" id="input-activa" value="1" checked class="peer sr-only">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Activa</span>
                            </label>
                        </div>
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
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Categoría</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-2">¿Confirmas que deseas eliminar permanentemente la categoría:</p>
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

    @push('page-scripts')
        @vite('resources/js/admin-categorias.js')
    @endpush
    
    <style nonce="{{ app('csp-nonce') }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endsection