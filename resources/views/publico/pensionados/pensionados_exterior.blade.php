@extends('layouts.app-public')

@section('titulo', 'Pensionados en el Exterior - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(26,60,110,0.9) 0%, rgba(13,31,56,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-globe-americas text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Pensionados en el Exterior</h1>
                <p class="lead text-white-50 mb-4 px-md-5">
                    Requisitos e información para beneficiarios fuera del país
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
                    <h3 class="fw-bold mb-4 text-dark text-center">Información Importante</h3>

                    <p class="text-muted mb-4 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        Se les informa a los pensionados del Instituto Venezolano de los Seguros Sociales que hayan fijado su residencia en España, Portugal, Uruguay, Chile, Ecuador e Italia, que para poder recibir a través del Instituto Venezolano de los Seguros Sociales el pago de su pensión deben consignar la documentación detallada a continuación:
                    </p>

                    <div class="bg-light p-4 rounded-4 mb-4">
                        <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                            <li class="mb-3"><strong>Planilla: Censo de Pensionados - Pensión al Exterior</strong>, en original con los datos completos, sin enmiendas, firmada por el pensionado(a).</li>
                            <li class="mb-3"><strong>Planilla: Carta Compromiso</strong>, en original sin enmiendas firmada por el pensionado (a) con su huella dactilar.
                                <br><small class="text-primary"><i class="fas fa-info-circle me-1"></i> Nota: Las planillas las puede obtener por la página Web, opción: Formularios: Seleccionar: Pensionados en el Exterior.</small>
                            </li>
                            <li class="mb-3">Solicitar en el Consulado de Venezuela más cercano a su domicilio: <strong>Registro Consular para el censo de pensionados en el exterior</strong> en original y vigente con sello húmedo.</li>
                            <li class="mb-2">De acuerdo al país de residencia deben anexar documento de identidad y el comprobante de apertura de cuenta con su respectivo código IBAN:</li>
                        </ul>

                        <div class="ps-md-4">
                            <ul class="text-muted list-unstyled" style="font-size: 1.1rem; line-height: 1.8;">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>CHILE:</strong> Fotocopia legible del Documento Registro Único Nacional (RUN) y el comprobante de apertura de cuenta del Banco Estado.</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>ECUADOR:</strong> Fotocopia legible del Documento de Identidad Ecuatoriano y el comprobante de apertura de cuenta del Banco Pacífico.</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>ESPAÑA:</strong> Fotocopia legible del Documento Nacional de Identidad (DNI) y el comprobante de apertura de cuenta del Banco Santander España.</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>ITALIA:</strong> Fotocopia legible del Documento de Identidad Italiano y el comprobante de apertura de cuenta del Banco Intesa San Paolo.</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>PORTUGAL:</strong> Fotocopia legible del Billeto de Identidad (BI) y el comprobante de apertura de cuenta del Banco Totta Santander.</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> <strong>URUGUAY:</strong> Fotocopia legible del Documento de Identidad Uruguayo y el comprobante de apertura de cuenta del Banco BANDES Uruguay.</li>
                            </ul>
                        </div>
                    </div>

                    <p class="text-muted mb-4 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        Los pensionados que son clasificados para cobrar su pensión en su país de residencia se les enviará el monto correspondiente a su pensión a partir del mes que sea incorporando. Por tal motivo, deben seguir cobrando por intermedio de un apoderado hasta que sea aprobada su solicitud. No se enviarán los montos acumulados en sus cuentas de Venezuela.
                    </p>

                    <p class="text-muted mb-4 text-justify" style="font-size: 1.1rem; line-height: 1.8;">
                        La documentación solicitada debe estar completa y la pueden enviar a través de la Valija Diplomática del Consulado ó por correo expreso a la siguiente dirección:
                        <br><br>
                        <strong>Instituto Venezolano de los Seguros Sociales, Dirección de Prestaciones en Dinero. Pensión en el Exterior. Av. Francisco Javier Ustariz, Conjunto Residencial San Bernardino Pb, Caracas 1010 - Venezuela.</strong>
                    </p>

                    <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-dark mb-4 p-4 rounded-4" role="alert">
                        <p class="mb-2" style="font-size: 1.1rem;">
                            <i class="fas fa-exclamation-triangle text-warning me-2 fa-lg"></i> <strong>IMPORTANTE:</strong> Les recordamos a todos los pensionados que están cobrando su pensión por España, Portugal, Chile, Ecuador, Italia y Uruguay que deben cumplir con el reporte anual correspondiente al mes Enero de cada año a través de los Consulados.
                        </p>
                        <p class="mb-0 mt-3" style="font-size: 1.1rem;">
                            <i class="fas fa-phone-alt text-dark me-2"></i> <strong>Contacto:</strong> 0058 0212 552.94.86
                        </p>
                    </div>

                    <div class="d-flex flex-column gap-3 mt-5">
                        <a href="{{ route('pensionado.contacto') }}" class="btn btn-light border py-3 text-start fw-bold text-primary rounded-3">
                            Contacto
                        </a>
                        <a href="{{ route('pensionado.formularios') }}" class="btn btn-light border py-3 text-start fw-bold text-primary rounded-3">
                            Información complementaria y formularios
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

@endsection
