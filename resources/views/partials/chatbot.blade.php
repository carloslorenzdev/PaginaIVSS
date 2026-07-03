<link rel="stylesheet" href="{{ asset('css/chatbot.css') }}" data-turbo-track="reload">

<div id="ivss-chatbot-widget" data-turbo-permanent>
    <button id="ivss-chatbot-toggle" class="ivss-chatbot-toggle-btn" aria-label="Abrir Asistente">
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

            <!-- Burbuja de Chat Roja 3D (Sin Cola) -->
            <circle cx="55" cy="60" r="45" fill="url(#bubbleGrad)" filter="url(#shadow)" stroke="#ff6666" stroke-width="1.5"/>
            
            <!-- Círculo Blanco Interior -->
            <circle cx="55" cy="60" r="34" fill="#ffffff" />
            
            <!-- Logo IVSS -->
            <image href="{{ asset('img/ivss-logo-rojo.png') }}" x="25" y="38" width="60" height="45" preserveAspectRatio="xMidYMid meet" />

            <!-- Robot en 2D Vectorial -->
            <g transform="translate(68, -5)">
                <!-- Sombra del robot -->
                <ellipse cx="20" cy="55" rx="14" ry="4" fill="rgba(0,0,0,0.3)"/>
                <!-- Antena -->
                <line x1="20" y1="12" x2="20" y2="0" stroke="#8b0000" stroke-width="2"/>
                <circle cx="20" cy="0" r="4" fill="#ff4d4d"/>
                <!-- Cabeza -->
                <rect x="4" y="12" width="32" height="24" rx="8" fill="url(#bubbleGrad)" stroke="#8b0000" stroke-width="1"/>
                <rect x="8" y="16" width="24" height="15" rx="4" fill="#4d0000"/>
                <!-- Ojos -->
                <circle cx="14" cy="22" r="2" fill="#ffffff"/>
                <circle cx="26" cy="22" r="2" fill="#ffffff"/>
                <!-- Sonrisa -->
                <path d="M 14,27 Q 20,31 26,27" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                <!-- Cuerpo -->
                <path d="M 12,38 L 28,38 L 32,55 L 8,55 Z" fill="url(#bubbleGrad)" stroke="#8b0000" stroke-width="1"/>
                <!-- Brazos -->
                <rect x="1" y="40" width="8" height="13" rx="3" fill="#cc0000" stroke="#8b0000" stroke-width="1"/>
                <rect x="31" y="40" width="8" height="13" rx="3" fill="#cc0000" stroke="#8b0000" stroke-width="1"/>
            </g>
        </svg>
    </button>

    <div id="ivss-chatbot-container" class="ivss-chatbot-container shadow-lg d-none">
        <div class="ivss-chatbot-header bg-danger text-white p-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('img/ivss-logo-rojo.png') }}" class="ivss-chatbot-avatar bg-white rounded-circle p-1" width="35" height="35" alt="IVSS">
                <div>
                    <h6 class="mb-0 fw-bold">Asistente IVSS</h6>
                    <small class="opacity-75">En línea</small>
                </div>
            </div>
            <button id="ivss-chatbot-close" class="btn btn-link text-white p-0 text-decoration-none">
                <i class="fas fa-times fs-5"></i>
            </button>
        </div>
        
        <div id="ivss-chatbot-messages" class="ivss-chatbot-messages p-3">
            <div class="ivss-chatbot-msg bot-msg mb-3">
                <div class="ivss-chatbot-bubble shadow-sm p-3 rounded-3">
                    <p class="mb-2">¡Hola! Bienvenido al portal del Instituto Venezolano de los Seguros Sociales.</p>
                    <p class="mb-2 fw-bold">¿En qué puedo ayudarte hoy?</p>
                    
                    <div class="ivss-chatbot-quick-options d-flex flex-column gap-2 mt-3">
                        <button class="btn btn-outline-danger btn-sm text-start ivss-btn-option" data-option="tiuna">
                            <i class="fas fa-building me-2"></i> Trámites para Empleadores (Tiuna)
                        </button>
                        <button class="btn btn-outline-danger btn-sm text-start ivss-btn-option" data-option="pensiones">
                            <i class="fas fa-user-clock me-2"></i> Requisitos para Pensión
                        </button>
                        <button class="btn btn-outline-danger btn-sm text-start ivss-btn-option" data-option="constancias">
                            <i class="fas fa-file-invoice me-2"></i> Obtener Constancias
                        </button>
                        <button class="btn btn-outline-danger btn-sm text-start ivss-btn-option" data-option="cuenta">
                            <i class="fas fa-list-ol me-2"></i> Consulta de Cuenta Individual
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Search bar fallback -->
        <div class="ivss-chatbot-footer p-3 border-top">
            <form id="ivss-chatbot-form" class="d-flex gap-2">
                <input type="text" id="ivss-chatbot-input" class="form-control rounded-pill" placeholder="Escribe tu consulta..." autocomplete="off">
                <button type="submit" class="btn btn-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/chatbot.js') }}"></script>
