@extends('layouts.app-public')

@section('titulo', 'Información Complementaria y Formularios - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(26,60,110,0.9) 0%, rgba(13,31,56,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-file-pdf text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Formularios e Información</h1>
                <p class="lead text-white-50 mb-4 px-md-5">
                    Planillas y documentos complementarios para descargar
                </p>
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
        
        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-lg-9">
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-primary">
                    
                    <h3 class="fw-bold text-dark mb-4 text-center">Listado de Documentos</h3>
                    <p class="text-muted text-center mb-5" style="font-size: 1.1rem;">
                        A continuación, puedes acceder a los formularios, reportes y cartas requeridas para tus trámites como pensionado en el exterior.
                    </p>

                    <div class="list-group list-group-flush gap-3">
                        
                        <!-- Documento 1 -->
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex align-items-center p-4 rounded-4 border bg-light shadow-sm">
                            <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-4" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fas fa-file-pdf fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Planilla de Censo</h5>
                                <p class="mb-0 text-muted small">Descargar formulario para el censo de pensionados.</p>
                            </div>
                            <div class="ms-auto ps-3 text-primary">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>

                        <!-- Documento 2 -->
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex align-items-center p-4 rounded-4 border bg-light shadow-sm">
                            <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-4" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fas fa-file-pdf fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Carta Compromiso</h5>
                                <p class="mb-0 text-muted small">Descargar documento de compromiso requerido.</p>
                            </div>
                            <div class="ms-auto ps-3 text-primary">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>

                        <!-- Documento 3 -->
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex align-items-center p-4 rounded-4 border bg-light shadow-sm">
                            <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-4" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fas fa-file-pdf fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Planilla de Actualización de Datos</h5>
                                <p class="mb-0 text-muted small">Formulario para mantener tu información al día.</p>
                            </div>
                            <div class="ms-auto ps-3 text-primary">
                                <i class="fas fa-download"></i>
                            </div>
                        </a>

                        <!-- Documento 4 -->
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex align-items-center p-4 rounded-4 border bg-light shadow-sm">
                            <div class="bg-white text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm me-4" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fas fa-file-alt fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Circular Informativa Nº 2</h5>
                                <p class="mb-0 text-muted small">Información general complementaria del IVSS.</p>
                            </div>
                            <div class="ms-auto ps-3 text-primary">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Documento 5 -->
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex align-items-center p-4 rounded-4 border bg-light shadow-sm">
                            <div class="bg-white text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm me-4" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fas fa-list-alt fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Reporte España 2010</h5>
                                <p class="mb-0 text-muted small">Para Pensionados con envíos de recaudos completos e incompletos.</p>
                            </div>
                            <div class="ms-auto ps-3 text-primary">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>

                    </div>

                    <div class="text-center mt-5">
                        <a href="{{ route('pensionado.pensionados_exterior') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">
                            <i class="fas fa-arrow-left me-2"></i> Volver a Pensionados en el Exterior
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

@endsection
