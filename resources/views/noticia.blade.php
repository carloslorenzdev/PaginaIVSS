@extends('layouts.app-public')

@section('title', $noticia->titulo . ' - Prensa IVSS')

@section('content')
<!-- Contenedor principal con fondo gris claro para dar contraste y resaltar la noticia -->
<div class="bg-light py-5">
    <div class="container mt-4">
        
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.9rem;">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-danger"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}" class="text-decoration-none text-danger">Noticias</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">Lectura</li>
            </ol>
        </nav>

        <!-- Tarjeta del artículo -->
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                    <div class="card-body p-4 p-md-5">
                        
                        <h1 class="fw-bold text-dark mb-4" style="font-size: 2.2rem; line-height: 1.4; color: #1f2937;">
                            {{ $noticia->titulo }}
                        </h1>

                        @php
                            $imagenPrincipal = $noticia->medios->where('pivot.tipo_relacion', 'principal')->first() ?? $noticia->medios->first();
                        @endphp
                        
                        @if($imagenPrincipal)
                            <div class="mb-5 text-center">
                                <img src="{{ asset('storage/' . $imagenPrincipal->ruta) }}" 
                                     alt="{{ $noticia->titulo }}" 
                                     class="img-fluid rounded-3 shadow-sm w-100"
                                     style="max-height: 550px; object-fit: cover;">
                                @if($imagenPrincipal->leyenda)
                                    <p class="text-muted small mt-2 fst-italic">{{ $imagenPrincipal->leyenda }}</p>
                                @endif
                            </div>
                        @endif

                        <div class="article-content" style="font-size: 1.15rem; line-height: 1.8; color: #4b5563;">


                            <div class="contenido-html">
                                {!! $noticia->contenido !!}
                            </div>
                        </div>

                        <!-- Galería si hay imágenes adicionales -->
                        @if($noticia->medios->where('pivot.tipo_relacion', 'galeria')->count() > 0)
                            <h4 class="fw-bold mt-5 mb-4 border-bottom pb-2">Galería de Imágenes</h4>
                            <div class="row g-3">
                                @foreach($noticia->medios->where('pivot.tipo_relacion', 'galeria') as $medio)
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ asset('storage/' . $medio->ruta) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $medio->ruta) }}" class="img-fluid rounded shadow-sm w-100" style="height: 200px; object-fit: cover;" alt="Galería">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Extras (Etiquetas, Categorías y Enlace) -->
                        <div class="mt-4 pt-3 d-flex flex-wrap gap-3 align-items-center">
                            @if($noticia->categorias->count() > 0)
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <i class="fas fa-folder text-muted"></i>
                                    @foreach($noticia->categorias as $categoria)
                                        <span class="badge bg-danger text-white px-2 py-1">{{ $categoria->nombre }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if($noticia->etiquetas)
                                @php
                                    $tags = explode(',', $noticia->etiquetas);
                                @endphp
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <i class="fas fa-tags text-muted"></i>
                                    @foreach($tags as $tag)
                                        <span class="badge bg-light text-secondary border px-2 py-1">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            @if($noticia->enlace_externo)
                                <a href="{{ $noticia->enlace_externo }}" target="_blank" class="text-decoration-none text-danger fw-semibold small ms-auto">
                                    <i class="fas fa-external-link-alt"></i> Fuente Original
                                </a>
                            @endif
                        </div>

                        <!-- Footer del artículo -->
                        <div class="mt-5 pt-4 border-top d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="text-muted text-center text-md-start mb-3 mb-md-0">
                                <span class="d-block fw-semibold text-dark" style="font-size: 1.1rem;">{{ $noticia->creditos_autor ?: ($noticia->autor->name ?? 'Prensa IVSS') }}</span>
                                <small><i class="fas fa-calendar-alt me-1"></i> Publicado el {{ $noticia->fecha_publicacion->format('d/m/Y') }} a las {{ $noticia->fecha_publicacion->format('h:i A') }}</small>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($noticia->titulo) }}" target="_blank" class="btn btn-info text-white btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="{{ route('noticias.index') }}" class="btn btn-danger btn-sm ms-3 rounded-pill px-4 d-flex align-items-center fw-semibold">
                                    <i class="fas fa-list me-2"></i> Ver más noticias
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Asegurar que las imágenes dentro del contenido HTML no se desborden */
    .contenido-html img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 1rem 0;
    }
    .contenido-html p {
        margin-bottom: 1.5rem;
    }
    .contenido-html ul {
        list-style-type: disc;
        margin-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .contenido-html ol {
        list-style-type: decimal;
        margin-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .contenido-html blockquote {
        border-left: 4px solid #dc3545;
        padding-left: 1rem;
        margin-left: 0;
        font-style: italic;
        color: #6c757d;
    }
    .contenido-html h1, .contenido-html h2, .contenido-html h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }
</style>
@endsection
