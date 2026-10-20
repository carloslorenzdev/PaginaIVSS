<div x-data="directorioViewer">
    <!-- HERO SECTION -->
    <div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(10,31,61,0.9) 0%, rgba(20,50,90,0.95) 100%); z-index: 1;"></div>
        
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset($heroBg) }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                        <i class="{{ $icono }} text-primary fa-3x"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-white mb-3">{{ $titulo }}</h1>
                    <p class="lead text-white-50 mb-0">{{ $subtitulo }}</p>
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
            
            <!-- Barra de búsqueda reactiva -->
            <div class="row justify-content-center mb-5" data-aos="fade-up">
                <div class="col-lg-6 text-center">
                    <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden bg-white border">
                        <span class="input-group-text bg-white border-0 text-primary ps-4">
                            <i class="fas fa-search" wire:loading.remove wire:target="search"></i>
                            <span class="spinner-border spinner-border-sm text-primary" wire:loading wire:target="search" role="status"></span>
                        </span>
                        <input type="text" 
                               wire:model.live.debounce.250ms="search" 
                               class="form-control border-0 px-3" 
                               placeholder="Buscar por estado (Ej. Carabobo, Aragua, Zulia...)" 
                               style="box-shadow: none;">
                        @if($search)
                            <button class="btn btn-link text-muted pe-4 text-decoration-none" wire:click="$set('search', '')" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Grid de Estados -->
            <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
                @forelse($estados as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 hover-elevate transition-all overflow-hidden bg-white">
                            <div class="card-body text-center p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                        <i class="fas fa-map-marker-alt text-primary fa-2x"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">{{ $item['nombre'] }}</h5>
                                    
                                    <div class="mb-3">
                                        @if($item['total'] > 0)
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold small">
                                                <i class="fas fa-check-circle me-1"></i> {{ $item['total'] }} {{ $item['total'] === 1 ? 'disponible' : 'disponibles' }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-muted rounded-pill px-3 py-1 small">
                                                Sin sede directa
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <button type="button" 
                                        @click="verEstado('{{ $item['nombre'] }}')" 
                                        class="btn btn-outline-primary rounded-pill w-100 fw-bold py-2">
                                    @if($tipo === 'farmacia')
                                        Ver Farmacias
                                    @elseif($tipo === 'oficina_administrativa')
                                        Ver Oficinas
                                    @else
                                        Ver Centros de Salud
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="bg-white rounded-4 p-5 shadow-sm max-w-lg mx-auto" style="max-width: 500px; margin: 0 auto;">
                            <i class="fas fa-search-location text-muted fa-4x mb-3 opacity-50"></i>
                            <h4 class="fw-bold text-dark mb-2">No se encontraron estados</h4>
                            <p class="text-muted small mb-4">No hay resultados que coincidan con "{{ $search }}".</p>
                            <button wire:click="$set('search', '')" class="btn btn-outline-primary rounded-pill px-4">
                                Ver todos los estados
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-5">
                <a wire:navigate href="{{ route('inicio') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </section>

    <style>
        .hover-elevate:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
            border-bottom: 4px solid #0d6efd;
        }
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Animación suave de acordeón con CSS Grid */
        .accordion-item-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 0.85rem;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }
        .accordion-item-card:hover {
            border-color: rgba(13, 110, 253, 0.35);
        }
        .accordion-header-btn {
            background-color: #f8fafc;
            transition: background-color 0.25s ease;
        }
        .accordion-header-btn:hover {
            background-color: #f1f5f9;
        }
        .accordion-header-btn.is-active {
            background-color: #edf5ff;
        }
        .accordion-collapse-wrapper {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.32s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .accordion-collapse-wrapper.is-open {
            grid-template-rows: 1fr;
        }
        .accordion-collapse-inner {
            overflow: hidden;
        }
        .accordion-collapse-inner-content {
            opacity: 0;
            transform: translateY(-8px);
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .accordion-collapse-wrapper.is-open .accordion-collapse-inner-content {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.06s;
        }
        .chevron-icon {
            transition: transform 0.32s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .chevron-icon.is-rotated {
            transform: rotate(180deg);
        }
    </style>

    <!-- Modal Instantáneo de Instalaciones (Sin latencia de red ni recargas) -->
    <div class="modal fade" id="modalDirectorioInstalaciones" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content border-0 shadow-2xl" style="border-radius: 1.5rem; overflow: hidden;">
                <!-- Cabecera del Modal -->
                <div class="p-4 border-bottom bg-light d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                            <i class="{{ $icono }} fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-0" x-text="estadoNombre"></h4>
                            <small class="text-muted">{{ $titulo }} disponibles (<span x-text="instalaciones.length"></span>)</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <!-- Cuerpo del Modal -->
                <div class="modal-body p-4" style="max-height: 65vh; overflow-y: auto;">
                    <template x-if="instalaciones.length > 0">
                        <div class="d-flex flex-column gap-3">
                            <template x-for="(inst, index) in instalaciones" :key="inst.id">
                                <div class="accordion-item-card shadow-sm bg-white overflow-hidden mb-1">
                                    <div @click="toggleAcc(index)" 
                                         class="p-3 accordion-header-btn text-primary d-flex justify-content-between align-items-center" 
                                         :class="{ 'is-active': activeAccordion === index }"
                                         style="cursor: pointer; user-select: none;">
                                        <span class="fw-bold d-flex align-items-center">
                                            <i class="fas fa-building text-primary me-2"></i>
                                            <span x-text="inst.nombre"></span>
                                        </span>
                                        <i class="fas fa-chevron-down text-muted chevron-icon" 
                                           :class="{ 'is-rotated': activeAccordion === index }"></i>
                                    </div>
                                    
                                    <div class="accordion-collapse-wrapper" :class="{ 'is-open': activeAccordion === index }">
                                        <div class="accordion-collapse-inner">
                                            <div class="p-3 bg-white border-top accordion-collapse-inner-content">
                                                <template x-if="inst.municipio">
                                                    <div class="mb-2">
                                                        <span class="badge bg-light text-dark border px-2 py-1 small">
                                                            <i class="fas fa-map-signs text-muted me-1"></i>
                                                            <span x-text="inst.municipio"></span>
                                                            <template x-if="inst.parroquia">
                                                                <span> - <span x-text="inst.parroquia"></span></span>
                                                            </template>
                                                        </span>
                                                    </div>
                                                </template>

                                                <div class="d-flex align-items-start mb-2">
                                                    <i class="fas fa-map-marker-alt text-danger mt-1 me-3 fs-5"></i>
                                                    <div>
                                                        <strong class="d-block text-dark small text-uppercase">Dirección:</strong>
                                                        <span class="text-secondary small" x-text="inst.direccion"></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-phone-alt text-success mt-1 me-3 fs-5"></i>
                                                    <div>
                                                        <strong class="d-block text-dark small text-uppercase">Teléfono:</strong>
                                                        <span class="text-secondary small" x-text="inst.telefono"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="instalaciones.length === 0">
                        <div class="text-center py-5">
                            <i class="fas fa-info-circle text-muted fa-3x mb-3 opacity-50"></i>
                            <h5 class="fw-bold text-dark">Sin registros directos para <span x-text="estadoNombre"></span></h5>
                            <p class="text-muted small mb-0">Actualmente este estado no cuenta con sedes de este tipo registradas en el sistema. Los trámites de esta región se canalizan a través de la sede central o centro asistencial de referencia.</p>
                        </div>
                    </template>
                </div>

                <!-- Pie del Modal -->
                <div class="p-3 bg-light border-top d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de datos y componente Alpine CSP-compliant -->
    <script id="directorio-data" type="application/json">
        {!! json_encode($instalacionesMap, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <script nonce="{{ app('csp-nonce') }}">
        (function() {
            function registrarDirectorioViewer() {
                if (window.Alpine && typeof window.Alpine.data === 'function') {
                    window.Alpine.data('directorioViewer', () => ({
                        estadoNombre: '',
                        instalaciones: [],
                        activeAccordion: null,
                        datosMap: {},

                        init() {
                            const dataEl = document.getElementById('directorio-data');
                            if (dataEl) {
                                try {
                                    this.datosMap = JSON.parse(dataEl.textContent);
                                } catch (e) {
                                    this.datosMap = {};
                                }
                            }
                        },

                        verEstado(nombre) {
                            this.estadoNombre = nombre;
                            this.instalaciones = this.datosMap[nombre] || [];
                            this.activeAccordion = (this.instalaciones.length === 1) ? 0 : null;
                            const modalEl = document.getElementById('modalDirectorioInstalaciones');
                            if (modalEl && window.bootstrap) {
                                bootstrap.Modal.getOrCreateInstance(modalEl).show();
                            }
                        },

                        toggleAcc(index) {
                            this.activeAccordion = (this.activeAccordion === index) ? null : index;
                        }
                    }));
                }
            }

            registrarDirectorioViewer();
            document.addEventListener('alpine:init', registrarDirectorioViewer);
        })();
    </script>
</div>
