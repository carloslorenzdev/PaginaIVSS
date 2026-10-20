<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IVSS | Instituto Venezolano de los Seguros Sociales')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('img/ivss-logo-rojo.png') }}">
    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" nonce="{{ app('csp-nonce') }}">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" nonce="{{ app('csp-nonce') }}">
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet" nonce="{{ app('csp-nonce') }}">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" nonce="{{ app('csp-nonce') }}">
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}" nonce="{{ app('csp-nonce') }}">
    
    @php
        $alertaPopupImg = \App\Models\Configuracion::where('clave', 'alerta_emergente_img')->value('valor');
    @endphp
    @if((request()->is('/') || request()->routeIs('inicio')) && $alertaPopupImg)
        <link rel="preload" as="image" href="{{ asset('storage/' . $alertaPopupImg) }}" fetchpriority="high">
    @endif

    @livewireStyles
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
                    $getNavSocialLink = function($key) use ($redes) {
                        $url = trim($redes[$key] ?? '');
                        if(empty($url) || $url === '#') {
                            return 'href="javascript:void(0)" onclick="Swal.fire({icon: \'info\', title: \'Próximamente\', text: \'Esta red social no está disponible en este momento.\', confirmButtonColor: \'#dc3545\'})"';
                        }
                        return 'href="' . e($url) . '" target="_blank" rel="noopener noreferrer"';
                    };
                @endphp
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row gap-3">
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" {!! $getNavSocialLink('url_instagram') !!} title="Instagram"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" {!! $getNavSocialLink('url_twitter') !!} title="X"><i class="fa-brands fa-x-twitter"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" {!! $getNavSocialLink('url_youtube') !!} title="YouTube"><i class="fab fa-youtube"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" {!! $getNavSocialLink('url_tiktok') !!} title="TikTok"><i class="fab fa-tiktok"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" {!! $getNavSocialLink('url_telegram') !!} title="Telegram"><i class="fab fa-telegram"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" {!! $getNavSocialLink('url_facebook') !!} title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fs-5 px-0" {!! $getNavSocialLink('url_threads') !!} title="Threads"><i class="fa-brands fa-threads"></i></a>
                    </li>
                </ul>
                <!-- Main Links on the right -->
                <ul class="navbar-nav ms-auto font-medium">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/" wire:navigate>Inicio</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('quienes_somos') }}" wire:navigate>¿Quiénes Somos?</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/#servicios">Servicios</a></li>
                    <!--<li class="nav-item"><a class="nav-link fw-semibold" href="/#consultas">Consultas</a></li> -->
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/noticias" wire:navigate>Noticias</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Ultimate Footer -->
    <footer class="py-5 position-relative overflow-hidden">
        <!-- Logo Watermark Fondo -->
        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 0; opacity: 0.1; pointer-events: none; padding: 20px;">
            <img src="{{ asset('img/ivss-logo-rojo.png') }}" alt="IVSS" style="max-height: 100%; object-fit: contain;">
        </div>

        <div class="container position-relative" style="z-index: 10;">
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
                        <li class="mb-2"><a href="{{ route('quienes_somos') }}" wire:navigate class="text-muted text-decoration-none">Sobre nosotros</a></li>
                        <li class="mb-2"><a href="{{ route('marco_normativo') }}" wire:navigate class="text-muted text-decoration-none">Gaceta Oficial</a></li>
                        <li class="mb-2"><a href="/#servicios" class="text-muted text-decoration-none">Atención al Ciudadano</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="fw-bold mb-4">SÍGUENOS</h6>
                    @php
                        $redesFooter = $redes ?? \App\Models\Configuracion::whereIn('clave', ['url_instagram', 'url_twitter', 'url_youtube', 'url_tiktok', 'url_facebook', 'url_telegram', 'url_threads'])->pluck('valor', 'clave');
                        $getFooterSocialLink = function($key) use ($redesFooter) {
                            $url = trim($redesFooter[$key] ?? '');
                            if(empty($url) || $url === '#') {
                                return 'href="javascript:void(0)" onclick="Swal.fire({icon: \'info\', title: \'Próximamente\', text: \'Esta red social no está disponible en este momento.\', confirmButtonColor: \'#dc3545\'})"';
                            }
                            return 'href="' . e($url) . '" target="_blank" rel="noopener noreferrer"';
                        };
                    @endphp
                    <div class="d-flex gap-3 mb-4 flex-wrap">
                        <a {!! $getFooterSocialLink('url_instagram') !!} class="text-danger" title="Instagram"><i class="fab fa-instagram fs-5"></i></a>
                        <a {!! $getFooterSocialLink('url_twitter') !!} class="text-danger" title="X"><i class="fa-brands fa-x-twitter fs-5"></i></a>
                        <a {!! $getFooterSocialLink('url_youtube') !!} class="text-danger" title="YouTube"><i class="fab fa-youtube fs-5"></i></a>
                        <a {!! $getFooterSocialLink('url_tiktok') !!} class="text-danger" title="TikTok"><i class="fab fa-tiktok fs-5"></i></a>
                        <a {!! $getFooterSocialLink('url_telegram') !!} class="text-danger" title="Telegram"><i class="fab fa-telegram fs-5"></i></a>
                        <a {!! $getFooterSocialLink('url_facebook') !!} class="text-danger" title="Facebook"><i class="fab fa-facebook fs-5"></i></a>
                        <a {!! $getFooterSocialLink('url_threads') !!} class="text-danger" title="Threads"><i class="fa-brands fa-threads fs-5"></i></a>
                    </div>
                    <p class="small text-muted mb-0">Caracas, Venezuela. Sede Principal Altagracia.</p>
                </div>
            </div>
            <hr class="my-5 opacity-5">
            <div class="text-center small text-muted mb-0">
                <p class="mb-1"><span style="display:inline-block; transform: scaleX(-1);">&copy;</span> {{ date('Y') }} Instituto Venezolano de los Seguros Sociales | Todos los derechos reservados</p>
                <p class="mb-0">Desarrollado por la Dirección General de Informática</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" nonce="{{ app('csp-nonce') }}"></script>
    <script src="{{ asset('js/aos.js') }}" nonce="{{ app('csp-nonce') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}" nonce="{{ app('csp-nonce') }}"></script>
    <script src="{{ asset('js/publico/aos-init.js') }}" nonce="{{ app('csp-nonce') }}"></script>
    
    <script nonce="{{ app('csp-nonce') }}">
        // Listeners globales para eventos despachados por Livewire
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                Swal.fire({
                    icon: data.icon || 'info',
                    title: data.title || '',
                    text: data.text || '',
                    confirmButtonColor: data.icon === 'error' ? '#d33' : '#3f6087',
                    confirmButtonText: 'Aceptar'
                });
            });

            Livewire.on('abrir-ventana-html', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                const newWindow = window.open('', '_blank');
                if (newWindow) {
                    newWindow.document.open();
                    newWindow.document.write(data.html);
                    newWindow.document.close();
                } else {
                    Swal.fire({
                        title: 'Popups Bloqueados',
                        text: 'Por favor, habilite las ventanas emergentes (pop-ups) en su navegador para poder ver la planilla.',
                        icon: 'warning',
                        confirmButtonText: 'Entendido'
                    });
                }
            });

            Livewire.on('cerrar-modal', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                const modalEl = document.getElementById(data.id);
                if (modalEl && window.bootstrap) {
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();
                }
            });
        });

        // Limpieza de modales Bootstrap en navegaciones SPA con wire:navigate
        document.addEventListener('livewire:navigating', () => {
            document.querySelectorAll('.modal.show').forEach(el => {
                if (window.bootstrap) {
                    const modal = bootstrap.Modal.getInstance(el);
                    if (modal) modal.hide();
                }
            });
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });

        document.addEventListener('livewire:navigated', () => {
            // Posicionamiento de scroll inteligente (respetando hashes como #servicios)
            const hash = window.location.hash;
            if (hash) {
                const targetEl = document.querySelector(hash);
                if (targetEl) {
                    targetEl.scrollIntoView({ behavior: 'smooth' });
                }
            } else {
                window.scrollTo({ top: 0, behavior: 'instant' });
            }

            // Reiniciar carruseles Bootstrap si existen en la página
            if (window.bootstrap) {
                document.querySelectorAll('[data-bs-ride="carousel"]').forEach(el => {
                    bootstrap.Carousel.getOrCreateInstance(el);
                });
            }

            // Mostrar Alerta Emergente (Popup Inicial)
            checkModalPromocional();
        });

        function checkModalPromocional() {
            const modalEl = document.getElementById('modalPromocional');
            if (!modalEl || modalEl.dataset.alertaMostrada || !window.bootstrap) return;

            const imgEl = modalEl.querySelector('img');
            const abrir = () => {
                if (modalEl.dataset.alertaAbierta) return;
                modalEl.dataset.alertaAbierta = 'true';
                modalEl.dataset.alertaMostrada = 'true';
                requestAnimationFrame(() => {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                });
            };

            if (imgEl) {
                if (imgEl.complete && imgEl.naturalHeight !== 0) {
                    abrir();
                } else {
                    imgEl.addEventListener('load', abrir, { once: true });
                    // Timeout de respaldo por si la red tarda
                    setTimeout(abrir, 1500);
                }
            } else {
                abrir();
            }
        }

        if (document.readyState !== 'loading') {
            checkModalPromocional();
        } else {
            document.addEventListener('DOMContentLoaded', checkModalPromocional);
        }
    </script>
    
    @include('partials.chatbot')
    @livewireScripts
</body>
</html>