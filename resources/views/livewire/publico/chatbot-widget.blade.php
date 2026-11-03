<div id="ivss-chatbot-widget" x-data="{ isOpen: false }">

    {{-- Botón Flotante para Abrir Chatbot --}}
    <button type="button" 
            id="btn-chatbot-open"
            x-show="!isOpen" 
            @click="isOpen = true" 
            class="ivss-chatbot-toggle-btn" 
            aria-label="Abrir Asistente">
        <svg viewBox="0 0 130 130" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" style="overflow: visible;">
            <defs>
                <linearGradient id="bubbleGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#ff4d4d" />
                    <stop offset="50%" stop-color="#cc0000" />
                    <stop offset="100%" stop-color="#8b0000" />
                </linearGradient>
                <filter id="shadow" x="-20%" y="-20%" width="150%" height="150%">
                    <feDropShadow dx="3" dy="6" stdDeviation="4" flood-opacity="0.4"/>
                </filter>
            </defs>

            <!-- Burbuja de Chat Roja 3D -->
            <circle cx="55" cy="60" r="45" fill="url(#bubbleGrad)" filter="url(#shadow)" stroke="#ff6666" stroke-width="1.5"/>
            
            <!-- Círculo Blanco Interior -->
            <circle cx="55" cy="60" r="34" fill="#ffffff" />
            
            <!-- Logo IVSS -->
            <image href="{{ asset('img/ivss-logo-rojo.png') }}" x="25" y="38" width="60" height="45" preserveAspectRatio="xMidYMid meet" />

            <!-- Robot en 2D Vectorial -->
            <g transform="translate(68, -5)">
                <ellipse cx="20" cy="55" rx="14" ry="4" fill="rgba(0,0,0,0.3)"/>
                <line x1="20" y1="12" x2="20" y2="0" stroke="#8b0000" stroke-width="2"/>
                <circle cx="20" cy="0" r="4" fill="#ff4d4d"/>
                <rect x="4" y="12" width="32" height="24" rx="8" fill="url(#bubbleGrad)" stroke="#8b0000" stroke-width="1"/>
                <rect x="8" y="16" width="24" height="15" rx="4" fill="#4d0000"/>
                <circle cx="14" cy="22" r="2" fill="#ffffff"/>
                <circle cx="26" cy="22" r="2" fill="#ffffff"/>
                <path d="M 14,27 Q 20,31 26,27" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M 12,38 L 28,38 L 32,55 L 8,55 Z" fill="url(#bubbleGrad)" stroke="#8b0000" stroke-width="1"/>
                <rect x="1" y="40" width="8" height="13" rx="3" fill="#cc0000" stroke="#8b0000" stroke-width="1"/>
                <rect x="31" y="40" width="8" height="13" rx="3" fill="#cc0000" stroke="#8b0000" stroke-width="1"/>
            </g>
        </svg>
    </button>

    {{-- Ventana Principal del Chatbot --}}
    <div x-show="isOpen" 
         x-cloak
         class="ivss-chatbot-container shadow-lg">

        {{-- Encabezado --}}
        <div class="ivss-chatbot-header bg-danger text-white p-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('img/ivss-logo-rojo.png') }}" class="ivss-chatbot-avatar bg-white rounded-circle p-1" width="35" height="35" alt="IVSS">
                <div>
                    <h6 class="mb-0 fw-bold">Asistente IVSS</h6>
                    <small class="opacity-75">En línea</small>
                </div>
            </div>
            <button type="button" 
                    id="btn-chatbot-close"
                    @click="isOpen = false" 
                    class="btn btn-link text-white p-0 text-decoration-none" 
                    aria-label="Cerrar">
                <i class="fas fa-times fs-5"></i>
            </button>
        </div>
        
        {{-- Área de Mensajes --}}
        <div id="ivss-chatbot-messages" class="ivss-chatbot-messages p-3">
            @foreach($messages as $msg)
                @if($msg['sender'] === 'user')
                    <div class="ivss-chatbot-msg user-msg mb-3" wire:key="{{ $msg['id'] }}">
                        <div class="ivss-chatbot-bubble shadow-sm p-2 px-3 rounded-3">
                            {{ $msg['text'] }}
                        </div>
                    </div>
                @else
                    <div class="ivss-chatbot-msg bot-msg mb-3" wire:key="{{ $msg['id'] }}">
                        <div class="ivss-chatbot-bubble shadow-sm p-3 rounded-3">
                            @if($msg['type'] === 'menu')
                                <p class="mb-2">¡Hola! Bienvenido al portal del Instituto Venezolano de los Seguros Sociales.</p>
                                <p class="mb-2 fw-bold">¿En qué puedo ayudarte hoy?</p>
                                
                                <div class="ivss-chatbot-quick-options d-flex flex-column gap-2 mt-3">
                                    <button type="button" 
                                            wire:click="seleccionarOpcion('pension')" 
                                            class="btn btn-outline-danger btn-sm text-start ivss-btn-option" 
                                            wire:loading.attr="disabled">
                                        <i class="fas fa-user-clock me-2"></i> Información pensión.
                                    </button>
                                    <button type="button" 
                                            wire:click="seleccionarOpcion('medicamentos')" 
                                            class="btn btn-outline-danger btn-sm text-start ivss-btn-option" 
                                            wire:loading.attr="disabled">
                                        <i class="fas fa-pills me-2"></i> Medicamentos Alto Costo.
                                    </button>
                                    <button type="button" 
                                            id="btn-chatbot-gps"
                                            wire:click="pedirGps" 
                                            class="btn btn-outline-danger btn-sm text-start ivss-btn-option" 
                                            wire:loading.attr="disabled">
                                        <i class="fas fa-hospital me-2"></i> Centro de Salud Cercano.
                                    </button>
                                    <button type="button" 
                                            wire:click="seleccionarOpcion('hemodialisis')" 
                                            class="btn btn-outline-danger btn-sm text-start ivss-btn-option" 
                                            wire:loading.attr="disabled">
                                        <i class="fas fa-procedures me-2"></i> Hemodiálisis.
                                    </button>
                                </div>
                            @else
                                <div class="bot-text">
                                    {!! clean($msg['text']) !!}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Botón de Regresar al inicio --}}
                    @if($loop->last && $msg['type'] !== 'menu' && !$isThinking)
                        <div class="ivss-chatbot-msg bot-msg mb-3">
                            <button type="button" wire:click="reiniciar" class="btn btn-sm btn-light border text-danger rounded-pill ivss-btn-option shadow-sm" wire:loading.attr="disabled">
                                <i class="fas fa-undo-alt me-1"></i> Regresar al inicio
                            </button>
                        </div>
                    @endif
                @endif
            @endforeach

            {{-- Indicador de Escribiendo (Aparece abajo del mensaje del usuario mientras piensa o carga) --}}
            @if($isThinking)
                <div class="ivss-chatbot-msg bot-msg mb-3">
                    <div class="typing-indicator shadow-sm">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            @endif
            <div class="ivss-chatbot-msg bot-msg mb-3" wire:loading wire:target="enviarMensaje,seleccionarOpcion,procesarRespuestaBot,generarRespuesta,pedirGps,reiniciar">
                <div class="typing-indicator shadow-sm">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>
        </div>
        
        {{-- Formulario de Entrada (Siempre disponible para escribir consultas manuales) --}}
        <div class="ivss-chatbot-footer p-3 border-top">
            <form wire:submit="enviarMensaje" class="d-flex gap-2">
                <input type="text" 
                       wire:model="inputMessage" 
                       class="form-control rounded-pill" 
                       placeholder="Escribe tu consulta..." 
                       autocomplete="off"
                       maxlength="500"
                       wire:loading.attr="disabled"
                       wire:target="enviarMensaje">
                <button type="submit" 
                        class="btn btn-danger rounded-circle p-2 d-flex align-items-center justify-content-center" 
                        style="width: 40px; height: 40px;" 
                        wire:loading.attr="disabled"
                        wire:target="enviarMensaje"
                        aria-label="Enviar mensaje">
                    <i class="fas fa-paper-plane" wire:loading.remove wire:target="enviarMensaje"></i>
                    <i class="fas fa-spinner fa-spin" wire:loading wire:target="enviarMensaje"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- Script nativo directo (SIN @script para evitar que el parser CSP de Livewire lo evalúe erróneamente) --}}
    <script nonce="{{ app('csp-nonce') }}">
        (function () {
            function scrollChat() {
                setTimeout(function () {
                    var el = document.getElementById('ivss-chatbot-messages');
                    if (el) {
                        el.scrollTop = el.scrollHeight;
                    }
                }, 60);
            }

            function getChatbotWire() {
                var widget = document.getElementById('ivss-chatbot-widget');
                if (widget && window.Livewire) {
                    var wireId = widget.getAttribute('wire:id');
                    return wireId ? window.Livewire.find(wireId) : null;
                }
                return null;
            }

            // Escuchar evento de scroll enviado por Livewire
            document.addEventListener('livewire:init', function () {
                window.Livewire.on('chat-scrolled', scrollChat);
            });

            // Si Livewire ya inicializó previamente
            if (window.Livewire) {
                window.Livewire.on('chat-scrolled', scrollChat);
            }

            // Al abrir el chat desde el botón flotante, hacer scroll hacia el final
            document.addEventListener('click', function (e) {
                if (e.target.closest('#btn-chatbot-open')) {
                    scrollChat();
                }
            });

            // Gesto de usuario directo para solicitar permisos de geolocalización al navegador
            document.addEventListener('click', function (e) {
                var btnGps = e.target.closest('#btn-chatbot-gps');
                if (!btnGps) return;

                scrollChat();

                var wire = getChatbotWire();
                if (!wire) return;

                var respondido = false;

                function mostrarMensajeManual() {
                    if (respondido) return;
                    respondido = true;
                    wire.responderErrorGps('No se pudo determinar tu ubicación exacta automáticamente. Por favor escribe <b>centros de salud en</b> seguido de tu estado (Ejemplo: <i>centros de salud en Distrito Capital</i> o <i>Miranda</i>).');
                }

                function resolverPorIp() {
                    if (respondido) return;
                    fetch('https://get.geojs.io/v1/ip/geo.json', { cache: 'no-store' })
                        .then(function (r) { return r.json(); })
                        .then(function (data) {
                            if (respondido) return;
                            var estado = data.region || data.city;
                            if (estado) {
                                respondido = true;
                                wire.generarRespuesta('ubicacion_ip:' + estado);
                            } else {
                                resolverPorIpInfo();
                            }
                        })
                        .catch(function () {
                            resolverPorIpInfo();
                        });
                }

                function resolverPorIpInfo() {
                    if (respondido) return;
                    fetch('https://ipinfo.io/json', { cache: 'no-store' })
                        .then(function (r) { return r.json(); })
                        .then(function (data) {
                            if (respondido) return;
                            var estado = data.region || data.city;
                            if (estado) {
                                respondido = true;
                                wire.generarRespuesta('ubicacion_ip:' + estado);
                            } else {
                                mostrarMensajeManual();
                            }
                        })
                        .catch(function () {
                            mostrarMensajeManual();
                        });
                }

                if (!navigator.geolocation) {
                    resolverPorIp();
                    return;
                }

                var fallbackTimer = setTimeout(function () {
                    if (!respondido) {
                        resolverPorIp();
                    }
                }, 10000);

                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        if (respondido) return;
                        respondido = true;
                        clearTimeout(fallbackTimer);
                        wire.generarRespuesta('ubicacion:' + pos.coords.latitude + ',' + pos.coords.longitude);
                    },
                    function (err) {
                        clearTimeout(fallbackTimer);
                        // Si el permiso fue bloqueado o hay error en el contexto SSL, recurrir inmediatamente a la IP
                        resolverPorIp();
                    },
                    { enableHighAccuracy: false, timeout: 9500, maximumAge: 60000 }
                );
            });
        })();
    </script>

</div>
