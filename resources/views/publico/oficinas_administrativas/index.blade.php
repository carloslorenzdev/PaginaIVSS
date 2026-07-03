@extends('layouts.app-public')

@section('titulo', 'Oficinas Administrativas - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(10,31,61,0.9) 0%, rgba(20,50,90,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/hero-innovation-bg.png') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-building text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Oficinas Administrativas</h1>
                <p class="lead text-white-50 mb-0">Seleccione su estado para conocer la ubicación y contactos de nuestras Oficinas Administrativas a nivel nacional.</p>
            </div>
        </div>
    </div>
    
    <!-- Curva inferior -->
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; z-index: 2;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="display: block; width: calc(100% + 1.3px); height: 60px;">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="#f8f9fa"></path>
        </svg>
    </div>
</div>

<!-- CONTENIDO PRINCIPAL -->
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container py-4">
        
        <!-- Search bar -->
        <div class="row justify-content-center mb-5" data-aos="fade-up">
            <div class="col-lg-6 text-center">
                <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden">
                    <span class="input-group-text bg-white border-0 text-primary ps-4"><i class="fas fa-search"></i></span>
                    <input type="text" id="buscadorEstados" class="form-control border-0 px-3" placeholder="Buscar por estado (Ej. Carabobo, Lara...)" style="box-shadow: none;">
                </div>
            </div>
        </div>

        <!-- Grid de Estados -->
        <div class="row g-4" id="gridEstados" data-aos="fade-up" data-aos-delay="100">
            @php
                $estados = [
                    'Amazonas', 'Anzoátegui', 'Apure', 'Aragua', 'Barinas', 'Bolívar', 'Carabobo', 'Cojedes', 
                    'Delta Amacuro', 'Distrito Capital', 'Falcón', 'Guárico', 'Lara', 'Mérida', 'Miranda', 
                    'Monagas', 'Nueva Esparta', 'Portuguesa', 'Sucre', 'Táchira', 'Trujillo', 'Vargas', 'Yaracuy', 'Zulia'
                ];
                sort($estados);
            @endphp

            @foreach($estados as $estado)
            <div class="col-lg-3 col-md-4 col-sm-6 estado-item">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-elevate transition-all overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-map-marker-alt text-primary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3 estado-nombre">{{ $estado }}</h5>
                        <button class="btn btn-outline-primary rounded-pill w-100 fw-bold btn-ver-oficina" data-estado="{{ $estado }}">
                            Ver Oficinas
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('inicio') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
            </a>
        </div>
    </div>
</section>

<!-- Modal de Oficinas Info -->
<div class="modal fade" id="modalOficinaInfo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
            <div class="p-4 text-center position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 64px; height: 64px;">
                    <i class="fas fa-building fa-2x"></i>
                </div>

                <h4 class="fw-bold text-dark mb-2">
                    Oficinas Administrativas - <span id="modalEstadoNombre"></span>
                </h4>
                <p class="small text-muted mb-4">
                    Listado de Oficinas Administrativas y Agencias disponibles en este estado.
                </p>

                <div id="oficinasListContainer" class="text-start mb-4">
                    <!-- Dynamic Content will be loaded here -->
                </div>
                
                <button type="button" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        border-bottom: 4px solid #0d6efd;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .custom-accordion-body {
        max-height: 0;
        overflow: hidden;
        transition: all 0.4s ease-in-out;
        opacity: 0;
        padding: 0 1rem;
        border-top-color: transparent !important;
    }
    .custom-accordion-body.open {
        max-height: 300px;
        opacity: 1;
        padding: 1rem;
        border-top-color: #dee2e6 !important;
    }
</style>

<script id="directorio-data" type="application/json">
    {!! json_encode($data) !!}
</script>
<script src="{{ asset('js/publico/buscador-directorios.js') }}" nonce="{{ app('csp-nonce') ?? '' }}"></script>

@endsection
