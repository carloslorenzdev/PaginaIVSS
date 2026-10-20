@extends('layouts.app-public')

@section('title', $noticia->titulo . ' - Prensa IVSS')

@section('content')
<!-- Contenedor principal con fondo gris claro para dar contraste y resaltar la noticia -->
<div class="py-5" style="background-image: linear-gradient(rgba(243, 244, 246, 0.85), rgba(243, 244, 246, 0.85)), url('{{ asset('imagenes/fondo-ivss.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh;">
    <div class="container mt-4">
        
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.9rem;">
                <li class="breadcrumb-item"><a href="/" wire:navigate class="text-decoration-none text-danger"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}" wire:navigate class="text-decoration-none text-danger">Noticias</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">Lectura</li>
            </ol>
        </nav>

        <!-- Tarjeta del artículo -->
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card border shadow-lg rounded-4 overflow-hidden bg-white" style="box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
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
                                {!! clean($noticia->contenido) !!}
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

                            <div class="d-flex align-items-center flex-wrap justify-content-center gap-2">
                                @php
                                    $redesNoticia = \App\Models\Configuracion::whereIn('clave', ['url_instagram', 'url_twitter', 'url_youtube', 'url_tiktok', 'url_facebook', 'url_telegram', 'url_threads'])->pluck('valor', 'clave');
                                    $getSocialLink = function($key) use ($redesNoticia) {
                                        $url = trim($redesNoticia[$key] ?? '');
                                        if(empty($url) || $url === '#') {
                                            return 'href="javascript:void(0)" onclick="Swal.fire({icon: \'info\', title: \'Próximamente\', text: \'Esta red social no está disponible en este momento.\', confirmButtonColor: \'#dc3545\'})"';
                                        }
                                        return 'href="' . e($url) . '" target="_blank" rel="noopener noreferrer"';
                                    };
                                @endphp
                                
                                <span class="text-muted small me-1 d-none d-sm-inline fw-semibold">Síguenos:</span>
                                
                                <a {!! $getSocialLink('url_instagram') !!} class="btn btn-light text-danger btn-sm rounded-circle d-flex align-items-center justify-content-center border" style="width: 38px; height: 38px; font-size: 1.1rem;" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a {!! $getSocialLink('url_twitter') !!} class="btn btn-light text-dark btn-sm rounded-circle d-flex align-items-center justify-content-center border" style="width: 38px; height: 38px; font-size: 1.1rem;" title="X (Twitter)">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                                <a {!! $getSocialLink('url_youtube') !!} class="btn btn-light text-danger btn-sm rounded-circle d-flex align-items-center justify-content-center border" style="width: 38px; height: 38px; font-size: 1.1rem;" title="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a {!! $getSocialLink('url_tiktok') !!} class="btn btn-light text-dark btn-sm rounded-circle d-flex align-items-center justify-content-center border" style="width: 38px; height: 38px; font-size: 1.1rem;" title="TikTok">
                                    <i class="fab fa-tiktok"></i>
                                </a>
                                <a {!! $getSocialLink('url_telegram') !!} class="btn btn-light text-primary btn-sm rounded-circle d-flex align-items-center justify-content-center border" style="width: 38px; height: 38px; font-size: 1.1rem;" title="Telegram">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                <a {!! $getSocialLink('url_facebook') !!} class="btn btn-light text-primary btn-sm rounded-circle d-flex align-items-center justify-content-center border" style="width: 38px; height: 38px; font-size: 1.1rem;" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a {!! $getSocialLink('url_threads') !!} class="btn btn-light text-dark btn-sm rounded-circle d-flex align-items-center justify-content-center border" style="width: 38px; height: 38px; font-size: 1.1rem;" title="Threads">
                                    <i class="fa-brands fa-threads"></i>
                                </a>

                                <a href="{{ route('noticias.index') }}" wire:navigate class="btn btn-danger btn-sm ms-2 rounded-pill px-4 d-flex align-items-center fw-semibold">
                                    <i class="fas fa-list me-2"></i> Ver más
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
        margin: 1rem auto;
        display: block;
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
