@extends('layouts.app-public')
@section('titulo', 'Información General - IVSS')
@section('content')
<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(13,110,253,0.9) 0%, rgba(0,0,139,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-info-circle text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Información General del Ciudadano</h1>
                <p class="lead text-white-50 mb-0">Deberes, derechos y todo lo referente al Seguro Social Obligatorio</p>
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
        
        <!-- Definición Ciudadano -->
        <div class="row justify-content-center mb-5" data-aos="fade-up">
            <div class="col-lg-10">
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-primary">
                    <h3 class="fw-bold mb-3 text-dark"><i class="fas fa-user-circle text-primary me-2"></i> ¿Qué es un Ciudadano (a)?</h3>
                    <p class="text-muted mb-3 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        La ciudadanía se puede definir como "El derecho y la disposición de participar en una comunidad, a través de la acción autorregulada, inclusiva, pacífica y responsable, con el objetivo de optimizar el bienestar público".
                    </p>
                    <p class="text-muted mb-3 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        Entre los más importantes derechos, destacan por su importancia los de participación en los beneficios de la vida en común. Además de la imprescindible participación política, mediante el derecho al voto, que es la seña de identidad de las democracias representativas predominantes en el mundo.
                    </p>
                    <p class="text-muted mb-3 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        Entre los deberes, destacan la obligación de respetar los derechos de los demás, de contribuir al bien común respetar los valores predominantes - que incluyen el sentido de justicia y de equidad -, y otros que contribuyen a afirmar la tesitura social y la paz. En ese sentido, tanto más democrática es una sociedad cuanto más incluyente, es decir, cuanto más ciudadanos plenos la conforman.
                    </p>
                    <p class="text-muted mb-0 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        En las democracias actuales, tal como se conciben, normalmente tienen la condición de ciudadanos todos los hombres y mujeres mayores de edad (siendo la mayoría de edad fijada generalmente en los 18 años).
                    </p>
                </div>
            </div>
        </div>
        <!-- Seguro Social Obligatorio -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Sistema Público</h6>
            <h2 class="fw-black">Seguro Social Obligatorio</h2>
        </div>
        <div class="row g-4">
            <!-- Contingencias Cubiertas -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-elevate transition-all">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Contingencias Cubiertas</h4>
                        <p class="text-muted mb-3">El Seguro Social ampara ante situaciones de:</p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light text-dark border"><i class="fas fa-baby text-primary me-1"></i> Maternidad</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-blind text-primary me-1"></i> Vejez</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-users text-primary me-1"></i> Sobrevivencia</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-procedures text-primary me-1"></i> Enfermedad</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-crutch text-primary me-1"></i> Accidente</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-wheelchair text-primary me-1"></i> Invalidez</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-cross text-primary me-1"></i> Muerte</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-door-open text-primary me-1"></i> Retiro</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-user-slash text-primary me-1"></i> Cesantía</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Beneficios -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-elevate transition-all">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="fas fa-hand-holding-heart fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Beneficios</h4>
                        <ul class="list-unstyled text-muted">
                            <li class="mb-3">
                                <strong class="text-dark d-block mb-1"><i class="fas fa-clinic-medical text-success me-2"></i> Asistencia Médica Integral</strong>
                                Defensa, promoción y restitución de la salud.
                            </li>
                            <li>
                                <strong class="text-dark d-block mb-1"><i class="fas fa-money-bill-wave text-success me-2"></i> Prestaciones en Dinero</strong>
                                Pensiones (vejez, invalidez, incapacidad parcial, sobrevivientes), indemnizaciones diarias y por pérdida involuntaria de empleo.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Cotizaciones -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-elevate transition-all">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Cotizaciones</h4>
                        <p class="text-muted mb-3">El aporte se calcula con base en el salario del trabajador (con un límite de 5 salarios mínimos) de forma semanal.</p>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item bg-transparent px-0 border-bottom-0"><strong>Aporte del Trabajador:</strong> 4%</li>
                            <li class="list-group-item bg-transparent px-0 pb-1"><strong>Aporte de la Empresa:</strong></li>
                            <li class="list-group-item bg-transparent px-0 py-1 ps-3 border-bottom-0"><i class="fas fa-angle-right text-warning"></i> Riesgo Mínimo: 9%</li>
                            <li class="list-group-item bg-transparent px-0 py-1 ps-3 border-bottom-0"><i class="fas fa-angle-right text-warning"></i> Riesgo Medio: 10%</li>
                            <li class="list-group-item bg-transparent px-0 pt-1 ps-3 border-bottom-0"><i class="fas fa-angle-right text-warning"></i> Riesgo Máximo: 11%</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('inicio') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">
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