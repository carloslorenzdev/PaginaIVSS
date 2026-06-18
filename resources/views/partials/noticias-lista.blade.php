<div class="row g-4">
    @if($noticias->count() > 0)
        @foreach($noticias as $index => $noticia)
            @php
                $imagenUrl = $noticia->medios->first() ? asset('storage/' . $noticia->medios->first()->ruta) : 'https://via.placeholder.com/400x250?text=Noticia';
            @endphp
            <div class="col-md-4" id="noticia-{{ $noticia->id }}" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                <div class="card h-100 border-0 shadow-sm overflow-hidden news-card-highlight news-card-modern position-relative">
                    <a href="{{ route('noticias.show', $noticia->slug) }}" class="text-decoration-none text-dark d-flex flex-column h-100">
                    <div class="news-thumb-container">
                        <img src="{{ $imagenUrl }}" onerror="this.onerror=null;this.src='{{ asset('img/imagen.jpg') }}';" class="card-img-top news-img-zoom" alt="{{ $noticia->titulo }}">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-danger mb-3">{{ $noticia->titulo }}</h5>
                        <p class="card-text small text-muted flex-grow-1">
                            {{ Str::limit($noticia->resumen ?? strip_tags($noticia->contenido), 150) }}
                        </p>
                    </div>
                    </a>
                    <div class="card-footer bg-white border-top-0 pt-0 pb-3 d-flex justify-content-between align-items-center">
                        <div class="text-muted" style="font-size: 0.75rem;">
                            <i class="fas fa-calendar-alt mr-1"></i> {{ $noticia->fecha_publicacion->format('d/m/Y') }} a las {{ $noticia->fecha_publicacion->format('h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12 text-center py-5">
            <i class="fas fa-search text-muted mb-3" style="font-size: 4rem;"></i>
            <h4 class="text-muted">No se encontraron noticias.</h4>
        </div>
    @endif
</div>

<!-- Paginación -->
<div class="d-flex justify-content-center mt-5 pt-4">
    {{ $noticias->appends(request()->query())->links() }}
</div>
