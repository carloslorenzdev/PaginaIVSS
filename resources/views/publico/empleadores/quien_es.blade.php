?@extends('layouts.app-public')
@section('titulo', '¿Quién es el Empleador(a)? - IVSS')
@section('content')
<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(23,162,184,0.9) 0%, rgba(0,90,100,0.95) 100%); z-index: 1;"></div>
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-user-tie text-info fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">¿Quién es el Empleador(a)?</h1>
                <p class="lead text-white-50 mb-0">Definición legal y figura del patrono en la seguridad social</p>
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
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-info">
                    <h3 class="fw-bold mb-3 text-dark"><i class="fas fa-id-badge text-info me-2"></i> ¿Quién es el Empleador (a)?</h3>
                    <p class="text-muted mb-4 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        El empleador o representante legal de toda empresa, está en el deber de inscribirse en las oficinas administrativas del IVSS de su jurisdicción, dentro de los tres días hábiles siguientes al año comienzo de su actividad. Asimismo comunicar todo cambio relativo a la actividad a la cual se dedican; sus representantes legales; su dirección, cantidad de empleados, cambios de salarios, declaración de familiares, accidentes laborales etc. (art. 57, 58, 74,75, 76 Reglamento General y Ley del Seguro Social).
                    </p>
                    
                    <h5 class="fw-bold text-dark mt-4">Artículo 49 LOT.</h5>
                    <p class="text-muted mb-3 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        Se entiende por patrono o empleador la persona natural o jurídica que en nombre propio, ya sea por cuenta propia o ajena, tiene a su cargo una empresa, establecimiento, explotación o faena, de cualquier naturaleza o importancia, que ocupe trabajadores, sea cual fuere su número. Cuando la explotación se efectúe mediante intermediario, tanto éste como la persona que se beneficia de esa explotación se considerarán patronos.
                    </p>

                    <h5 class="fw-bold text-dark mt-4">Artículo 50 LOT.</h5>
                    <p class="text-muted mb-3 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        A los efectos de esta Ley, se considera representante del patrono toda persona que en nombre y por cuenta de éste ejerza funciones jerárquicas de dirección o administración.
                    </p>

                    <h5 class="fw-bold text-dark mt-4">Artículo 51 LOT.</h5>
                    <p class="text-muted mb-0 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        Los directores, gerentes, administradores, jefes de relaciones industriales, jefes de personal, capitanes de buques o aeronaves, liquidadores y depositarios y demás personas que ejerzan funciones de dirección o administración se considerarán representantes del patrono aunque no tengan mandato expreso, y obligarán a su representado para todos los fines derivados de la relación de trabajo.
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('inicio') }}" class="btn btn-outline-info rounded-pill px-4 py-2 fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
            </a>
        </div>
    </div>
</section>
@endsection
