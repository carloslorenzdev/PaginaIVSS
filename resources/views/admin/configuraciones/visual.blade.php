@extends('layouts/app')

@section('titulo', 'Configuración Visual')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Configuración Visual del Sitio" class="text-gradient font-extrabold text-3xl" />
        </div>
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
                <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-4">
                        <div class="size-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                            <i class="bx bx-image-alt text-xl"></i>
                        </div>
                        1. Cambiar Membrete (Banner Superior)
                    </h3>
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
                        
                        <div id="membretePreviewContainer" class="hidden bg-gray-50 dark:bg-neutral-800 p-4 border border-gray-200 dark:border-neutral-700 rounded-xl transition-all">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-semibold text-gray-700 dark:text-neutral-300 flex items-center gap-1.5">
                                    <i class="bx bx-check-circle text-green-500"></i> Vista Previa del Nuevo Membrete:
                                </p>
                                <span id="membreteDimensions" class="text-xs font-mono text-gray-500 dark:text-neutral-400 bg-gray-200 dark:bg-neutral-700 px-2 py-0.5 rounded"></span>
                            </div>
                            <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 shadow-sm">
                                <img id="membretePreviewImg" src="" alt="Vista Previa" class="max-w-full h-auto mx-auto block">
                            </div>
                            <p id="membreteResolutionWarning" class="hidden text-xs font-semibold text-amber-600 dark:text-amber-400 mt-2 flex items-center gap-1">
                                <i class="bx bx-error-circle"></i> Advertencia: La resolución de la imagen es baja (<span id="resDimensionsText"></span>). Se recomienda mínimo 800x100 píxeles.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3 pt-3">
                            <button type="button" id="btnPreviewMembreteReal" data-inicio-url="{{ route('inicio') }}" class="py-2.5 px-5 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-md shadow-blue-500/30 hover:shadow-lg transform hover:-translate-y-0.5 disabled:opacity-50 disabled:pointer-events-none">
                                <i class="bx bx-show text-lg"></i> Vista Previa Real
                            </button>
                            <button type="submit" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2 transform hover:-translate-y-0.5">
                                <i class="bx bx-save text-lg"></i> Guardar Membrete
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-neutral-800">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-3">Membrete Actual en Uso</p>
                        @if(isset($configuraciones['membrete_img']))
                            <img src="{{ asset('storage/' . $configuraciones['membrete_img']) }}" alt="Membrete Actual" class="max-w-full h-auto rounded-xl shadow-sm border border-gray-100 dark:border-neutral-700 opacity-90 hover:opacity-100 transition-opacity">
                        @else
                            <img src="{{ asset('imagenes/cintillo ivss_2026.png') }}" alt="Membrete por Defecto" class="max-w-full h-auto rounded-xl shadow-sm border border-gray-100 dark:border-neutral-700 opacity-90 bg-white">
                        @endif
                    </div>
                </div>


            </div>

            {{-- COLUMNA DERECHA --}}
            <div>
                {{-- 3. IMÁGENES DE FONDO --}}
                <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-2xl p-6 shadow-sm h-full">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-4">
                        <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400">
                            <i class="bx bx-images text-xl"></i>
                        </div>
                        3. Imágenes de Fondo (Secciones)
                    </h3>
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400 mb-6">Personaliza las imágenes de fondo que acompañan a cada sección de la página web.</p>
                    
                    <form action="{{ route('admin.config.visual.backgrounds') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="space-y-4">
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
                            <div class="bg-gray-50/50 dark:bg-neutral-800/30 p-4 rounded-xl border border-gray-100 dark:border-neutral-700/50 hover:border-teal-200 transition-colors">
                                <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">{{ $label }}</label>
                                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                                    <input type="file" name="{{ $key }}" accept="image/*" 
                                        class="input-bg-preview block w-full text-sm text-gray-500 dark:text-neutral-400
                                        file:me-3 file:py-2 file:px-3 file:rounded-lg file:border-0
                                        file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 dark:file:bg-teal-900/30 dark:file:text-teal-400
                                        hover:file:bg-teal-100 border border-gray-200 dark:border-neutral-700 rounded-xl p-1 bg-white dark:bg-neutral-900 shadow-sm cursor-pointer transition-colors"
                                        data-preview-target="preview-{{ $key }}">
                                    
                                    <div class="shrink-0 relative group rounded-lg overflow-hidden border border-gray-200 dark:border-neutral-700 shadow-sm bg-gray-100 dark:bg-neutral-800">
                                        <img id="preview-{{ $key }}" src="{{ !empty($configuraciones[$key]) ? asset('storage/' . $configuraciones[$key]) : asset('img/hero-innovation-bg.png') }}" class="h-14 w-24 object-cover transform group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="pt-6 mt-6 border-t border-gray-100 dark:border-neutral-800">
                            <button type="submit" class="w-full py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                                <i class="bx bx-save text-lg"></i> Guardar Fondos
                            </button>
                        </div>
                    </form>
                </div>
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
                    <iframe id="livePreviewFrame" src="" class="w-full h-full border-0 absolute inset-0 opacity-0 transition-opacity duration-300"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script src="{{ asset('js/admin/visual.js') }}" nonce="{{ app('csp-nonce') ?? '' }}"></script>
@endpush
