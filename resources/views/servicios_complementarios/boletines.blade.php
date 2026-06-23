@extends('layouts.app-public')

@section('titulo', 'Boletín Informativo - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(46,115,183,0.9) 0%, rgba(20,60,105,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-bullhorn text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Boletín Informativo</h1>
                <p class="lead text-white-50 mb-0">Mantente al día con las noticias, circulares e información de interés del Instituto Venezolano de los Seguros Sociales.</p>
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
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-file-pdf text-danger me-2"></i> Documentos Publicados</h2>
            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6 shadow-sm">{{ $boletines->total() }} Boletines</span>
        </div>

        @if($boletines->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($boletines as $boletin)
                    <div class="col-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <div class="card border-0 shadow-sm rounded-4 hover-elevate transition-all overflow-hidden p-0">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-4 col-lg-3 p-4 bg-light d-flex align-items-center justify-content-center border-end" style="min-height: 200px;">
                                    @if($boletin->imagen_preview)
                                        <img src="{{ asset('storage/' . $boletin->imagen_preview) }}" alt="{{ $boletin->titulo }}" class="img-fluid rounded shadow-sm" style="max-height: 220px; object-fit: contain;">
                                    @else
                                        <div class="text-center text-muted opacity-50">
                                            <i class="fas fa-file-pdf fa-4x mb-2"></i>
                                            <p class="mb-0 small">Sin portada</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8 col-lg-9 p-4 p-lg-5">
                                    <div class="d-flex flex-column h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title fw-bold text-dark mb-0 text-uppercase" style="color: #0b457f !important;">{{ $boletin->titulo }}</h4>
                                            <span class="badge bg-light text-primary border border-primary px-3 py-1 rounded-pill ms-2 whitespace-nowrap">
                                                <i class="far fa-calendar-alt me-1"></i> {{ $boletin->fecha_publicacion->format('d M, Y') }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-muted mb-4" style="line-height: 1.6; font-size: 0.95rem;">
                                            {{ $boletin->descripcion }}
                                        </p>
                                        
                                        <div class="mt-auto text-end">
                                            <a href="{{ asset('storage/' . $boletin->archivo_pdf) }}" target="_blank" class="btn btn-primary px-4 py-2 fw-bold rounded shadow-sm d-inline-flex align-items-center" style="background-color: #0088cc; border-color: #0088cc;">
                                                Ver <i class="fas fa-chevron-right ms-2 fs-6"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $boletines->links() }}
            </div>
        @else
            <!-- ESTADO VACÍO -->
            <div class="text-center py-5 border rounded-4 border-dashed bg-white shadow-sm" data-aos="fade-up">
                <i class="fas fa-folder-open fa-4x text-muted opacity-25 mb-3"></i>
                <h4 class="text-muted fw-bold">No hay boletines disponibles.</h4>
                <p class="text-muted mb-0">Actualmente no existen boletines publicados. Por favor, vuelva a consultar más adelante.</p>
            </div>
        @endif
    </div>
</section>

<style>
    .hover-elevate {
        transition: all 0.3s ease;
    }
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .border-dashed {
        border-style: dashed !important;
        border-color: #dee2e6 !important;
    }
</style>

@endsection
