@extends('layouts/app')

@section('titulo', 'Gestionar Carrusel')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
            <div>
                <x-titulo titulo="Gestionar Carrusel" class="text-gradient font-extrabold text-3xl" />
                <x-breadcrumb class="mt-2">
                    <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                        Panel
                    </x-breadcrumb.item>
                    <x-breadcrumb.current>
                        Carrusel
                    </x-breadcrumb.current>
                </x-breadcrumb>
            </div>
        </div>

        {{-- VELOCIDAD DEL CARRUSEL --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 p-6 mb-8 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-indigo-500 to-purple-500"></div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 ml-2">
                <div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                        <i class="bx bx-timer text-indigo-500 text-xl"></i> Velocidad del Carrusel
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1.5 font-medium">Ajusta el tiempo que dura cada imagen en pantalla antes de pasar a la siguiente.</p>
                </div>
                <form action="{{ route('admin.carrusel.velocidad') }}" method="POST" class="flex items-center gap-3 w-full md:w-auto">
                    @csrf
                    <div class="flex-grow md:w-64">
                        <select name="intervalo" class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                            <option value="2000" {{ $intervalo == 2000 ? 'selected' : '' }}>2 Segundos (Rápido)</option>
                            <option value="3000" {{ $intervalo == 3000 ? 'selected' : '' }}>3 Segundos</option>
                            <option value="5000" {{ $intervalo == 5000 ? 'selected' : '' }}>5 Segundos (Normal)</option>
                            <option value="8000" {{ $intervalo == 8000 ? 'selected' : '' }}>8 Segundos (Lento)</option>
                            <option value="12000" {{ $intervalo == 12000 ? 'selected' : '' }}>12 Segundos</option>
                        </select>
                    </div>
                    <button type="submit" class="py-2.5 px-5 shrink-0 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-gray-800 text-white hover:bg-gray-900 shadow-md hover:shadow-lg transition-all dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100">
                        Guardar
                    </button>
                </form>
            </div>
        </div>

        {{-- LISTADO DE IMÁGENES DEL CARRUSEL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($carruseles as $carrusel)
                <div class="bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden flex flex-col group/card border border-gray-100 dark:border-neutral-700 shadow-sm hover:shadow-xl hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300 hover:-translate-y-1 relative">
                    <div class="relative h-48 w-full bg-gray-50 dark:bg-neutral-900/50 overflow-hidden">
                        <img src="{{ asset('storage/' . $carrusel->imagen_ruta) }}" alt="Carrusel" class="w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-105">
                        
                        {{-- BOTONES ACCIÓN (Hover) --}}
                        <div class="absolute top-3 right-3 opacity-0 group-hover/card:opacity-100 transition-opacity duration-300 flex gap-2">
                            <button type="button" class="btn-toggle-edit bg-white/90 dark:bg-neutral-800/90 text-indigo-600 dark:text-indigo-400 w-10 h-10 rounded-xl flex items-center justify-center hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-500 dark:hover:text-white shadow-lg backdrop-blur-sm transition-all transform scale-90 hover:scale-100" data-id="{{ $carrusel->id }}" title="Editar detalles">
                                <i class="bx bx-pencil text-lg"></i>
                            </button>
                            <button type="button" class="btn-confirmar-accion bg-white/90 dark:bg-neutral-800/90 text-red-600 dark:text-red-400 w-10 h-10 rounded-xl flex items-center justify-center hover:bg-red-600 hover:text-white dark:hover:bg-red-500 dark:hover:text-white shadow-lg backdrop-blur-sm transition-all transform scale-90 hover:scale-100" data-action="{{ route('admin.carrusel.eliminar', $carrusel->id) }}" data-method="DELETE" data-mensaje="¿Eliminar esta imagen del carrusel?" title="Eliminar del carrusel">
                                <i class="bx bx-trash text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="p-5 flex-grow flex flex-col bg-white dark:bg-neutral-800">
                        {{-- VISTA DE LECTURA --}}
                        <div id="title-display-{{ $carrusel->id }}" class="space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-2.5 py-1 rounded-md dark:bg-indigo-900/40 dark:text-indigo-300 w-fit shrink-0 flex items-center gap-1">
                                    <i class="bx bx-sort-alt-2"></i> Orden: {{ $carrusel->orden }}
                                </span>
                                @if($carrusel->enlace)
                                    <span class="truncate text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-md flex items-center">
                                        <i class="bx bx-link-external mr-1"></i> {{ $carrusel->enlace }}
                                    </span>
                                @else
                                    <span class="truncate text-xs font-medium text-gray-400 dark:text-neutral-500 flex items-center">
                                        <i class="bx bx-unlink mr-1"></i> Sin enlace
                                    </span>
                                @endif
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 text-base">
                                {{ $carrusel->titulo ?? 'Sin título' }}
                            </h3>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <p class="text-xs font-medium text-gray-500 dark:text-neutral-400 flex items-center">
                                    <i class="bx bx-purchase-tag mr-1 text-gray-400"></i> {{ $carrusel->etiquetas ?? 'Sin etiquetas' }}
                                </p>
                                @if($carrusel->fecha_publicacion)
                                    <p class="text-xs font-medium text-gray-500 dark:text-neutral-400 flex items-center ml-2 border-l pl-3 border-gray-200 dark:border-neutral-700">
                                        <i class="bx bx-calendar mr-1 text-gray-400"></i> {{ \Carbon\Carbon::parse($carrusel->fecha_publicacion)->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- FORMULARIO EDICIÓN (Oculto) --}}
                        <form action="{{ route('admin.carrusel.actualizar', $carrusel->id) }}" method="POST" id="form-edit-{{ $carrusel->id }}" class="hidden flex-col gap-4 bg-gray-50/50 dark:bg-neutral-900/30 p-4 rounded-xl border border-gray-100 dark:border-neutral-700/50">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-neutral-300 mb-1.5">Título</label>
                                <input type="text" name="titulo" value="{{ $carrusel->titulo }}" placeholder="Título de la imagen" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300" />
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-neutral-300 mb-1.5">Enlace (URL)</label>
                                <input type="url" name="enlace" value="{{ $carrusel->enlace }}" placeholder="https://..." class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300" />
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-neutral-300 mb-1.5">Etiquetas</label>
                                <input type="text" name="etiquetas" value="{{ $carrusel->etiquetas }}" placeholder="Ej. DESTACADAS, SALUD" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300" />
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-neutral-300 mb-1.5">Fecha Pub.</label>
                                    <input type="date" name="fecha_publicacion" value="{{ $carrusel->fecha_publicacion ? \Carbon\Carbon::parse($carrusel->fecha_publicacion)->format('Y-m-d') : '' }}" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-neutral-300 mb-1.5">Orden</label>
                                    <input type="number" name="orden" value="{{ $carrusel->orden }}" placeholder="1" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300" />
                                </div>
                            </div>
                            
                            <div class="pt-3 flex justify-end gap-2 border-t border-gray-200 dark:border-neutral-700 mt-2">
                                <button type="button" class="btn-toggle-edit py-2 px-4 inline-flex items-center gap-x-2 text-xs font-semibold rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-colors" data-id="{{ $carrusel->id }}">
                                    Cancelar
                                </button>
                                <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 text-xs font-bold rounded-lg border border-transparent bg-gradient-to-r from-indigo-600 to-indigo-500 text-white hover:from-indigo-700 hover:to-indigo-600 shadow-md shadow-indigo-500/30 transition-all">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
            
            {{-- TARJETA: AÑADIR NUEVA IMAGEN --}}
            <div class="bg-gray-50/50 dark:bg-neutral-900/20 border-2 border-dashed border-indigo-200 dark:border-indigo-900/50 rounded-2xl flex flex-col items-center justify-center h-full min-h-[350px] cursor-pointer hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 hover:border-indigo-400 dark:hover:border-indigo-500 transition-all duration-300 group relative shadow-sm hover:shadow-md" onclick="document.getElementById('file-upload').click()">
                <div class="text-center p-8">
                    <div class="bg-white dark:bg-neutral-800 size-20 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm group-hover:scale-110 group-hover:shadow-indigo-500/20 transition-all duration-300">
                        <i class="bx bx-plus text-4xl text-indigo-500 group-hover:text-indigo-600"></i>
                    </div>
                    <p class="text-indigo-900 dark:text-indigo-100 font-bold text-xl mb-1">Añadir Imagen</p>
                    <p class="text-indigo-500/80 dark:text-indigo-400/80 font-medium text-sm mt-2 flex items-center justify-center gap-1"><i class="bx bx-expand"></i> 1920x600 px</p>
                    <p class="text-gray-400 dark:text-neutral-500 text-xs mt-2 bg-white/50 dark:bg-neutral-800/50 px-3 py-1 rounded-full inline-block">JPG, PNG, WEBP (Máx 5MB)</p>
                </div>
                
                <form action="{{ route('admin.carrusel.guardar') }}" method="POST" enctype="multipart/form-data" class="hidden" id="upload-form">
                    @csrf
                    <input type="file" id="file-upload" name="archivo" accept="image/*" class="hidden" onchange="document.getElementById('upload-loader').classList.remove('hidden'); this.form.submit()">
                </form>

                {{-- LOADER --}}
                <div id="upload-loader" class="absolute inset-0 bg-white/90 dark:bg-neutral-900/90 flex flex-col items-center justify-center hidden rounded-2xl z-10 backdrop-blur-sm">
                    <div class="animate-spin inline-block size-12 border-[4px] border-current border-t-transparent text-indigo-600 rounded-full dark:text-indigo-500" role="status" aria-label="loading">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <span class="text-sm font-bold text-gray-800 dark:text-neutral-200 mt-4 tracking-wide">Subiendo imagen...</span>
                </div>
            </div>
        </div>
    </x-section>

    <x-modal-confirmar />
@endsection

@push('page-scripts')
    <script src="{{ asset('js/admin/carrusel.js') }}?v={{ filemtime(public_path('js/admin/carrusel.js')) }}" nonce="{{ app('csp-nonce') ?? '' }}"></script>
@endpush

