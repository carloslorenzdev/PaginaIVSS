@extends('layouts.app-public')

@section('titulo', $revista->titulo . ' - Revista Digital IVSS')

@section('content')

<!-- CONTENIDO PRINCIPAL -->
<section class="py-4" style="background-color: #e9ecef; min-height: calc(100vh - 100px);">
    <div class="container-fluid px-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('revista_digital') }}" class="btn btn-outline-secondary rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Volver a Revistas
                </a>
            </div>
            <h3 class="fw-bold text-dark mb-0 text-center flex-grow-1">
                {{ $revista->titulo }} @if($revista->edicion) <span class="text-danger">({{ $revista->edicion }})</span> @endif
            </h3>
            <div>
                <a href="{{ asset('storage/' . $revista->archivo_pdf) }}" target="_blank" class="btn btn-danger rounded-pill fw-bold shadow-sm">
                    <i class="fas fa-download me-2"></i> Descargar PDF
                </a>
            </div>
        </div>

        <!-- CONTENEDOR DEL FLIPBOOK -->
        <div id="flipbook-container" 
             data-pdf-url="{{ asset('storage/' . $revista->archivo_pdf) }}" 
             data-worker-url="{{ asset('js/pdf.worker.mjs') }}"
             class="flipbook-wrapper d-flex justify-content-center align-items-center rounded-4 shadow-lg overflow-hidden position-relative bg-dark" 
             style="height: 80vh; border: 10px solid #2b2b2b;">
            
            <!-- Pantalla de Carga -->
            <div id="flipbook-loader" class="position-absolute w-100 h-100 d-flex flex-column justify-content-center align-items-center bg-dark z-3" style="top:0; left:0;">
                <div class="spinner-border text-danger" style="width: 4rem; height: 4rem;" role="status"></div>
                <h4 class="text-white mt-4 fw-bold">Preparando Revista 3D...</h4>
                <p class="text-white-50" id="flipbook-progress">Cargando páginas...</p>
            </div>

            <!-- Botones de Navegación -->
            <button class="btn btn-dark rounded-circle position-absolute z-2 shadow border border-secondary nav-btn nav-prev" id="btn-prev" style="left: 20px; width: 50px; height: 50px; opacity: 0.7;" title="Página Anterior">
                <i class="fas fa-chevron-left fs-4"></i>
            </button>
            
            <button class="btn btn-dark rounded-circle position-absolute z-2 shadow border border-secondary nav-btn nav-next" id="btn-next" style="right: 20px; width: 50px; height: 50px; opacity: 0.7;" title="Página Siguiente">
                <i class="fas fa-chevron-right fs-4"></i>
            </button>

            <!-- Toolbar Superior Derecha (Zoom & Fullscreen) -->
            <div class="position-absolute top-0 end-0 m-3 z-3 d-flex gap-2">
                <button id="btn-zoom-out" class="btn btn-dark rounded-circle shadow toolbar-btn" title="Alejar Vista">
                    <i class="fas fa-search-minus"></i>
                </button>
                <button id="btn-zoom-reset" class="btn btn-dark rounded-circle shadow toolbar-btn" title="Restaurar Vista">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button id="btn-zoom-in" class="btn btn-dark rounded-circle shadow toolbar-btn" title="Acercar Vista">
                    <i class="fas fa-search-plus"></i>
                </button>
                <div class="vr bg-white opacity-50 mx-1"></div>
                <button id="btn-fullscreen" class="btn btn-dark rounded-circle shadow toolbar-btn" title="Pantalla Completa">
                    <i class="fas fa-expand"></i>
                </button>
            </div>

            <!-- El Libro -->
            <div id="flipbook" style="display: none; transition: transform 0.3s ease-out; transform-origin: center center;">
                <!-- Las páginas se inyectarán aquí mediante JS -->
            </div>

            <!-- Indicador de Página -->
            <div class="position-absolute bottom-0 mb-3 z-2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-pill fw-bold shadow">
                Pág <span id="page-current">1</span> de <span id="page-total">?</span>
            </div>

        </div>

    </div>
</section>

<style>
    .nav-btn:hover {
        opacity: 1 !important;
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }
    
    /* Estilos para el libro */
    .stf__wrapper {
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
    .page {
        background-color: white;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .page img, .page canvas {
        width: 100%;
        height: 100%;
        object-fit: fill;
    }
    /* Sombreado interno para darle realismo a las páginas */
    .page.--left {
        border-right: 1px solid rgba(0,0,0,0.1);
        background: linear-gradient(to left, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0) 5%);
    }
    .page.--right {
        border-left: 1px solid rgba(0,0,0,0.1);
        background: linear-gradient(to right, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0) 5%);
    }
    .page.hard {
        background-color: #f0f0f0;
        border: 2px solid #ccc;
    }
</style>

<!-- Nuestro Script Personalizado como Módulo ES -->
<script type="module" src="{{ asset('js/flipbook-viewer.js') }}?v={{ time() }}" @if(function_exists('app') && app()->has('csp-nonce')) nonce="{{ app('csp-nonce') }}" @endif></script>

@endsection
