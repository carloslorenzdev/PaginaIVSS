@extends('layouts/app')

@section('titulo', 'Gestionar Actividad: ' . $actividad->titulo)

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Gestionar Actividad" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.item ruta="{{ route('admin.actividades.index') }}" icono="bx bx-calendar-event">
                Actividades
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                {{ str()->limit($actividad->titulo, 30) }}
            </x-breadcrumb.current>
        </x-breadcrumb>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-5">
            
            {{-- COLUMNA IZQUIERDA: Editar y Subir --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- EDITAR ACTIVIDAD --}}
                <x-card class="p-5">
                    <x-card.title class="border-b border-gray-200 dark:border-neutral-700 pb-3 mb-4">
                        <i class="bx bx-edit"></i> Editar Actividad
                    </x-card.title>
                    
                    <form action="{{ route('admin.actividades.actualizar', $actividad->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input.label for="titulo" value="Título" />
                            <x-input type="text" id="titulo" name="titulo" value="{{ old('titulo', $actividad->titulo) }}" required class="py-2" />
                        </div>

                        <div>
                            <x-input.label for="descripcion" value="Descripción" />
                            <x-input type="hidden" id="descripcion" name="descripcion" />
                            <x-editor id="hs-editor-tiptap" class="min-h-[200px]">
                                {!! old('descripcion', $actividad->descripcion) !!}
                            </x-editor>
                        </div>

                        <div class="bg-gray-50 dark:bg-neutral-800 p-3 rounded-lg border border-gray-200 dark:border-neutral-700">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="activa" value="1" {{ $actividad->activa ? 'checked' : '' }} class="shrink-0 mt-0.5 border-gray-300 rounded text-red-600 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-red-500 dark:checked:border-red-500">
                                <span class="text-sm font-medium text-gray-800 dark:text-neutral-200">Activo (Visible)</span>
                            </label>
                        </div>

                        <x-input.button class="w-full bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 justify-center">
                            <i class="bx bx-sync mr-1"></i> Actualizar Datos
                        </x-input.button>
                    </form>
                </x-card>
                
                {{-- SUBIR MEDIO --}}
                <x-card class="p-5">
                    <x-card.title class="border-b border-gray-200 dark:border-neutral-700 pb-3 mb-4">
                        <i class="bx bx-upload"></i> Subir Archivo
                    </x-card.title>
                    
                    <form action="{{ route('admin.actividades.subir-medio', $actividad->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <x-input.label for="archivo" value="Archivo" />
                            <input type="file" id="archivo" name="archivo" required accept=".jpg,.jpeg,.png,.webp,.gif,.mp4,.avi,.pdf,.doc,.docx"
                                class="block w-full text-sm text-gray-500 dark:text-neutral-400
                                file:me-3 file:py-1.5 file:px-3
                                file:rounded file:border-0
                                file:text-xs file:font-semibold
                                file:bg-gray-100 file:text-gray-700
                                hover:file:bg-gray-200
                                dark:file:bg-neutral-700
                                dark:file:text-neutral-300
                                dark:hover:file:bg-neutral-600">
                        </div>

                        <div>
                            <x-input.label for="tipo_relacion" value="Tipo de Relación" />
                            <select id="tipo_relacion" name="tipo_relacion" class="w-full py-2 px-3 pe-9 block border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option value="principal">Principal</option>
                                <option value="galeria">Galería (Carrusel/Grilla)</option>
                                <option value="adjunto">Documento Adjunto</option>
                            </select>
                        </div>

                        <div>
                            <x-input.label for="leyenda" value="Leyenda (Opcional)" />
                            <x-input type="text" id="leyenda" name="leyenda" class="py-2" />
                        </div>

                        <x-input.button class="w-full bg-teal-600 hover:bg-teal-700 focus:bg-teal-700 justify-center">
                            <i class="bx bx-cloud-upload mr-1"></i> Subir Medio
                        </x-input.button>
                    </form>
                </x-card>
            </div>

            {{-- COLUMNA DERECHA: Archivos Asociados --}}
            <div class="lg:col-span-2">
                <x-card class="p-5 h-full">
                    <div class="flex justify-between items-center border-b border-gray-200 dark:border-neutral-700 pb-3 mb-5">
                        <x-card.title>
                            <i class="bx bx-folder-open"></i> Archivos Multimedia
                        </x-card.title>
                        <x-badge color="gray" class="!rounded-full">{{ $actividad->medios->count() }}</x-badge>
                    </div>
                    
                    @if($actividad->medios->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach($actividad->medios as $medio)
                                <div class="border border-gray-200 dark:border-neutral-700 rounded-lg overflow-hidden relative group bg-white dark:bg-neutral-800">
                                    
                                    {{-- Botón Eliminar --}}
                                      <button type="button" class="btn-confirmar-accion absolute top-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity bg-red-600 hover:bg-red-700 text-white size-8 rounded-full flex items-center justify-center shadow-md focus:outline-none" data-action="{{ route('admin.actividades.eliminar-medio', [$actividad->id, $medio->id]) }}" data-method="DELETE" data-mensaje="¿Eliminar este archivo permanentemente?" title="Eliminar Archivo">
                                          <i class="bx bx-x text-lg"></i>
                                      </button>

                                    {{-- Previsualización --}}
                                    <div class="h-40 bg-gray-100 dark:bg-neutral-900 flex items-center justify-center relative">
                                        @if($medio->tipo === 'imagen')
                                            <img src="{{ asset('storage/' . $medio->ruta) }}" alt="Imagen" class="w-full h-full object-cover">
                                        @elseif($medio->tipo === 'video')
                                            <i class="bx bx-video text-5xl text-gray-400 dark:text-neutral-600"></i>
                                            <span class="absolute bottom-2 left-2 bg-black/60 text-white text-[10px] px-2 py-0.5 rounded uppercase font-bold tracking-wider">Video</span>
                                        @else
                                            <i class="bx bxs-file-pdf text-5xl text-red-500"></i>
                                            <span class="absolute bottom-2 left-2 bg-black/60 text-white text-[10px] px-2 py-0.5 rounded uppercase font-bold tracking-wider">Doc</span>
                                        @endif
                                    </div>
                                    
                                    {{-- Detalles --}}
                                    <div class="p-3">
                                        <p class="text-xs font-semibold text-gray-800 dark:text-neutral-200 truncate" title="{{ $medio->nombre_original }}">{{ $medio->nombre_original }}</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-[10px] text-gray-500 dark:text-neutral-500 uppercase font-bold tracking-wider bg-gray-100 dark:bg-neutral-700 px-1.5 py-0.5 rounded">{{ $medio->pivot->tipo_relacion }}</span>
                                            <span class="text-[10px] text-gray-400 dark:text-neutral-500">{{ round($medio->tamano / 1024, 1) }} KB</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 text-gray-500 dark:text-neutral-500">
                            <i class="bx bx-folder-open text-6xl mb-4 text-gray-300 dark:text-neutral-600"></i>
                            <p>No hay archivos multimedia asociados a esta actividad.</p>
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    </x-section>

    <x-modal-confirmar />
@endsection

@push('page-scripts')
    @vite(['resources/js/editor-config.js'])
@endpush
