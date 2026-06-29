?@extends('layouts.app-public')
@section('titulo', 'Sistema Autoliquidación (TIUNA) - IVSS')
@section('content')
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(111,66,193,0.9) 0%, rgba(75,0,130,0.95) 100%); z-index: 1;"></div>
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-laptop-code text-purple fa-3x" style="color: #6f42c1;"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Sistema Autoliquidación (TIUNA)</h1>
                <p class="lead text-white-50 mb-0">Gestión en línea de sus obligaciones patronales</p>
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
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4" style="border-color: #6f42c1 !important;">
                    <h3 class="fw-bold mb-3 text-dark"><i class="fas fa-desktop me-2" style="color: #6f42c1;"></i> Sistema de Gestión y Autoliquidación de Empresas</h3>
                    <p class="text-muted mb-4 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        El Instituto Venezolano de los Seguros Sociales, pone a la disposición de empleadoras y empleadores del país, el Sistema de Gestión y Autoliquidación de Empresas a través del cual podrán realizar movimientos de ingresos, egresos y cambios de salarios de sus trabajadores desde el lugar que le resulte más cómodo, de manera rápida y sencilla, podrán consultar sus estados de cuentas y trabajadores activos con niveles de detalles importantes que garanticen información oportuna.
                    </p>

                    <h5 class="fw-bold text-dark mt-4">Requisitos a consignar por los Empleadores:</h5>
                    <p class="text-muted mb-2" style="font-size: 1.1rem;">
                        Públicos, Privados, Asociaciones, Cooperativas, Embajadas, Consulados y Cuerpos Diplomáticos:
                    </p>
                    <ul class="text-muted mb-4" style="font-size: 1.1rem;">
                        <li>Presentar Registro de Información Fiscal (RIF)</li>
                    </ul>

                    <div class="alert alert-info border-0 rounded-3 mt-4 mb-4" style="background-color: rgba(111,66,193,0.1); color: #4b0082;">
                        <i class="fas fa-info-circle me-2"></i> <strong>Nota:</strong> Toda empresa que tenga por lo menos un (1) trabajador deberá ser afiliada al Instituto Venezolano de los Seguro Social (IVSS)
                    </div>
                    
                    <p class="text-muted mb-0" style="font-size: 1.1rem;">
                        Si deseas acceder al Sistema de Gestión y Autoliquidación de Empresas Tiuna ir al siguiente enlace:<br>
                        <a href="http://autoliquidacionv2.ivss.gob.ve:28080/TiunaWeb/" target="_blank" class="text-decoration-none fw-bold" style="color: #6f42c1;">http://autoliquidacionv2.ivss.gob.ve:28080/TiunaWeb/</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('inicio') }}" class="btn text-white rounded-pill px-4 py-2 fw-bold" style="background-color: #6f42c1; border-color: #6f42c1;">
                <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
            </a>
            <a href="http://tiuna.ivss.gob.ve" target="_blank" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold ms-2">
                Ir al Sistema TIUNA <i class="fas fa-external-link-alt ms-2"></i>
            </a>
        </div>
    </div>
</section>
<style>
    .hover-elevate:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .transition-all { transition: all 0.3s ease; }
</style>
@endsection
