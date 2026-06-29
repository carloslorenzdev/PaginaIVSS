@extends('layouts.app-public')

@section('titulo', 'Información General del Pensionado - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(26,60,110,0.9) 0%, rgba(13,31,56,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-users-cog text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Pensionados (as)</h1>
                <p class="lead text-white-50 mb-4 px-md-5">
                    Información General
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
            <div class="col-lg-10">
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-primary">
                    <h3 class="fw-bold mb-4 text-dark text-center">Información General</h3>
                    
                    <p class="text-muted mb-4 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        El Instituto Venezolano de los Seguros Sociales (IVSS) a través de la Dirección de Prestaciones garantiza a la población venezolana el otorgamiento de las prestaciones dinerarias por concepto de vejez, invalidez y sobreviviente, con el fin de brindar protección a todos los ciudadanos y ciudadanas.
                    </p>

                    <div class="alert alert-info border-info bg-white mt-4" role="alert">
                        <i class="fas fa-info-circle me-2 text-info"></i> Puedes acceder a los diferentes apartados (Tipos de Pensiones, Pensionados en el Exterior y Trámites) a través de las demás opciones del menú principal.
                    </div>

                    <div class="text-center mt-5">
                        <a href="{{ route('inicio') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">
                            <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

@endsection
