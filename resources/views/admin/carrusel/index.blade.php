@extends('layouts/app')

@section('titulo', 'Gestionar Carrusel')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Gestionar Carrusel" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Carrusel
            </x-breadcrumb.current>
        </x-breadcrumb>

        {{-- VELOCIDAD DEL CARRUSEL --}}
        <x-card class="p-5 mb-6 bg-white dark:bg-neutral-800">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-neutral-200">Velocidad del Carrusel</h2>
                    <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Ajusta el tiempo que dura cada imagen en pantalla antes de pasar a la siguiente.</p>
                </div>
                <form action="{{ route('admin.carrusel.velocidad') }}" method="POST" class="flex items-center gap-3 w-full md:w-auto">
                    @csrf
                    <div class="flex-grow md:w-64">
                        <x-input.select name="intervalo" class="py-2.5">
                            <option value="2000" {{ $intervalo == 2000 ? 'selected' : '' }}>2 Segundos (Rápido)</option>
                            <option value="3000" {{ $intervalo == 3000 ? 'selected' : '' }}>3 Segundos</option>
                            <option value="5000" {{ $intervalo == 5000 ? 'selected' : '' }}>5 Segundos (Normal)</option>
                            <option value="8000" {{ $intervalo == 8000 ? 'selected' : '' }}>8 Segundos (Lento)</option>
                            <option value="12000" {{ $intervalo == 12000 ? 'selected' : '' }}>12 Segundos</option>
                        </x-input.select>
                    </div>
                    <x-input.button class="py-2.5 shrink-0 bg-gray-800 hover:bg-gray-900 focus:bg-gray-900 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-200">
                        Guardar
                    </x-input.button>
                </form>
            </div>
        </x-card>

        {{-- LISTADO DE IMÁGENES DEL CARRUSEL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($carruseles as $carrusel)
                <x-card class="overflow-hidden flex flex-col group/card border-2 border-transparent hover:border-red-500 transition-colors">
                    <div class="relative h-48 w-full bg-gray-100 dark:bg-neutral-800">
                        <img src="{{ asset('storage/' . $carrusel->imagen_ruta) }}" alt="Carrusel" class="w-full h-full object-cover">
                        
                        {{-- BOTONES ACCIÓN (Hover) --}}
                        <div class="absolute top-3 right-3 opacity-0 group-hover/card:opacity-100 transition-opacity flex gap-2">
                            <button type="button" onclick="toggleEdit({{ $carrusel->id }})" class="bg-gray-800/90 text-white w-9 h-9 rounded-full flex items-center justify-center hover:bg-black shadow-md focus:outline-none transition-colors" title="Editar detalles">
                                <i class="bx bx-pencil text-base"></i>
                            </button>
                            <form action="{{ route('admin.carrusel.eliminar', $carrusel->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600/90 text-white w-9 h-9 rounded-full flex items-center justify-center hover:bg-red-700 shadow-md focus:outline-none transition-colors" onclick="return confirm('¿Eliminar esta imagen del carrusel?')" title="Eliminar del carrusel">
                                    <i class="bx bx-trash text-base"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="p-4 flex-grow flex flex-col">
                        {{-- VISTA DE LECTURA --}}
                        <div id="title-display-{{ $carrusel->id }}" class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 w-fit shrink-0">Orden: {{ $carrusel->orden }}</span>
                                <span class="truncate text-sm text-gray-500 dark:text-neutral-400">
                                    <i class="bx bx-link mr-1"></i> {{ $carrusel->enlace ?? 'Sin enlace' }}
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-800 dark:text-neutral-200 line-clamp-2">
                                {{ $carrusel->titulo ?? 'Sin título' }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-neutral-500">
                                <i class="bx bx-purchase-tag mr-1"></i> {{ $carrusel->etiquetas ?? 'Sin etiquetas' }}
                            </p>
                            @if($carrusel->fecha_publicacion)
                                <p class="text-xs text-gray-500 dark:text-neutral-500 mt-1">
                                    <i class="bx bx-calendar mr-1"></i> {{ \Carbon\Carbon::parse($carrusel->fecha_publicacion)->format('d/m/Y') }}
                                </p>
                            @endif
                        </div>

                        {{-- FORMULARIO EDICIÓN (Oculto) --}}
                        <form action="{{ route('admin.carrusel.actualizar', $carrusel->id) }}" method="POST" id="form-edit-{{ $carrusel->id }}" class="hidden space-y-3">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-neutral-300 mb-1">Título</label>
                                <x-input type="text" name="titulo" value="{{ $carrusel->titulo }}" placeholder="Título de la noticia" class="py-1.5 px-3 text-sm" />
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-neutral-300 mb-1">Enlace (URL)</label>
                                <x-input type="url" name="enlace" value="{{ $carrusel->enlace }}" placeholder="https://..." class="py-1.5 px-3 text-sm" />
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-neutral-300 mb-1">Etiquetas</label>
                                <x-input type="text" name="etiquetas" value="{{ $carrusel->etiquetas }}" placeholder="Ej. DESTACADAS, SALUD" class="py-1.5 px-3 text-sm" />
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-neutral-300 mb-1">Fecha Pub.</label>
                                    <x-input type="date" name="fecha_publicacion" value="{{ $carrusel->fecha_publicacion ? \Carbon\Carbon::parse($carrusel->fecha_publicacion)->format('Y-m-d') : '' }}" class="py-1.5 px-3 text-sm" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-neutral-300 mb-1">Orden</label>
                                    <x-input type="number" name="orden" value="{{ $carrusel->orden }}" placeholder="1" class="py-1.5 px-3 text-sm" />
                                </div>
                            </div>
                            
                            <div class="pt-2 flex justify-end gap-2 border-t border-gray-200 dark:border-neutral-700 mt-3">
                                <button type="button" onclick="toggleEdit({{ $carrusel->id }})" class="py-1.5 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 transition-colors">
                                    Cancelar
                                </button>
                                <button type="submit" class="py-1.5 px-3 inline-flex items-center gap-x-2 text-xs font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </x-card>
            @endforeach
            
            {{-- TARJETA: AÑADIR NUEVA IMAGEN --}}
            <div class="bg-gray-50/50 dark:bg-neutral-800/30 border-2 border-dashed border-gray-300 dark:border-neutral-700 rounded-xl flex flex-col items-center justify-center h-full min-h-[350px] cursor-pointer hover:bg-gray-100 dark:hover:bg-neutral-800 hover:border-red-400 transition-all group relative" onclick="document.getElementById('file-upload').click()">
                <div class="text-center p-6">
                    <div class="bg-white dark:bg-neutral-900 size-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="bx bx-plus text-3xl text-red-500 group-hover:text-red-600"></i>
                    </div>
                    <p class="text-gray-700 dark:text-neutral-300 font-semibold text-lg">Añadir Imagen</p>
                    <p class="text-gray-400 dark:text-neutral-500 text-sm mt-2">Recomendado: 1920x600 px</p>
                    <p class="text-gray-400 dark:text-neutral-500 text-xs mt-1">Soporta JPG, PNG, WEBP (Máx 5MB)</p>
                </div>
                
                <form action="{{ route('admin.carrusel.guardar') }}" method="POST" enctype="multipart/form-data" class="hidden" id="upload-form">
                    @csrf
                    <input type="file" id="file-upload" name="archivo" accept="image/*" class="hidden" onchange="document.getElementById('upload-loader').classList.remove('hidden'); this.form.submit()">
                </form>

                {{-- LOADER --}}
                <div id="upload-loader" class="absolute inset-0 bg-white/90 dark:bg-neutral-900/90 flex flex-col items-center justify-center hidden rounded-xl z-10 backdrop-blur-sm">
                    <div class="animate-spin inline-block size-10 border-[3px] border-current border-t-transparent text-red-600 rounded-full dark:text-red-500" role="status" aria-label="loading">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200 mt-4">Subiendo imagen...</span>
                </div>
            </div>
        </div>
    </x-section>
@endsection

@push('page-scripts')
    <script>
        function toggleEdit(id) {
            const display = document.getElementById('title-display-' + id);
            const form = document.getElementById('form-edit-' + id);
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                display.classList.add('hidden');
                // Foco al input titulo
                setTimeout(() => form.querySelector('input[name="titulo"]').focus(), 50);
            } else {
                form.classList.add('hidden');
                display.classList.remove('hidden');
            }
        }
    </script>
@endpush
