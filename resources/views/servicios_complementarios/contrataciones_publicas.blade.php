@extends('layouts.app-public')

@section('titulo', 'Contrataciones Públicas - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(52,58,64,0.9) 0%, rgba(33,37,41,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-handshake text-dark fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Contrataciones Públicas</h1>
                <p class="lead text-white-50 mb-0">Información sobre Concursos, Adjudicaciones y Registro de Proveedores</p>
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
        <div class="row">
            <!-- Sidebar / Tabs Nav -->
            <div class="col-lg-3 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="bg-white rounded-4 shadow-sm p-3 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-3 px-2 text-dark"><i class="fas fa-folder-open text-secondary me-2"></i> Categorías</h5>
                    <div class="nav flex-column nav-pills custom-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @php $i = 0; @endphp
                        @foreach($secciones as $nombre => $datos)
                            <button class="nav-link text-start fw-semibold mb-2 rounded-3 {{ $i === 0 ? 'active' : '' }}" 
                                id="v-pills-{{ Str::slug($nombre) }}-tab" 
                                data-bs-toggle="pill" 
                                data-bs-target="#v-pills-{{ Str::slug($nombre) }}" 
                                type="button" role="tab" aria-controls="v-pills-{{ Str::slug($nombre) }}" 
                                aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                                <i class="{{ $datos['icono'] }} me-2 text-{{ $datos['color'] }}"></i> {{ $nombre }}
                            </button>
                            @php $i++; @endphp
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Contenido de los Tabs -->
            <div class="col-lg-9" data-aos="fade-left">
                <div class="tab-content" id="v-pills-tabContent">
                    @php $i = 0; @endphp
                    @foreach($secciones as $nombre => $datos)
                        <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" 
                            id="v-pills-{{ Str::slug($nombre) }}" 
                            role="tabpanel" 
                            aria-labelledby="v-pills-{{ Str::slug($nombre) }}-tab">
                            
                            <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 mb-4">
                                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                                    <div class="bg-{{ $datos['color'] }} bg-opacity-10 text-{{ $datos['color'] }} rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="{{ $datos['icono'] }} fa-lg"></i>
                                    </div>
                                    <h2 class="fw-bold text-dark mb-0">{{ $nombre }}</h2>
                                </div>

                                @if(isset($datos['tipo']) && $datos['tipo'] === 'informativo')
                                    <!-- TEXTO INFORMATIVO (REQUISITOS) -->
                                    <div class="mb-4">
                                        <p class="lead text-muted">A continuación se detallan los requisitos obligatorios para la inscripción y/o actualización en el <strong>Registro Interno de Proveedores del Instituto Venezolano de los Seguros Sociales (IVSS)</strong>.</p>
                                        
                                        <div class="alert alert-warning border-0 rounded-4 shadow-sm mb-4">
                                            <div class="d-flex">
                                                <i class="fas fa-exclamation-triangle fa-2x me-3 text-warning"></i>
                                                <div>
                                                    <h5 class="fw-bold mb-1">Información Importante</h5>
                                                    <p class="mb-0">Los recaudos deben ser presentados en una <strong>carpeta de fibra marrón (tamaño oficio)</strong> y toda la información debe estar también digitalizada e incluida en un <strong>CD</strong>. Consignar en el Edificio Sede del IVSS, Altagracia, Piso 3 o Unidad de Registro de Proveedores, Mezzanina. Correo: <a href="mailto:URPIVSS@GMAIL.COM" class="alert-link">URPIVSS@GMAIL.COM</a> | Teléfono: 0212-8011050.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-building text-danger me-2"></i> Requisitos para Personas Jurídicas</h5>
                                        <ul class="list-unstyled space-y-3 text-muted">
                                            <li class="d-flex mb-3"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>1. Acta Constitutiva:</strong> y Estatutos Sociales con todas sus modificaciones (Registro Mercantil).</div></li>
                                            <li class="d-flex mb-3"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>2. Cédula de Identidad:</strong> Copias legibles de la Junta Directiva, Administradores y Representantes Legales.</div></li>
                                            <li class="d-flex mb-3"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>3. Cooperativas:</strong> Lista de miembros, registro SUNACOOP y certificado de cumplimiento.</div></li>
                                            <li class="d-flex mb-3"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>4. Declaración de ISLR:</strong> Del último ejercicio fiscal o certificado de exención.</div></li>
                                            <li class="d-flex mb-3"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>5. RIF:</strong> Registro de Información Fiscal vigente.</div></li>
                                            <li class="d-flex mb-3"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>6. SNC:</strong> Certificado de inscripción vigente en el Servicio Nacional de Contratistas.</div></li>
                                            <li class="d-flex mb-3"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>7. Solvencia Laboral:</strong> Vigente y en regla.</div></li>
                                            <li class="d-flex mb-3"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>8. Solvencia IVSS:</strong> Certificado vigente acompañado del último recibo de pago.</div></li>
                                            <li class="d-flex mb-3"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>9. Permiso Sanitario:</strong> Permiso Sanitario de Funcionamiento o Registro Sanitario (solo si aplica según la actividad).</div></li>
                                            <li class="d-flex"><i class="fas fa-check-circle text-success mt-1 me-3"></i> <div><strong>10. Certificación Bancaria:</strong> Documento oficial del banco que refleje el número de cuenta de 20 dígitos.</div></li>
                                        </ul>
                                    </div>
                                @else
                                    <!-- LISTA DE DOCUMENTOS DESCARGABLES -->
                                    @if(count($datos['documentos']) > 0)
                                        <div class="row g-3">
                                            @foreach($datos['documentos'] as $doc)
                                                <div class="col-12">
                                                    <div class="card border-0 shadow-sm border-start border-4 border-{{ $datos['color'] }} hover-elevate transition-all">
                                                        <div class="card-body p-3 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                                                            <div class="mb-3 mb-md-0 d-flex align-items-center">
                                                                @php
                                                                    $esPdf = str_ends_with(strtolower($doc['url']), '.pdf');
                                                                    $iconoDoc = $esPdf ? 'fas fa-file-pdf text-danger' : 'fas fa-external-link-alt text-primary';
                                                                @endphp
                                                                <i class="{{ $iconoDoc }} fa-2x me-3 opacity-75"></i>
                                                                <h5 class="fw-bold text-dark mb-0" style="font-size: 1rem;">{{ $doc['titulo'] }}</h5>
                                                            </div>
                                                            <a href="{{ $doc['url'] }}" target="_blank" class="btn btn-outline-{{ $datos['color'] }} btn-sm px-4 fw-bold rounded-pill shadow-sm">
                                                                <i class="fas fa-{{ $esPdf ? 'download' : 'eye' }} me-1"></i> {{ $esPdf ? 'Descargar' : 'Ver Detalles' }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- ESTADO VACÍO -->
                                        <div class="text-center py-5 border rounded-4 border-dashed bg-light">
                                            <i class="fas fa-folder-open fa-3x text-muted opacity-25 mb-3"></i>
                                            <h5 class="text-muted fw-bold">No hay registros disponibles.</h5>
                                            <p class="text-muted small mb-0">Actualmente no existen documentos publicados en la categoría de {{ $nombre }}.</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .custom-pills .nav-link {
        color: #495057;
        background-color: transparent;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    .custom-pills .nav-link:hover {
        background-color: #f8f9fa;
        color: #343a40; /* Dark color text */
    }
    .custom-pills .nav-link.active {
        background-color: #343a40;
        color: #fff;
        box-shadow: 0 4px 6px rgba(33, 37, 41, 0.2);
    }
    .custom-pills .nav-link.active i {
        color: #fff !important;
    }
    .hover-elevate:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .border-dashed {
        border-style: dashed !important;
        border-color: #dee2e6 !important;
    }
</style>

@endsection
