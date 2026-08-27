@extends('layouts/app')

@section('titulo', 'Categorías')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Categorías" class="text-gradient font-extrabold text-3xl" />
            
            <button id="btn-nueva-categoria" data-url="{{ route('admin.categorias.guardar') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all transform hover:-translate-y-0.5">
                <i class="bx bx-plus text-lg"></i> Nueva Categoría
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
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 dark:bg-red-900/20 dark:border-red-900/50 shadow-sm" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bx bx-x-circle text-red-500 text-xl mt-0.5"></i>
                    </div>
                    <div class="ms-3">
                        <ul class="list-disc list-inside text-sm font-medium text-red-800 dark:text-red-400 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
            <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50">
                <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2 text-lg">
                    <div class="size-8 rounded-lg bg-teal-100 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center">
                        <i class="bx bx-list-ul text-lg"></i>
                    </div>
                    Listado de Categorías
                </h3>
            </div>
            
            <div class="p-6 space-y-4">
                @forelse($categorias as $cat)
                    <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 group">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                            
                            {{-- NOMBRE Y DESCRIPCIÓN --}}
                            <div class="flex-1 min-w-0 flex items-start gap-3">
                                <div class="size-10 rounded-lg bg-gray-50 dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700 flex flex-col items-center justify-center text-xs font-bold text-gray-500 dark:text-neutral-400 shrink-0 mt-0.5">
                                    <span class="text-[9px] uppercase tracking-wider mb-0.5">Ord</span>
                                    <span>{{ $cat->orden }}</span>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-lg truncate flex items-center gap-2">
                                        {{ $cat->nombre }}
                                    </p>
                                    <p class="text-sm mt-1 font-medium text-gray-500 dark:text-neutral-400 line-clamp-2">
                                        {{ $cat->descripcion ?: 'Sin descripción' }}
                                    </p>
                                </div>
                            </div>

                            {{-- ESTADO, NOTICIAS, ACCIONES --}}
                            <div class="flex flex-wrap items-center gap-6 lg:gap-8">
                                
                                {{-- ESTADO --}}
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1.5">Estado</p>
                                    @if ($cat->activa)
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/50">
                                            <span class="size-1.5 rounded-full bg-emerald-500"></span> Activa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 border border-red-100 dark:border-red-900/50">
                                            <span class="size-1.5 rounded-full bg-red-500"></span> Inactiva
                                        </span>
                                    @endif
                                </div>

                                {{-- NOTICIAS --}}
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1.5">Noticias</p>
                                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400 flex items-center bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-lg">
                                        <i class="bx bx-news mr-1.5"></i> {{ $cat->noticias_count ?? 0 }}
                                    </p>
                                </div>

                                {{-- ACCIONES --}}
                                <div class="flex items-center gap-2 border-l border-gray-100 dark:border-neutral-700 pl-6 lg:pl-8">
                                    <button type="button" 
                                        class="btn-edit text-gray-500 hover:text-teal-600 transition-all bg-gray-50 hover:bg-teal-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-teal-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-teal-900/30 dark:hover:border-teal-800/50"
                                        data-url="{{ route('admin.categorias.index') }}/{{ $cat->id }}"
                                        data-id="{{ $cat->id }}"
                                        data-nombre="{{ $cat->nombre }}"
                                        data-descripcion="{{ $cat->descripcion }}"
                                        data-orden="{{ $cat->orden }}"
                                        data-activa="{{ $cat->activa }}"
                                        title="Editar Categoría">
                                        <i class="bx bx-edit text-xl"></i>
                                    </button>
                                    
                                    <button type="button" 
                                        class="btn-delete text-gray-500 hover:text-red-600 transition-all bg-gray-50 hover:bg-red-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-red-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 dark:hover:border-red-800/50"
                                        data-url="{{ route('admin.categorias.eliminar', $cat->id) }}"
                                        data-nombre="{{ $cat->nombre }}"
                                        title="Eliminar Categoría">
                                        <i class="bx bx-trash text-xl"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 rounded-2xl">
                        <div class="size-20 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-5 shadow-sm border border-gray-100 dark:border-neutral-700">
                            <i class="bx bx-list-ul text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No hay categorías</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Aún no se han registrado categorías.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </x-section>

    {{-- MODAL CREATE/EDIT --}}
    <div id="modal-create" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" id="modal-backdrop"></div>
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl dark:bg-neutral-800 animate-modal overflow-hidden border border-gray-100 dark:border-neutral-700">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-list-ul text-xl text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <h3 id="modal-title" class="font-bold text-gray-900 dark:text-white text-xl">Nueva Categoría</h3>
                </div>
                <button type="button" id="btn-close-modal" class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-neutral-700 text-gray-500 hover:bg-gray-200 hover:text-gray-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:hover:text-neutral-200 transition-colors">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>
            <form id="form-categoria" action="{{ route('admin.categorias.guardar') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="space-y-5 p-6">
                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="input-nombre" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" required maxlength="255">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Descripción</label>
                        <textarea name="descripcion" id="input-descripcion" rows="3" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Orden</label>
                            <input type="number" name="orden" id="input-orden" min="0" value="0" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm">
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="flex items-center cursor-pointer relative bg-gray-50 dark:bg-neutral-900 border border-gray-100 dark:border-neutral-700 py-2.5 px-4 rounded-xl w-full">
                                <input type="checkbox" name="activa" id="input-activa" value="1" checked class="peer sr-only">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-teal-300/50 dark:peer-focus:ring-teal-800/50 dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[12px] after:left-[18px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-teal-500"></div>
                                <span class="ml-3 text-sm font-bold text-gray-700 dark:text-neutral-300">Activa</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                    <button type="button" id="btn-cancelar" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">Cancelar</button>
                    <button type="submit" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2">
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
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Eliminar Categoría</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl p-4 border border-gray-100 dark:border-neutral-700/50">
                    <p class="text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">¿Confirmas que deseas eliminar permanentemente la categoría:</p>
                    <p class="text-base font-bold text-gray-900 dark:text-white italic" id="modal-eliminar-nombre"></p>
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
                        class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-trash text-lg"></i> Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('page-scripts')
        @vite('resources/js/admin-categorias.js')
        <script nonce="{{ app('csp-nonce') ?? '' }}">
            // FIX: Manual cleanup for modals because of Turbo lifecycle
            document.addEventListener('turbo:before-cache', () => {
                const modalCreate = document.getElementById('modal-create');
                const modalEliminar = document.getElementById('modal-eliminar');
                if (modalCreate) {
                    modalCreate.classList.add('hidden');
                    modalCreate.classList.remove('flex');
                }
                if (modalEliminar) {
                    modalEliminar.classList.add('hidden');
                    modalEliminar.classList.remove('flex');
                }
                // Optional: remove backdrop body class if used
            });
        </script>
    @endpush
    
    <style nonce="{{ app('csp-nonce') }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endsection
