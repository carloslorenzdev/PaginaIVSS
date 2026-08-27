@extends('layouts/app')

@php
    $titulo = 'Directorios';
    if(request('tipo') == 'farmacia') $titulo = 'Farmacias';
    if(request('tipo') == 'centro_salud') $titulo = 'Centros de Salud';
    if(request('tipo') == 'oficina_administrativa') $titulo = 'Oficinas Administrativas';
@endphp

@section('titulo', $titulo)

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="{{ $titulo }}" class="text-gradient font-extrabold text-3xl" />
            
            <button id="btn-nuevo-registro"
                data-store-url="{{ route('admin.directorios.store') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all transform hover:-translate-y-0.5">
                <i class="bx bx-plus text-lg"></i> Nuevo Registro
            </button>
        </div>



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

        {{-- LISTADO EN TARJETAS --}}
        <div class="space-y-4">
            @forelse($directorios as $item)
                <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 relative group">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 pr-16">
                        
                        {{-- ESTADO Y NOMBRE --}}
                        <div class="col-span-full lg:col-span-2">
                            <div class="flex flex-col items-start gap-2.5">
                                <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-teal-50 text-teal-700 dark:bg-teal-900/20 dark:text-teal-400 border border-teal-100 dark:border-teal-900/50">
                                    <i class="bx bx-map text-sm"></i> {{ $item->estado }}
                                </span>
                                <p class="block font-bold text-gray-900 dark:text-white text-lg">
                                    {{ $item->nombre }}
                                </p>
                            </div>
                        </div>

                        {{-- DIRECCIÓN --}}
                        <div class="md:col-span-1 lg:col-span-2">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1">Dirección</p>
                            <p class="text-sm text-gray-600 dark:text-neutral-300 leading-relaxed font-medium bg-gray-50 dark:bg-neutral-800/50 p-2.5 rounded-lg border border-gray-100 dark:border-neutral-700/50">{{ \Illuminate\Support\Str::limit($item->direccion, 100) }}</p>
                        </div>

                        {{-- TELÉFONO --}}
                        <div class="md:col-span-1 lg:col-span-1">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1">Teléfono</p>
                            <p class="text-sm font-bold text-gray-700 dark:text-neutral-300 flex items-center gap-1.5">
                                <i class="bx bx-phone text-gray-400"></i> {{ $item->telefono ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    {{-- ACCIONES --}}
                    <div class="absolute top-5 right-5 flex flex-col sm:flex-row gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-300">
                        <button type="button" 
                            class="btn-edit text-gray-500 hover:text-teal-600 transition-all bg-gray-50 hover:bg-teal-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-teal-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-teal-900/30 dark:hover:border-teal-800/50 shadow-sm"
                            data-id="{{ $item->id }}"
                            data-update-url="{{ route('admin.directorios.index') }}/{{ $item->id }}"
                            data-estado="{{ $item->estado }}"
                            data-nombre="{{ $item->nombre }}"
                            data-direccion="{{ $item->direccion }}"
                            data-telefono="{{ $item->telefono }}"
                            title="Editar Registro">
                            <i class="bx bx-edit text-xl"></i>
                        </button>
                        
                        <button type="button" 
                            class="btn-delete text-gray-500 hover:text-red-600 transition-all bg-gray-50 hover:bg-red-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-red-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 dark:hover:border-red-800/50 shadow-sm"
                            data-url="{{ route('admin.directorios.destroy', $item) }}"
                            data-nombre="{{ $item->nombre }}"
                            title="Eliminar Registro">
                            <i class="bx bx-trash text-xl"></i>
                        </button>
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
        </div></div>

        <div class="mt-6">
            {{ $directorios->links() }}
        </div>
    </x-section>

    {{-- MODAL CREATE/EDIT --}}
    <div id="modal-create" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" id="modal-backdrop"></div>
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl dark:bg-neutral-800 animate-modal overflow-hidden border border-gray-100 dark:border-neutral-700">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-building-house text-xl text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <h3 id="modal-title" class="font-bold text-gray-900 dark:text-white text-xl">Nuevo Registro</h3>
                </div>
                <button type="button" id="btn-close-modal" class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-neutral-700 text-gray-500 hover:bg-gray-200 hover:text-gray-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:hover:text-neutral-200 transition-colors">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>
            <form id="form-directorio" action="{{ route('admin.directorios.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="tipo" value="{{ request('tipo') }}">
                
                <div class="space-y-5 p-6">
                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Estado <span class="text-red-500">*</span></label>
                        <select name="estado" id="input-estado" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" required>
                            <option value="">Seleccione un estado...</option>
                            @php
                                $estadosList = ['Amazonas', 'Anzoátegui', 'Apure', 'Aragua', 'Barinas', 'Bolívar', 'Carabobo', 'Cojedes', 'Delta Amacuro', 'Distrito Capital', 'Falcón', 'Guárico', 'Lara', 'Mérida', 'Miranda', 'Monagas', 'Nueva Esparta', 'Portuguesa', 'Sucre', 'Táchira', 'Trujillo', 'Vargas', 'Yaracuy', 'Zulia'];
                            @endphp
                            @foreach($estadosList as $est)
                                <option value="{{ $est }}">{{ $est }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="input-nombre" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Dirección <span class="text-red-500">*</span></label>
                        <textarea name="direccion" id="input-direccion" rows="3" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Teléfono</label>
                        <input type="tel" name="telefono" id="input-telefono" pattern="[0-9\-\+\s\(\)]+" placeholder="Ej. (0212) 123-4567" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm">
                        <p class="text-xs text-gray-500 dark:text-neutral-500 mt-1.5 font-medium">Solo números, espacios y guiones (-).</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                    <button type="button" id="btn-cancelar" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">Cancelar</button>
                    <button type="submit" data-store-url="{{ route('admin.directorios.store') }}" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2">
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
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Eliminar Registro</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl p-4 border border-gray-100 dark:border-neutral-700/50">
                    <p class="text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">¿Confirmas que deseas eliminar permanentemente el registro:</p>
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

    <script src="{{ asset('js/admin/directorios.js') }}?v={{ filemtime(public_path('js/admin/directorios.js')) }}" nonce="{{ app('csp-nonce') ?? '' }}"></script>
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
        });
    </script>
    
    <style nonce="{{ app('csp-nonce') ?? '' }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endsection

