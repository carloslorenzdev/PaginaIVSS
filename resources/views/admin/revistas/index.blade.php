@extends('layouts/app')

@section('titulo', 'Revistas Digitales')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
            <div>
                <x-titulo titulo="Revistas Digitales" class="text-gradient font-extrabold text-3xl" />
                <x-breadcrumb class="mt-2">
                    <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                        Panel
                    </x-breadcrumb.item>
                    <x-breadcrumb.current>
                        Revistas Digitales
                    </x-breadcrumb.current>
                </x-breadcrumb>
            </div>
            
            <button id="btn-nueva-revista" data-url="{{ route('admin.revistas.guardar') }}"
                class="rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white hover:from-teal-700 hover:to-teal-600 shadow-md hover:shadow-lg shadow-teal-500/30 hover:-translate-y-0.5 transition-all duration-300 font-semibold px-5 py-2.5 flex items-center gap-2">
                <i class="bx bx-upload text-lg"></i>
                <span>Subir Revista</span>
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

        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-neutral-700 p-5 bg-gray-50/50 dark:bg-neutral-800/50">
                <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-teal-100 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center">
                        <i class="bx bx-book-open text-lg"></i>
                    </div>
                    Listado de Revistas
                </h3>
            </div>

            <div class="p-5 space-y-4">
                @forelse($revistas as $revista)
                    <div class="p-5 rounded-xl border border-gray-100 dark:border-neutral-700 searchable-item hover:bg-gray-50/80 dark:hover:bg-neutral-700/50 hover:shadow-md transition-all duration-300">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            
                            {{-- TÍTULO Y ARCHIVO --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 dark:text-white text-base truncate mb-1">
                                    {{ $revista->titulo }}
                                </p>
                                <a href="{{ asset('storage/' . $revista->archivo_pdf) }}" target="_blank" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 px-3 py-1.5 rounded-lg transition-colors truncate">
                                    <i class="bx bxs-file-pdf mr-1.5 text-lg"></i> Ver Archivo PDF
                                </a>
                            </div>

                            {{-- DATOS Y ACCIONES --}}
                            <div class="flex flex-wrap items-center gap-6 lg:gap-8">
                                
                                {{-- ESTADO --}}
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1.5">Estado</p>
                                    @if ($revista->publicado)
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            <i class="bx bx-check-circle"></i> Publicado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-neutral-700 dark:text-neutral-300">
                                            <i class="bx bx-time"></i> Borrador
                                        </span>
                                    @endif
                                </div>

                                {{-- EDICIÓN --}}
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1.5">Edición</p>
                                    <p class="text-sm font-bold text-gray-800 dark:text-neutral-200">{{ $revista->edicion ?? 'N/A' }}</p>
                                </div>

                                {{-- FECHA --}}
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1.5">Publicación</p>
                                    <p class="text-sm font-bold text-gray-800 dark:text-neutral-200">{{ $revista->fecha_publicacion->format('d/m/Y') }}</p>
                                </div>

                                {{-- ACCIONES --}}
                                <div class="flex items-center gap-2 border-l border-gray-100 dark:border-neutral-700 pl-6">
                                    <form action="{{ route('admin.revistas.publicar', $revista->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                            class="size-9 flex items-center justify-center rounded-xl bg-white border border-gray-200 shadow-sm transition-all text-gray-500 hover:text-{{ $revista->publicado ? 'orange' : 'emerald' }}-600 hover:bg-{{ $revista->publicado ? 'orange' : 'emerald' }}-50 hover:border-{{ $revista->publicado ? 'orange' : 'emerald' }}-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700" 
                                            title="{{ $revista->publicado ? 'Ocultar' : 'Publicar' }}">
                                            <i class="bx {{ $revista->publicado ? 'bx-hide' : 'bx-show' }} text-lg"></i>
                                        </button>
                                    </form>

                                    <button type="button" 
                                        class="btn-edit size-9 flex items-center justify-center rounded-xl bg-white border border-gray-200 shadow-sm transition-all text-gray-500 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700"
                                        data-url="{{ route('admin.revistas.index') }}/{{ $revista->id }}"
                                        data-id="{{ $revista->id }}"
                                        data-titulo="{{ $revista->titulo }}"
                                        data-edicion="{{ $revista->edicion }}"
                                        data-fecha="{{ $revista->fecha_publicacion->format('Y-m-d') }}"
                                        title="Editar">
                                        <i class="bx bx-edit text-lg"></i>
                                    </button>
                                    
                                    <button type="button" 
                                        class="btn-delete size-9 flex items-center justify-center rounded-xl bg-white border border-gray-200 shadow-sm transition-all text-gray-500 hover:text-red-600 hover:bg-red-50 hover:border-red-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700"
                                        data-url="{{ route('admin.revistas.eliminar', $revista->id) }}"
                                        data-nombre="{{ $revista->titulo }}"
                                        title="Eliminar">
                                        <i class="bx bx-trash text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-16 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700 rounded-2xl bg-gray-50/50 dark:bg-neutral-900/20">
                        <div class="size-20 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4 shadow-sm">
                            <i class="bx bx-book-open text-4xl text-gray-400 dark:text-neutral-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">No hay revistas</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">Aún no se han registrado revistas digitales.</p>
                    </div>
                @endforelse
            </div>

            @if($revistas->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-neutral-700 bg-gray-50/30 dark:bg-neutral-800/50">
                    {{ $revistas->links() }}
                </div>
            @endif
        </div>
    </x-section>

    {{-- MODAL CREATE/EDIT --}}
    <div id="modal-create" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modal-backdrop"></div>
        <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl dark:bg-neutral-800 animate-modal overflow-hidden">
            <div class="flex items-center justify-between border-b px-6 py-4 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-book-open text-xl text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <h3 id="modal-title" class="font-bold text-gray-900 dark:text-white text-lg">Subir Revista</h3>
                </div>
                <button type="button" id="btn-close-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-neutral-200 transition-colors">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>
            <form id="form-revista" action="{{ route('admin.revistas.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="space-y-5 p-6">
                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Título de la Revista <span class="text-red-500">*</span></label>
                        <input type="text" name="titulo" id="input-titulo" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required placeholder="Ej. Revista Institucional">
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Edición</label>
                            <input type="text" name="edicion" id="input-edicion" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" placeholder="Ej. Edición N° 15">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Fecha de Publicación <span class="text-red-500">*</span></label>
                            <input type="date" name="fecha_publicacion" id="input-fecha" class="w-full py-2.5 px-3 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="bg-gray-50/50 dark:bg-neutral-900/20 p-4 rounded-xl border border-gray-100 dark:border-neutral-700/50">
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-neutral-300">Archivo PDF <span id="pdf-required-mark" class="text-red-500">*</span></label>
                        <input type="file" name="archivo_pdf" id="archivo_pdf" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 file:transition-colors dark:file:bg-teal-900/30 dark:file:text-teal-400" required>
                        <p class="text-xs text-gray-500 mt-2" id="pdf-help-text"><i class="bx bx-info-circle"></i> Solo formato PDF. Tamaño máximo 20MB.</p>
                    </div>

                    <!-- Hidden input para la imagen extraída por JS -->
                    <input type="hidden" id="imagen_base64" name="imagen_base64" value="">
                </div>
                <div class="flex justify-end gap-3 border-t border-gray-100 px-6 py-4 dark:border-neutral-700 bg-gray-50/30 dark:bg-neutral-800/50">
                    <button type="button" id="btn-cancelar" class="py-2.5 px-5 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-700 searchable-item hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 transition-all">Cancelar</button>
                    <button type="submit" id="btn_guardar" class="py-2.5 px-5 text-sm font-semibold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white hover:from-teal-700 hover:to-teal-600 shadow-md transition-all inline-flex items-center gap-2">
                        <i class="bx bx-save text-lg"></i> <span id="btn_text">Guardar</span>
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
                <div class="size-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-trash text-2xl text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Revista</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-2">¿Confirmas que deseas eliminar permanentemente la revista:</p>
            <p class="font-semibold text-gray-900 dark:text-white mb-5 italic" id="modal-eliminar-nombre"></p>
            
            <form id="form-eliminar" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3 justify-end border-t pt-5 dark:border-neutral-700">
                    <button type="button" id="btn-cerrar-eliminar"
                        class="py-2.5 px-5 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-700 searchable-item hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="py-2.5 px-5 text-sm font-semibold rounded-xl bg-red-600 text-white hover:bg-red-700 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-trash"></i> Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script para extraer portadas de los PDF -->
    <script type="module" src="{{ asset('js/pdf-extractor.js') }}?v={{ filemtime(public_path('js/pdf-extractor.js')) }}"></script>

    @push('page-scripts')
        @vite('resources/js/admin-revistas.js')
    @endpush
    
    <style nonce="{{ app('csp-nonce') }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endsection

