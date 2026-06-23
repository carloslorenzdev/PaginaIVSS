<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IVSS | Innovación en Seguridad Social')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/ivss-logo-rojo.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" nonce="{{ app('csp-nonce') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" nonce="{{ app('csp-nonce') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" nonce="{{ app('csp-nonce') }}">
    
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}" nonce="{{ app('csp-nonce') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Top Ticker Bar -->
    <div class="top-bar-ticker py-1">
        <div class="container d-flex align-items-center">
            <div class="bg-danger text-white px-2 py-0 rounded-1 me-3" style="font-size: 0.6rem; font-weight: 800;">LO ÚLTIMO</div>
            <div id="tickerCarousel" class="carousel slide vertical" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php $ultimas = \App\Models\Noticia::latest()->take(3)->get(); @endphp
                    @forelse($ultimas as $index => $noticia)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <a href="/#noticias" class="text-dark text-decoration-none small opacity-75">{{ Str::limit($noticia->titulo, 90) }}</a>
                        </div>
                    @empty
                        <div class="carousel-item active small">Bienvenido al nuevo portal de noticias IVSS</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Official Banner (Full-width no borders) -->
    <div class="membrete-strip bg-white" style="width: 100%; overflow: hidden; line-height: 0; margin: 0; padding: 0;">
        @php
            $membrete = \App\Models\Configuracion::where('clave', 'membrete_img')->first();
            $membreteUrl = $membrete && $membrete->valor ? asset('storage/' . $membrete->valor) : asset('imagenes/cintillo ivss_2026.png');
        @endphp
        <img src="{{ $membreteUrl }}" alt="Cintillo" style="width: 100.1%; height: auto; display: block; border: none; margin: 0; padding: 0; max-width: 100.1%;">
    </div>

    <!-- Ultimate Navbar -->
    <nav class="navbar navbar-expand-lg navbar-ultimate sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-none" href="/">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Social Icons on the left -->
                @php
                    $redes = \App\Models\Configuracion::whereIn('clave', ['url_instagram', 'url_twitter', 'url_youtube', 'url_tiktok', 'url_facebook', 'url_telegram', 'url_threads'])->pluck('valor', 'clave');
                @endphp
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row gap-3">
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" href="{{ $redes['url_instagram'] ?? '#' }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" href="{{ $redes['url_twitter'] ?? '#' }}" target="_blank" title="X"><i class="fa-brands fa-x-twitter"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" href="{{ $redes['url_youtube'] ?? '#' }}" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" href="{{ $redes['url_tiktok'] ?? '#' }}" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" href="{{ $redes['url_telegram'] ?? '#' }}" target="_blank" title="Telegram"><i class="fab fa-telegram"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" href="{{ $redes['url_facebook'] ?? '#' }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" href="{{ $redes['url_threads'] ?? '#' }}" target="_blank" title="Threads"><i class="fa-brands fa-threads"></i></a>
                    </li>
                </ul>
                <!-- Main Links on the right -->
                <ul class="navbar-nav ms-auto font-medium">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('quienes_somos') }}">¿Quiénes Somos?</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/#servicios">Servicios</a></li>
                    <!--<li class="nav-item"><a class="nav-link fw-semibold" href="/#consultas">Consultas</a></li> -->
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/noticias">Noticias</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Ultimate Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('img/ivss-logo-rojo.png') }}" alt="Logo" width="45">
                        <h4 class="ms-3 mb-0">IVSS</h4>
                    </div>
                    <p class="text-muted small w-75">Garantizando la seguridad social con eficiencia, transparencia y compromiso humano para todo el pueblo venezolano.</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-4">ENLACES</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('quienes_somos') }}" class="text-muted text-decoration-none">Sobre nosotros</a></li>
                        <li class="mb-2"><a href="{{ route('marco_normativo') }}" class="text-muted text-decoration-none">Gaceta Oficial</a></li>
                        <li class="mb-2"><a href="/#servicios" class="text-muted text-decoration-none">Atención al Ciudadano</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="fw-bold mb-4">SÍGUENOS</h6>
                    @php
                        $redesFooter = $redes ?? \App\Models\Configuracion::whereIn('clave', ['url_instagram', 'url_twitter', 'url_youtube', 'url_tiktok', 'url_facebook', 'url_telegram', 'url_threads'])->pluck('valor', 'clave');
                    @endphp
                    <div class="d-flex gap-3 mb-4 flex-wrap">
                        <a href="{{ $redesFooter['url_instagram'] ?? '#' }}" target="_blank" class="text-danger" title="Instagram"><i class="fab fa-instagram fs-5"></i></a>
                        <a href="{{ $redesFooter['url_twitter'] ?? '#' }}" target="_blank" class="text-danger" title="X"><i class="fa-brands fa-x-twitter fs-5"></i></a>
                        <a href="{{ $redesFooter['url_youtube'] ?? '#' }}" target="_blank" class="text-danger" title="YouTube"><i class="fab fa-youtube fs-5"></i></a>
                        <a href="{{ $redesFooter['url_tiktok'] ?? '#' }}" target="_blank" class="text-danger" title="TikTok"><i class="fab fa-tiktok fs-5"></i></a>
                        <a href="{{ $redesFooter['url_telegram'] ?? '#' }}" target="_blank" class="text-danger" title="Telegram"><i class="fab fa-telegram fs-5"></i></a>
                        <a href="{{ $redesFooter['url_facebook'] ?? '#' }}" target="_blank" class="text-danger" title="Facebook"><i class="fab fa-facebook fs-5"></i></a>
                        <a href="{{ $redesFooter['url_threads'] ?? '#' }}" target="_blank" class="text-danger" title="Threads"><i class="fa-brands fa-threads fs-5"></i></a>
                    </div>
                    <p class="small text-muted mb-0">Caracas, Venezuela. Sede Principal Altagracia.</p>
                </div>
            </div>
            <hr class="my-5 opacity-5">
            <p class="text-center small text-muted mb-0">© {{ date('Y') }} IVSS. Innovación y Justicia Social.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" nonce="{{ app('csp-nonce') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" nonce="{{ app('csp-nonce') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" nonce="{{ app('csp-nonce') }}"></script>
    <script nonce="{{ app('csp-nonce') }}">
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init({ duration: 800, once: true });
        });
    </script>
</body>
</html>