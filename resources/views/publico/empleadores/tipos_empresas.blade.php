?@extends('layouts.app-public')
@section('titulo', 'Tipos de Empresas - IVSS')
@section('content')
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(253,126,20,0.9) 0%, rgba(139,69,0,0.95) 100%); z-index: 1;"></div>
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-industry text-warning fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Tipos de Empresas</h1>
                <p class="lead text-white-50 mb-0">Clasificación de entidades sujetas a registro en el IVSS</p>
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; z-index: 2;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="display: block; width: calc(100% + 1.3px); height: 60px;">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="#f8f9fa"></path>
        </svg>
    </div>
</div>
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container py-4">
        
        <div class="row justify-content-center mb-5" data-aos="fade-up">
            <div class="col-lg-10">
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-warning">
                    <p class="text-muted mb-4 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        Se puede diferenciar a las empresas por el origen de su capital (privadas ó públicas), por su tamaño (pequeñas, medianas o grandes), por su actividad (industriales, comerciales o de servicios) y por su forma jurídica (sociedad anónima, sociedad limitada o cooperativa).
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center mb-5">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-elevate transition-all border-top border-4 border-warning">
                    <div class="card-body p-4 text-center">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-store fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Pequeñas empresas</h4>
                        <p class="text-muted" style="font-size: 1.1rem;">Tienen menos de 50 trabajadores.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-elevate transition-all border-top border-4 border-warning">
                    <div class="card-body p-4 text-center">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Medianas empresas</h4>
                        <p class="text-muted" style="font-size: 1.1rem;">Tienen entre 50 y 250 trabajadores.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-elevate transition-all border-top border-4 border-warning">
                    <div class="card-body p-4 text-center">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-industry fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Grandes Empresas</h4>
                        <p class="text-muted" style="font-size: 1.1rem;">Tienen más de 250 trabajadores.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('inicio') }}" class="btn btn-outline-warning text-dark rounded-pill px-4 py-2 fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
            </a>
        </div>
    </div>
</section>
<style>
    .hover-elevate:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .transition-all { transition: all 0.3s ease; }
</style>
@endsection
