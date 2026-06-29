?@extends('layouts.app-public')
@section('titulo', 'Información General para Empleadores - IVSS')
@section('content')
<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(25,135,84,0.9) 0%, rgba(0,100,0,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-building text-success fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Información General del Empleador</h1>
                <p class="lead text-white-50 mb-0">Portal de servicios y normativas vigentes para los patronos y empresas en Venezuela.</p>
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
        
        <div class="row justify-content-center mb-5" data-aos="fade-up">
            <div class="col-lg-10">
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-success">
                    <h3 class="fw-bold mb-3 text-dark"><i class="fas fa-info-circle text-success me-2"></i> Empleador (a)</h3>
                    <p class="text-muted mb-3 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        El empleador tanto público como privado, es el organismo social integrado por elementos humanos, técnicos y materiales, cuyo objetivo natural y principal es la obtención de utilidades, o bien, la prestación de servicios a la comunidad, coordinados por un administrador que toma decisiones en forma oportuna para la consecución de los objetivos para los que fueron creadas. Para cumplir con este objetivo la empresa combina naturaleza y capital.
                    </p>
                    <p class="text-muted mb-0 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        El patrono o representante legal de toda empresa, está en el deber de inscribirse a través del Sistema de Gestión y Autoliquidación de Empresas TIUNA, dentro de los tres días hábiles siguientes año comienzo de su actividad. Asimismo comunicar todo cambio relativo a la actividad a la cual se dedican; sus representantes legales; su dirección, cantidad de empleados, cambios de salarios, declaración de familiares, accidentes laborales etc. (art. 57, 58, 74,75, 76 Reglamento General y Ley del Seguro Social).
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('inicio') }}" class="btn btn-outline-success rounded-pill px-4 py-2 fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
            </a>
        </div>

    </div>
</section>
<style>
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endsection
