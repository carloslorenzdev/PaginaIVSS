@extends('layouts.app-public')

@section('titulo', 'Marco Normativo - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(220,53,69,0.9) 0%, rgba(139,0,0,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-gavel text-danger fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Marco Normativo</h1>
                <p class="lead text-white-50 mb-0">Leyes, Decretos, Providencias y Regulaciones que rigen el IVSS</p>
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
                    <h5 class="fw-bold mb-3 px-2 text-dark"><i class="fas fa-folder-open text-danger me-2"></i> Categorías</h5>
                    <div class="nav flex-column nav-pills custom-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @php $i = 0; @endphp
                        @foreach($categorias as $nombre => $datos)
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
                    @foreach($categorias as $nombre => $datos)
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

                                @if(count($datos['documentos']) > 0)
                                    <div class="row g-3">
                                        @foreach($datos['documentos'] as $doc)
                                            <div class="col-12">
                                                <div class="card border-0 shadow-sm border-start border-4 border-{{ $datos['color'] }} hover-elevate transition-all">
                                                    <div class="card-body p-3 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                                                        <div class="mb-3 mb-md-0 d-flex align-items-center">
                                                            @php
                                                                $esPdf = str_ends_with(strtolower($doc['url']), '.pdf');
                                                                $iconoDoc = $esPdf ? 'fas fa-file-pdf text-danger' : 'fas fa-file-word text-primary';
                                                            @endphp
                                                            <i class="{{ $iconoDoc }} fa-2x me-3 opacity-75"></i>
                                                            <h5 class="fw-bold text-dark mb-0" style="font-size: 1rem;">{{ $doc['titulo'] }}</h5>
                                                        </div>
                                                        <a href="{{ $doc['url'] }}" target="_blank" class="btn btn-outline-{{ $datos['color'] }} btn-sm px-4 fw-bold rounded-pill shadow-sm">
                                                            <i class="fas fa-download me-1"></i> Descargar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-folder-open fa-3x text-muted opacity-25 mb-3"></i>
                                        <h5 class="text-muted fw-bold">No hay documentos disponibles en esta categoría.</h5>
                                    </div>
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
        color: #dc3545;
    }
    .custom-pills .nav-link.active {
        background-color: #dc3545;
        color: #fff;
        box-shadow: 0 4px 6px rgba(220, 53, 69, 0.2);
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
</style>

@endsection
