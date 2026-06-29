@extends('layouts.app-public')

@section('titulo', 'Contacto - Pensionados en el Exterior - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(26,60,110,0.9) 0%, rgba(13,31,56,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-headset text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Contacto</h1>
                <p class="lead text-white-50 mb-4 px-md-5">
                    Comunícate con la coordinación de pensionados en el exterior
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
            <div class="col-lg-8">
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-primary text-center">
                    
                    <h3 class="fw-bold text-dark mb-5">Vías de Comunicación</h3>

                    <div class="row g-4 justify-content-center">
                        <!-- Teléfono -->
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 h-100 border-0 shadow-sm">
                                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary shadow-sm" style="width: 70px; height: 70px;">
                                    <i class="fas fa-phone-alt fa-2x"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">Teléfono de Contacto</h5>
                                <p class="text-muted mb-0 fs-5">0058-0212-4826164</p>
                            </div>
                        </div>

                        <!-- Correo -->
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 h-100 border-0 shadow-sm">
                                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary shadow-sm" style="width: 70px; height: 70px;">
                                    <i class="fas fa-envelope fa-2x"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">Correo Electrónico</h5>
                                <a href="mailto:pensionalexterior@ivss.gob.ve" class="text-decoration-none fs-5 d-block text-truncate" title="pensionalexterior@ivss.gob.ve">
                                    pensionalexterior@ivss.gob.ve
                                </a>
                            </div>
                        </div>
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
