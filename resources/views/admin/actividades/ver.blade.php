@extends('layouts/app')

@section('titulo', 'Gestionar Actividad: ' . $actividad->titulo)

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div>
            <x-titulo titulo="Gestionar Actividad" class="text-gradient font-extrabold text-3xl" />
            <x-breadcrumb class="mt-2">
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
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-5">
            
            {{-- COLUMNA IZQUIERDA: Editar y Subir --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- EDITAR ACTIVIDAD --}}
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
                    <div class="border-b border-gray-100 dark:border-neutral-700 px-5 py-4 bg-gray-50/50 dark:bg-neutral-800/50">
                        <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                            <div class="size-7 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center">
                                <i class="bx bx-edit text-base"></i>
                            </div>
                            Editar Actividad
                        </h3>
                    </div>
                    
                    <form action="{{ route('admin.actividades.actualizar', $actividad->id) }}" method="POST" class="p-5 space-y-5">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input.label for="titulo" value="Título" class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block" />
                            <x-input type="text" id="titulo" name="titulo" value="{{ old('titulo', $actividad->titulo) }}" required class="py-2.5 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" />
                        </div>

                        <div>
                            <x-input.label for="descripcion" value="Descripción" class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block" />
                            <x-input type="hidden" id="descripcion" name="descripcion" />
                            <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-neutral-700">
                                <x-editor id="hs-editor-tiptap" class="min-h-[200px]">
                                    {!! old('descripcion', $actividad->descripcion) !!}
                                </x-editor>
                            </div>
                        </div>

                        <div class="bg-blue-50/50 dark:bg-blue-900/10 p-4 rounded-xl border border-blue-100 dark:border-blue-900/30">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="activa" value="1" {{ $actividad->activa ? 'checked' : '' }} class="shrink-0 size-5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 transition-all">
                                <span class="text-sm font-bold text-gray-800 dark:text-neutral-200">Activo (Visible al público)</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white hover:from-blue-700 hover:to-blue-600 shadow-md hover:shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 transition-all duration-300 font-semibold py-2.5 flex justify-center items-center gap-2">
                            <i class="bx bx-sync text-lg"></i> Actualizar Datos
                        </button>
                    </form>
                </div>
                
                {{-- SUBIR MEDIO --}}
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
                    <div class="border-b border-gray-100 dark:border-neutral-700 px-5 py-4 bg-gray-50/50 dark:bg-neutral-800/50">
                        <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                            <div class="size-7 rounded-lg bg-teal-100 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center">
                                <i class="bx bx-upload text-base"></i>
                            </div>
                            Subir Archivo
                        </h3>
                    </div>
                    
                    <form action="{{ route('admin.actividades.subir-medio', $actividad->id) }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-5">
                        @csrf
                        <div class="bg-gray-50/50 dark:bg-neutral-900/20 p-4 rounded-xl border border-gray-100 dark:border-neutral-700/50">
                            <x-input.label for="archivo" value="Archivo" class="font-semibold text-gray-700 dark:text-neutral-300 mb-2 block" />
                            <input type="file" id="archivo" name="archivo" required accept=".jpg,.jpeg,.png,.webp,.gif,.mp4,.avi,.pdf,.doc,.docx"
                                class="block w-full text-sm text-gray-500 dark:text-neutral-400
                                file:me-3 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-xs file:font-semibold
                                file:bg-teal-50 file:text-teal-700
                                hover:file:bg-teal-100
                                dark:file:bg-teal-900/30
                                dark:file:text-teal-400
                                dark:hover:file:bg-teal-900/50 file:transition-colors">
                        </div>

                        <div>
                            <x-input.label for="tipo_relacion" value="Tipo de Relación" class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block" />
                            <select id="tipo_relacion" name="tipo_relacion" class="w-full py-2.5 px-3 pe-9 block border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option value="principal">Principal</option>
                                <option value="galeria">Galería (Carrusel/Grilla)</option>
                                <option value="adjunto">Documento Adjunto</option>
                            </select>
                        </div>

                        <div>
                            <x-input.label for="leyenda" value="Leyenda (Opcional)" class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block" />
                            <x-input type="text" id="leyenda" name="leyenda" class="py-2.5 rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500" />
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white hover:from-teal-700 hover:to-teal-600 shadow-md hover:shadow-lg shadow-teal-500/30 hover:-translate-y-0.5 transition-all duration-300 font-semibold py-2.5 flex justify-center items-center gap-2">
                            <i class="bx bx-cloud-upload text-lg"></i> Subir Medio
                        </button>
                    </form>
                </div>
            </div>

            {{-- COLUMNA DERECHA: Archivos Asociados --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden h-full">
                    <div class="flex justify-between items-center border-b border-gray-100 dark:border-neutral-700 px-6 py-4 bg-gray-50/50 dark:bg-neutral-800/50">
                        <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                            <div class="size-8 rounded-lg bg-orange-100 dark:bg-orange-900/30 text-orange-600 flex items-center justify-center">
                                <i class="bx bx-folder-open text-lg"></i>
                            </div>
                            Archivos Multimedia
                        </h3>
                        <span class="inline-flex items-center justify-center size-8 rounded-full bg-gray-200 dark:bg-neutral-700 text-sm font-bold text-gray-700 dark:text-neutral-300">
                            {{ $actividad->medios->count() }}
                        </span>
                    </div>
                    
                    <div class="p-6">
                        @if($actividad->medios->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                                @foreach($actividad->medios as $medio)
                                    <div class="border border-gray-100 dark:border-neutral-700 rounded-xl overflow-hidden relative group bg-white dark:bg-neutral-900/50 hover:shadow-md hover:border-orange-200 dark:hover:border-orange-900/50 transition-all duration-300">
                                        
                                        {{-- Botón Eliminar --}}
                                          <button type="button" class="btn-confirmar-accion absolute top-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity bg-red-600 hover:bg-red-700 text-white size-8 rounded-full flex items-center justify-center shadow-lg focus:outline-none hover:scale-110" data-action="{{ route('admin.actividades.eliminar-medio', [$actividad->id, $medio->id]) }}" data-method="DELETE" data-mensaje="¿Eliminar este archivo permanentemente?" title="Eliminar Archivo">
                                              <i class="bx bx-trash text-sm"></i>
                                          </button>
    
                                        {{-- Previsualización --}}
                                        <div class="h-44 bg-gray-50 dark:bg-neutral-800 flex items-center justify-center relative overflow-hidden group-hover:bg-gray-100 dark:group-hover:bg-neutral-700 transition-colors">
                                            @if($medio->tipo === 'imagen')
                                                <img src="{{ asset('storage/' . $medio->ruta) }}" alt="Imagen" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @elseif($medio->tipo === 'video')
                                                <div class="size-16 rounded-full bg-black/10 dark:bg-black/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                    <i class="bx bx-play-circle text-5xl text-gray-600 dark:text-neutral-400"></i>
                                                </div>
                                                <span class="absolute bottom-2 left-2 bg-black/70 backdrop-blur-sm text-white text-[10px] px-2 py-0.5 rounded uppercase font-bold tracking-wider shadow-sm">Video</span>
                                            @else
                                                <i class="bx bxs-file-pdf text-6xl text-red-500/80 group-hover:scale-110 transition-transform duration-300"></i>
                                                <span class="absolute bottom-2 left-2 bg-black/70 backdrop-blur-sm text-white text-[10px] px-2 py-0.5 rounded uppercase font-bold tracking-wider shadow-sm">Doc</span>
                                            @endif
                                        </div>
                                        
                                        {{-- Detalles --}}
                                        <div class="p-4 border-t border-gray-100 dark:border-neutral-700">
                                            <p class="text-xs font-semibold text-gray-800 dark:text-neutral-200 truncate mb-2" title="{{ $medio->nombre_original }}">{{ $medio->nombre_original }}</p>
                                            <div class="flex justify-between items-center">
                                                <span class="text-[10px] text-orange-600 dark:text-orange-400 uppercase font-bold tracking-wider bg-orange-50 dark:bg-orange-900/20 px-2 py-1 rounded-md">{{ $medio->pivot->tipo_relacion }}</span>
                                                <span class="text-[10px] font-medium text-gray-400 dark:text-neutral-500 bg-gray-50 dark:bg-neutral-800 px-2 py-1 rounded-md">{{ round($medio->tamano / 1024, 1) }} KB</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-20 text-gray-500 dark:text-neutral-500 border-2 border-dashed border-gray-200 dark:border-neutral-700 rounded-xl">
                                <div class="bg-gray-50 dark:bg-neutral-800 size-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="bx bx-folder-open text-4xl text-gray-400 dark:text-neutral-500"></i>
                                </div>
                                <h4 class="text-gray-800 dark:text-neutral-200 font-bold mb-1">Sin archivos</h4>
                                <p class="text-sm">No hay archivos multimedia asociados a esta actividad.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-section>

    <x-modal-confirmar />
@endsection

@push('page-scripts')
    @vite(['resources/js/editor-config.js'])
@endpush
