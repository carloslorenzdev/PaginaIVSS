@extends('layouts.app-public')

@section('titulo', 'Continuación Facultativa - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(13,110,253,0.9) 0%, rgba(0,0,139,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-route text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Continuación Facultativa</h1>
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
                    <h3 class="fw-bold mb-4 text-dark">Continuación Facultativa</h3>
                    
                    <p class="text-muted mb-4 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        La Continuación Facultativa es un derecho otorgado por la Ley del Seguro Social y su Reglamento a los trabajadores que deseen continuar cotizando al Seguro Social particularmente, sin estar vinculado a una empresa u organismo.
                    </p>

                    <h5 class="fw-bold mb-3 text-dark">Requisitos:</h5>
                    <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                        <li>Presentar Cédula de Identidad.</li>
                        <li>Llenar forma 14-196</li>
                    </ul>

                    <p class="text-muted mb-5 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        El derecho a solicitar la continuación facultativa depende del asegurado siempre y cuando lo solicite. (Art.6 LSS)
                    </p>

                    <h3 class="fw-bold mb-4 text-dark border-top pt-4">Trabajadores No Dependiente</h3>
                    
                    <p class="text-muted mb-4 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        Los trabajadores y trabajadoras no dependientes podrán inscribirse en el Instituto Venezolano de los Seguros Sociales y adquirirán la situación de asegurados y aseguradas con derecho a todas las prestaciones.
                    </p>

                    <h5 class="fw-bold mb-3 text-dark">Requisitos:</h5>
                    <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                        <li>Presentar Cédula de Identidad</li>
                        <li>Llenar forma 14-196</li>
                    </ul>

                    <div class="alert alert-warning mb-4" role="alert" style="font-size: 1.1rem; line-height: 1.8;">
                        <strong>Nota:</strong> Estas cotizaciones las deberá pagar mensualmente y de demorarse en el pago por más de un mes, podrá continuar cotizando una vez que realice su cancelación por la cuota requerida.
                    </div>

                    <div class="bg-light p-3 rounded d-inline-flex align-items-center border">
                        <i class="fas fa-file-word text-primary fa-2x me-3"></i>
                        <a href="http://www.ivss.gov.ve/imag/page/379/forma_14_196.doc" target="_blank" class="text-decoration-none fw-bold text-dark" style="font-size: 1.1rem;">forma 14 196.doc</a>
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
