?@extends('layouts/app')

@php
    $titulo = 'Directorios';
    if(request('tipo') == 'farmacia') $titulo = 'Farmacias';
    if(request('tipo') == 'centro_salud') $titulo = 'Centros de Salud';
    if(request('tipo') == 'oficina_administrativa') $titulo = 'Oficinas Administrativas';
@endphp

@section('titulo', $titulo)

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="{{ $titulo }}" />
            
            <button id="btn-nuevo-registro"
                data-store-url="{{ route('admin.directorios.store') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700 transition-colors">
                <i class="bx bx-plus"></i> Nuevo Registro
            </button>
        </div>



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

        {{-- LISTADO EN TARJETAS --}}
        <div class="space-y-4">
            @forelse($directorios as $item)
                <x-card class="relative p-5 searchable-item hover:bg-gray-50 dark:hover:bg-neutral-800/50 text-gray-800 dark:text-neutral-200 transition-colors">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 pr-16">
                        
                        {{-- ESTADO Y NOMBRE --}}
                        <div class="col-span-full lg:col-span-2">
                            <div class="flex flex-col items-start gap-2">
                                <x-badge color="teal">
                                    <i class="bx bx-map mr-1"></i> {{ $item->estado }}
                                </x-badge>
                                <p class="block font-bold text-gray-900 dark:text-white text-base">
                                    {{ $item->nombre }}
                                </p>
                            </div>
                        </div>

                        {{-- DIRECCI�?N --}}
                        <div class="md:col-span-1 lg:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500">Dirección</p>
                            <p class="text-sm mt-1 text-gray-700 dark:text-neutral-300 leading-relaxed">{{ \Illuminate\Support\Str::limit($item->direccion, 100) }}</p>
                        </div>

                        {{-- TEL�?FONO --}}
                        <div class="md:col-span-1 lg:col-span-1">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500">Teléfono</p>
                            <p class="text-sm mt-1 text-gray-700 dark:text-neutral-300 font-medium">{{ $item->telefono ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- ACCIONES --}}
                    <div class="absolute top-5 right-5 flex flex-col sm:flex-row gap-2">
                        <button type="button" 
                            class="btn-edit text-gray-500 hover:text-blue-600 transition-colors bg-white hover:bg-blue-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-blue-900/30"
                            data-id="{{ $item->id }}"
                            data-update-url="{{ route('admin.directorios.index') }}/{{ $item->id }}"
                            data-estado="{{ $item->estado }}"
                            data-nombre="{{ $item->nombre }}"
                            data-direccion="{{ $item->direccion }}"
                            data-telefono="{{ $item->telefono }}"
                            title="Editar Registro">
                            <i class="bx bx-edit text-lg"></i>
                        </button>
                        
                        <button type="button" 
                            class="btn-delete text-gray-500 hover:text-red-600 transition-colors bg-white hover:bg-red-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-red-900/30"
                            data-url="{{ route('admin.directorios.destroy', $item) }}"
                            data-nombre="{{ $item->nombre }}"
                            title="Eliminar Registro">
                            <i class="bx bx-trash text-lg"></i>
                        </button>
                    </div>
                </x-card>
            @empty
                <div class="p-12 text-center border-2 border-dashed border-gray-300 dark:border-neutral-700 rounded-2xl">
                    <div class="size-16 mx-auto bg-gray-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4">
                        <i class="bx bx-search text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">No hay registros</h3>
                    <p class="mt-1 text-gray-500 dark:text-neutral-400">No se han encontrado registros para este directorio.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $directorios->links() }}
        </div>
    </x-section>

    {{-- MODAL CREATE/EDIT --}}
    <div id="modal-create" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modal-backdrop"></div>
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl dark:bg-neutral-800 animate-modal">
            <div class="flex items-center justify-between border-b px-6 py-4 dark:border-neutral-700">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-full bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-building-house text-xl text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <h3 id="modal-title" class="font-bold text-gray-900 dark:text-white">Nuevo Registro</h3>
                </div>
                <button type="button" id="btn-close-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-neutral-200 transition-colors">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>
            <form id="form-directorio" action="{{ route('admin.directorios.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="tipo" value="{{ request('tipo') }}">
                
                <div class="space-y-4 p-6">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Estado <span class="text-red-500">*</span></label>
                        <select name="estado" id="input-estado" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
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
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="input-nombre" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Dirección <span class="text-red-500">*</span></label>
                        <textarea name="direccion" id="input-direccion" rows="3" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Teléfono</label>
                        <input type="tel" name="telefono" id="input-telefono" pattern="[0-9\-\+\s\(\)]+" placeholder="Ej. (0212) 123-4567" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        <p class="text-xs text-gray-500 mt-1">Solo números, espacios y guiones (-).</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 border-t px-6 py-4 dark:border-neutral-700">
                    <button type="button" id="btn-cancelar" class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 searchable-item hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">Cancelar</button>
                    <button type="submit" data-store-url="{{ route('admin.directorios.store') }}" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-teal-600 text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all shadow-sm">
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
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Registro</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-2">¿Confirmas que deseas eliminar permanentemente el registro:</p>
            <p class="font-semibold text-gray-900 dark:text-white mb-5 italic" id="modal-eliminar-nombre"></p>
            
            <form id="form-eliminar" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3 justify-end border-t pt-4 dark:border-neutral-700">
                    <button type="button" id="btn-cerrar-eliminar"
                        class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 searchable-item hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
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

    <script src="{{ asset('js/admin/directorios.js') }}" nonce="{{ app('csp-nonce') ?? '' }}"></script>
    
    <style nonce="{{ app('csp-nonce') }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endsection

