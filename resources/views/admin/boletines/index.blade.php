@extends('layouts/app')

@section('titulo', 'Boletines Informativos')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="Boletines Informativos" />
            
            <button id="btn-nuevo-boletin" data-url="{{ route('admin.boletines.guardar') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700 transition-colors">
                <i class="bx bx-upload"></i> Subir Boletín
            </button>
        </div>

        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Boletines Informativos
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
                    <i class="bx bx-news"></i> Listado de Boletines
                </x-card.title>
            </div>

            <div class="space-y-4">
                @forelse($boletines as $boletin)
                    <x-card class="p-4 hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            
                            {{-- TÍTULO Y ARCHIVO --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 dark:text-white text-base truncate">
                                    {{ $boletin->titulo }}
                                </p>
                                <a href="{{ asset('storage/' . $boletin->archivo_pdf) }}" target="_blank" class="mt-1 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 truncate">
                                    <i class="bx bxs-file-pdf mr-1 text-lg"></i> Ver Archivo PDF
                                </a>
                            </div>

                            {{-- DATOS Y ACCIONES --}}
                            <div class="flex flex-wrap items-center gap-6 lg:gap-8">
                                
                                {{-- ESTADO --}}
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-1">Estado</p>
                                    @if ($boletin->publicado)
                                        <x-badge color="emerald" class="py-0.5 px-2 text-xs">
                                            <i class="bx bx-check mr-1"></i> Publicado
                                        </x-badge>
                                    @else
                                        <x-badge color="gray" class="py-0.5 px-2 text-xs">
                                            <i class="bx bx-time mr-1"></i> Borrador
                                        </x-badge>
                                    @endif
                                </div>

                                {{-- FECHA --}}
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-1">Publicación</p>
                                    <p class="text-sm font-medium text-gray-700 dark:text-neutral-300">{{ $boletin->fecha_publicacion->format('d/m/Y') }}</p>
                                </div>

                                {{-- ACCIONES --}}
                                <div class="flex items-center gap-2 border-l border-gray-200 dark:border-neutral-700 pl-6">
                                    <form action="{{ route('admin.boletines.publicar', $boletin->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                            class="text-gray-500 hover:text-{{ $boletin->publicado ? 'orange' : 'emerald' }}-600 transition-colors bg-white hover:bg-{{ $boletin->publicado ? 'orange' : 'emerald' }}-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700" 
                                            title="{{ $boletin->publicado ? 'Ocultar' : 'Publicar' }}">
                                            <i class="bx {{ $boletin->publicado ? 'bx-hide' : 'bx-show' }} text-lg"></i>
                                        </button>
                                    </form>

                                    <button type="button" 
                                        class="btn-edit text-gray-500 hover:text-blue-600 transition-colors bg-white hover:bg-blue-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-blue-900/30"
                                        data-url="{{ route('admin.boletines.index') }}/{{ $boletin->id }}"
                                        data-id="{{ $boletin->id }}"
                                        data-titulo="{{ $boletin->titulo }}"
                                        data-fecha="{{ $boletin->fecha_publicacion->format('Y-m-d') }}"
                                        title="Editar">
                                        <i class="bx bx-edit text-lg"></i>
                                    </button>
                                    
                                    <button type="button" 
                                        class="btn-delete text-gray-500 hover:text-red-600 transition-colors bg-white hover:bg-red-50 size-9 flex items-center justify-center rounded-lg border border-gray-200 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-red-900/30"
                                        data-url="{{ route('admin.boletines.eliminar', $boletin->id) }}"
                                        data-nombre="{{ $boletin->titulo }}"
                                        title="Eliminar">
                                        <i class="bx bx-trash text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-card>
                @empty
                    <div class="p-12 text-center border-2 border-dashed border-gray-300 dark:border-neutral-700 rounded-2xl">
                        <div class="size-16 mx-auto bg-gray-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4">
                            <i class="bx bx-news text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No hay boletines</h3>
                        <p class="mt-1 text-gray-500 dark:text-neutral-400">Aún no se han registrado boletines informativos.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $boletines->links() }}
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
                        <i class="bx bx-news text-xl text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <h3 id="modal-title" class="font-bold text-gray-900 dark:text-white">Subir Boletín</h3>
                </div>
                <button type="button" id="btn-close-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-neutral-200 transition-colors">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>
            <form id="form-boletin" action="{{ route('admin.boletines.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="space-y-4 p-6">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Título del Boletín <span class="text-red-500">*</span></label>
                        <input type="text" name="titulo" id="input-titulo" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required placeholder="Ej. Boletín N° 15 - Logros de Mayo">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Fecha de Publicación <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha_publicacion" id="input-fecha" class="w-full py-2.5 px-3 block border-gray-200 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-neutral-300">Archivo PDF <span id="pdf-required-mark" class="text-red-500">*</span></label>
                        <input type="file" name="archivo_pdf" id="archivo_pdf" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" required>
                        <p class="text-xs text-gray-500 mt-1" id="pdf-help-text">Solo formato PDF. Tamaño máximo 20MB.</p>
                    </div>

                    <!-- Hidden input para la imagen extraída por JS -->
                    <input type="hidden" id="imagen_base64" name="imagen_base64" value="">
                </div>
                <div class="flex justify-end gap-3 border-t px-6 py-4 dark:border-neutral-700">
                    <button type="button" id="btn-cancelar" class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">Cancelar</button>
                    <button type="submit" id="btn_guardar" class="py-2 px-4 text-sm font-semibold rounded-lg bg-teal-600 text-white hover:bg-teal-700 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-save"></i> <span id="btn_text">Guardar</span>
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
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Boletín</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-2">¿Confirmas que deseas eliminar permanentemente el boletín:</p>
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

    <!-- Script para extraer portadas de los PDF -->
    <script type="module" src="{{ asset('js/pdf-extractor.js') }}?v={{ time() }}"></script>

    @push('page-scripts')
        @vite('resources/js/admin-boletines.js')
    @endpush
    
    <style nonce="{{ app('csp-nonce') }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endsection
