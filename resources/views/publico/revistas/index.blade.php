@extends('layouts.app-public')

@section('titulo', 'Revista Digital - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(200,35,51,0.9) 0%, rgba(139,0,0,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-book-open text-danger fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Revista Digital</h1>
                <p class="lead text-white-50 mb-0">Explora las ediciones de nuestra revista institucional y entérate de los logros y avances en la seguridad social.</p>
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
<section class="py-5" style="background-color: #f8f9fa; min-height: 500px;">
    <div class="container py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3" data-aos="fade-right">
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-swatchbook text-danger me-2"></i> Ediciones Disponibles</h2>
            <span class="badge bg-danger rounded-pill px-3 py-2 fs-6 shadow-sm">{{ $revistas->total() }} Revistas</span>
        </div>

        @if($revistas->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($revistas as $revista)
                    <div class="col-sm-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <div class="card border-0 shadow-sm rounded-4 hover-elevate transition-all overflow-hidden h-100 position-relative">
                            <!-- Portada de la Revista -->
                            <div class="bg-dark position-relative d-flex align-items-center justify-content-center" style="height: 320px; overflow: hidden;">
                                @if($revista->imagen_preview)
                                    <img src="{{ asset('storage/' . $revista->imagen_preview) }}" alt="{{ $revista->titulo }}" class="w-100 h-100 object-fit-cover opacity-75">
                                @else
                                    <div class="text-center text-white opacity-50">
                                        <i class="fas fa-book fa-4x mb-2"></i>
                                        <p class="mb-0 small">Sin portada</p>
                                    </div>
                                @endif
                                <!-- Overlay en Hover -->
                                <div class="position-absolute w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center opacity-0 hover-overlay transition-all">
                                    <a href="{{ route('revista_digital.show', $revista) }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold">
                                        <i class="fas fa-book-reader me-2"></i> Leer Ahora
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Información Inferior -->
                            <div class="card-body p-4 bg-white text-center">
                                @if($revista->edicion)
                                    <span class="badge bg-danger mb-2 px-2 py-1 rounded-1 fw-bold">{{ $revista->edicion }}</span>
                                @endif
                                <h5 class="card-title fw-bold text-dark text-uppercase mb-1" style="font-size: 1.1rem; line-height: 1.3;">
                                    {{ $revista->titulo }}
                                </h5>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $revista->fecha_publicacion->format('F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $revistas->links() }}
            </div>
        @else
            <!-- ESTADO VACÍO -->
            <div class="text-center py-5 border rounded-4 border-dashed bg-white shadow-sm" data-aos="fade-up">
                <i class="fas fa-book-open fa-4x text-muted opacity-25 mb-3"></i>
                <h4 class="text-muted fw-bold">No hay revistas disponibles.</h4>
                <p class="text-muted mb-0">Actualmente no existen revistas publicadas. Por favor, vuelva a consultar más adelante.</p>
            </div>
        @endif
    </div>
</section>

<style>
    .hover-elevate {
        transition: all 0.3s ease;
    }
    .hover-elevate:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    }
    .hover-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .card:hover .hover-overlay {
        opacity: 1;
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .border-dashed {
        border-style: dashed !important;
        border-color: #dee2e6 !important;
    }
</style>

@endsection
