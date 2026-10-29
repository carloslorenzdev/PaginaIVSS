<div>
    <div class="py-5" style="background-image: linear-gradient(rgba(243, 244, 246, 0.85), rgba(243, 244, 246, 0.85)), url('{{ asset('imagenes/fondo-ivss.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh;">
        <div class="container mt-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 border-bottom pb-3 gap-3">
                <h2 class="fw-bold text-dark m-0">
                    <i class="fas fa-newspaper text-danger me-2"></i> ARCHIVO DE NOTICIAS
                </h2>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" wire:loading.remove wire:target="search"></i>
                        <span class="spinner-border spinner-border-sm text-danger position-absolute top-50 start-0 translate-middle-y ms-3" wire:loading wire:target="search" role="status"></span>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               class="form-control rounded-pill ps-5 border-0 shadow-sm" 
                               placeholder="Buscar noticia..." 
                               style="min-width: 300px; background: #FFFFFF; color: #1E293B; height: 45px; border: 1px solid rgba(0,0,0,0.08);">
                        @if($search)
                            <button class="btn btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-2 text-decoration-none" wire:click="clearSearch" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                    <a wire:navigate href="/" class="btn-ultimate btn-ultimate-red">
                        <i class="fas fa-arrow-left me-1"></i> VOLVER
                    </a>
                </div>
            </div>

            {{-- SKELETON PLACEHOLDERS --}}
            <div wire:loading wire:target="search, clearSearch, previousPage, nextPage, gotoPage" class="row g-4 mb-4">
                @for($i = 0; $i < 6; $i++)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden bg-white rounded-3 animate-pulse">
                            <div class="bg-light" style="height: 200px; width: 100%; background-color: #e2e8f0;"></div>
                            <div class="card-body p-4">
                                <div class="rounded mb-2" style="height: 18px; width: 80%; background-color: #cbd5e1;"></div>
                                <div class="rounded mb-1" style="height: 14px; width: 100%; background-color: #f1f5f9;"></div>
                                <div class="rounded mb-3" style="height: 14px; width: 65%; background-color: #f1f5f9;"></div>
                            </div>
                            <div class="card-footer bg-white border-top-0 pt-0 pb-3 px-4 d-flex justify-content-between align-items-center">
                                <div class="rounded" style="height: 12px; width: 90px; background-color: #e2e8f0;"></div>
                                <div class="rounded" style="height: 12px; width: 60px; background-color: #e2e8f0;"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- CONTENIDO REAL --}}
            <div wire:loading.remove wire:target="search, clearSearch, previousPage, nextPage, gotoPage" class="row g-4">
                @forelse($noticias as $index => $noticia)
                    @php
                        $imagenUrl = $noticia->medios->first() ? asset('storage/' . $noticia->medios->first()->ruta) : asset('img/imagen.jpg');
                    @endphp
                    <div class="col-md-4" wire:key="noticia-{{ $noticia->id }}">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden news-card-highlight news-card-modern position-relative bg-white rounded-3">
                            <a wire:navigate href="{{ route('noticias.show', $noticia->slug) }}" class="text-decoration-none text-dark d-flex flex-column h-100">
                                <div class="news-thumb-container position-relative overflow-hidden" style="height: 200px;">
                                    <img src="{{ $imagenUrl }}" onerror="this.onerror=null;this.src='{{ asset('img/imagen.jpg') }}';" class="card-img-top news-img-zoom w-100 h-100 object-fit-cover" alt="{{ $noticia->titulo }}">
                                </div>
                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fw-bold text-danger mb-2 line-clamp-2" style="font-size: 1.1rem; line-height: 1.4;">{{ $noticia->titulo }}</h5>
                                    <p class="card-text small text-muted flex-grow-1">
                                        {{ Str::limit($noticia->resumen ?? strip_tags($noticia->contenido), 140) }}
                                    </p>
                                </div>
                            </a>
                            <div class="card-footer bg-white border-top-0 pt-0 pb-3 px-4 d-flex justify-content-between align-items-center">
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    <i class="fas fa-calendar-alt me-1 text-danger"></i> {{ $noticia->fecha_publicacion->format('d/m/Y') }} a las {{ $noticia->fecha_publicacion->format('h:i A') }}
                                </div>
                                <a wire:navigate href="{{ route('noticias.show', $noticia->slug) }}" class="text-danger small fw-bold text-decoration-none">
                                    Leer más <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="bg-white rounded-4 p-5 shadow-sm max-w-md mx-auto" style="max-width: 450px; margin: 0 auto;">
                            <i class="fas fa-newspaper text-muted mb-3 opacity-50" style="font-size: 3.5rem;"></i>
                            <h4 class="fw-bold text-dark">No se encontraron noticias</h4>
                            @if($search)
                                <p class="text-muted small mb-3">No hay publicaciones que coincidan con "{{ $search }}".</p>
                                <button wire:click="clearSearch" class="btn btn-outline-danger rounded-pill px-4 btn-sm">
                                    Ver todas las noticias
                                </button>
                            @else
                                <p class="text-muted small mb-0">No hay noticias publicadas actualmente.</p>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Paginación -->
            @if($noticias->hasPages())
                <div class="d-flex justify-content-center mt-5 pt-3">
                    {{ $noticias->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
