@extends('layouts/app')

@section('titulo', 'Configuración Visual')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Configuración Visual del Sitio" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Configuración Visual
            </x-breadcrumb.current>
        </x-breadcrumb>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-5">
            
            {{-- COLUMNA IZQUIERDA --}}
            <div class="space-y-6">
                
                {{-- 1. MEMBRETE --}}
                <x-card class="p-5">
                    <x-card.title class="mb-4">
                        <i class="bx bx-image-alt"></i> 1. Cambiar Membrete (Banner Superior)
                    </x-card.title>
                    <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">La imagen debe tener buena resolución para evitar distorsiones (Mínimo recomendado 800x100 píxeles). La vista previa se mostrará automáticamente al seleccionar la imagen.</p>
                    
                    <form action="{{ route('admin.config.visual.membrete') }}" method="POST" enctype="multipart/form-data" id="formMembrete" class="space-y-4">
                        @csrf
                        <div>
                            <input type="file" name="membrete_img" id="membrete_img" accept="image/*" required
                                class="block w-full text-sm text-gray-500 dark:text-neutral-400
                                file:me-3 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-red-600 file:text-white
                                hover:file:bg-red-700
                                dark:file:bg-red-500 dark:hover:file:bg-red-400">
                        </div>
                        
                        <div id="membretePreviewContainer" class="hidden bg-gray-50 dark:bg-neutral-800 p-4 border border-gray-200 dark:border-neutral-700 rounded-lg">
                            <p class="text-sm font-semibold text-gray-600 dark:text-neutral-300 mb-2">Vista Previa del Nuevo Membrete:</p>
                            <img id="membretePreviewImg" src="" alt="Vista Previa" class="max-w-full h-auto rounded shadow-sm">
                        </div>

                        <div class="flex flex-wrap gap-2 pt-2">
                            <button type="button" id="btnPreviewMembreteReal" data-inicio-url="{{ route('inicio') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                <i class="bx bx-show text-lg"></i> Vista Previa Real
                            </button>
                            <x-input.button class="bg-red-600 hover:bg-red-700 focus:bg-red-700">
                                <i class="bx bx-save mr-1"></i> Guardar Membrete
                            </x-input.button>
                        </div>
                    </form>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-neutral-700">
                        <p class="text-sm font-semibold text-gray-600 dark:text-neutral-300 mb-2">Membrete Actual en Uso:</p>
                        @if(isset($configuraciones['membrete_img']))
                            <img src="{{ asset('storage/' . $configuraciones['membrete_img']) }}" alt="Membrete Actual" class="max-w-full h-auto rounded shadow-sm opacity-80 hover:opacity-100 transition-opacity">
                        @else
                            <img src="{{ asset('imagenes/cintillo ivss_2026.png') }}" alt="Membrete por Defecto" class="max-w-full h-auto rounded shadow-sm opacity-80 bg-white">
                        @endif
                    </div>
                </x-card>


            </div>

            {{-- COLUMNA DERECHA --}}
            <div>
                {{-- 3. IMÁGENES DE FONDO --}}
                <x-card class="p-5 h-full">
                    <x-card.title class="mb-4 border-b border-gray-200 dark:border-neutral-700 pb-3">
                        <i class="bx bx-images"></i> 3. Imágenes de Fondo (Secciones)
                    </x-card.title>
                    <p class="text-sm text-gray-500 dark:text-neutral-400 mb-5">Personaliza las imágenes de fondo que acompañan a cada sección de la página web.</p>
                    
                    <form action="{{ route('admin.config.visual.backgrounds') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="space-y-5">
                            @php
                                $bgs = [
                                    'bg_consultas' => 'Fondo Consultas',
                                    'bg_tiuna' => 'Fondo Sistema Tiuna',
                                    'bg_farmacias' => 'Fondo Farmacias de Alto Costo',
                                    'bg_centros_salud' => 'Fondo Centros de Salud',
                                    'bg_oficinas' => 'Fondo Oficinas Administrativas',
                                    'bg_servicios_funcionario' => 'Fondo Servicios al Funcionario'
                                ];
                            @endphp

                            @foreach($bgs as $key => $label)
                            <div class="bg-gray-50 dark:bg-neutral-800/50 p-4 rounded-lg border border-gray-200 dark:border-neutral-700">
                                <x-input.label class="mb-2" value="{{ $label }}" />
                                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                                    <input type="file" name="{{ $key }}" accept="image/*" 
                                        class="block w-full text-sm text-gray-500 dark:text-neutral-400
                                        file:me-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0
                                        file:text-xs file:font-semibold file:bg-white file:text-gray-700
                                        hover:file:bg-gray-100 border border-gray-200 dark:border-neutral-700 rounded-lg p-1 bg-white dark:bg-neutral-900">
                                    
                                    @if(!empty($configuraciones[$key]))
                                        <div class="shrink-0 relative group">
                                            <img src="{{ asset('storage/' . $configuraciones[$key]) }}" class="h-12 w-20 object-cover rounded shadow-sm border border-gray-200 dark:border-neutral-700">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200 dark:border-neutral-700">
                            <x-input.button class="w-full bg-red-600 hover:bg-red-700 focus:bg-red-700 justify-center">
                                <i class="bx bx-save mr-1"></i> Guardar Fondos
                            </x-input.button>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </x-section>

    {{-- Botón Oculto para abrir el modal desde JS --}}
    <button type="button" id="hiddenPreviewBtn" class="hidden" data-hs-overlay="#previewModal"></button>

    {{-- MODAL VISTA PREVIA (Iframe) --}}
    <div id="previewModal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none bg-black/80 backdrop-blur-sm" role="dialog" tabindex="-1">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-7xl sm:w-full m-3 sm:mx-auto h-[calc(100%-3.5rem)] flex flex-col justify-center">
            <div class="max-h-full overflow-hidden flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700 bg-gray-900 text-white">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <i class="bx bx-show text-xl"></i> Vista Previa en Tiempo Real
                    </h3>
                    <button type="button" id="closePreviewModal" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-800 text-white hover:bg-gray-700 focus:outline-none" data-hs-overlay="#previewModal">
                        <span class="sr-only">Close</span>
                        <i class="bx bx-x text-xl"></i>
                    </button>
                </div>
                <div class="p-0 overflow-y-auto flex-grow relative h-[80vh]">
                    {{-- Loader --}}
                    <div id="iframeLoader" class="absolute inset-0 flex flex-col justify-center items-center bg-gray-100 dark:bg-neutral-900 z-10">
                        <div class="animate-spin inline-block size-10 border-[3px] border-current border-t-transparent text-red-600 rounded-full dark:text-red-500" role="status" aria-label="loading">
                            <span class="sr-only">Cargando...</span>
                        </div>
                        <span class="mt-2 text-sm font-semibold text-gray-700 dark:text-neutral-300">Cargando vista previa...</span>
                    </div>
                    <iframe id="livePreviewFrame" src="" class="w-full h-full border-0 absolute inset-0 opacity-0 transition-opacity duration-300" onload="handleIframeLoad()"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/visual.js') }}" nonce="{{ app('csp-nonce') ?? '' }}"></script>
@endpush
