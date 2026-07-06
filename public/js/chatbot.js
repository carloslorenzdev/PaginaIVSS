document.addEventListener('turbo:load', () => {
    const widgetContainer = document.getElementById('ivss-chatbot-widget');
    if (!widgetContainer || widgetContainer.hasAttribute('data-initialized')) {
        return; // Ya está inicializado o no existe
    }
    widgetContainer.setAttribute('data-initialized', 'true');

    const toggleBtn = document.getElementById('ivss-chatbot-toggle');
    const closeBtn = document.getElementById('ivss-chatbot-close');
    const container = document.getElementById('ivss-chatbot-container');
    const messagesContainer = document.getElementById('ivss-chatbot-messages');

    const initialMenuHTML = `
        <div class="ivss-chatbot-msg bot-msg mb-3">
            <div class="ivss-chatbot-bubble shadow-sm p-3 rounded-3">
                <p class="mb-2 fw-bold">¿Qué necesitas consultar?</p>
                <div class="ivss-chatbot-quick-options d-flex flex-column gap-2 mt-2">
                    <button class="btn btn-outline-danger btn-sm text-start ivss-btn-option" data-option="pension">
                        <i class="fas fa-user-clock me-2"></i> Información pensión.
                    </button>
                    <button class="btn btn-outline-danger btn-sm text-start ivss-btn-option" data-option="medicamentos">
                        <i class="fas fa-pills me-2"></i> Medicamentos Alto Costo.
                    </button>
                    <button class="btn btn-outline-danger btn-sm text-start ivss-btn-option" data-option="centro_salud_cercano">
                        <i class="fas fa-hospital me-2"></i> Centro de Salud Cercano.
                    </button>
                    <button class="btn btn-outline-danger btn-sm text-start ivss-btn-option" data-option="hemodialisis">
                        <i class="fas fa-procedures me-2"></i> Hemodiálisis.
                    </button>
                </div>
            </div>
        </div>
    `;

    // Toggle Chatbot
    toggleBtn.addEventListener('click', () => {
        container.classList.remove('d-none');
        toggleBtn.classList.add('d-none');
        scrollToBottom();
    });

    closeBtn.addEventListener('click', () => {
        container.classList.add('d-none');
        toggleBtn.classList.remove('d-none');
    });

    // Handle button clicks
    messagesContainer.addEventListener('click', (e) => {
        const btn = e.target.closest('.ivss-btn-option');
        if (btn) {
            const option = btn.getAttribute('data-option');
            
            if (option === 'restart') {
                restartFlow();
            } else {
                handleOptionSelection(option, btn.innerText.trim());
            }
        }
    });

    function reenableButtons() {
        const buttons = document.querySelectorAll('.ivss-btn-option');
        buttons.forEach(btn => btn.style.pointerEvents = 'auto');
    }

    function handleOptionSelection(optionKey, buttonText) {
        // Prevent multiple clicks
        const buttons = document.querySelectorAll('.ivss-btn-option');
        buttons.forEach(btn => btn.style.pointerEvents = 'none');
        
        appendUserMessage(buttonText);
        
        if (optionKey === 'centro_salud_cercano') {
            appendBotMessage("Determinando tu ubicación de forma automática...");
            
            let locationSent = false;

            function intentarUbicacionPorIP() {
                if (locationSent) return;
                fetch('https://ipinfo.io/json')
                    .then(response => response.json())
                    .then(data => {
                        if (locationSent) return;
                        locationSent = true;
                        if (data.region) {
                            enviarMensajeBackend("UBICACION_IP:" + data.region);
                        } else {
                            throw new Error('Sin región en la respuesta de IP');
                        }
                    })
                    .catch(error => {
                        appendBotMessage("El navegador bloqueó el permiso GPS por estar en un entorno local (Laragon) y la detección por IP también falló. Por favor escribe <b>'hospitales en' seguido de tu estado</b> (Ejemplo: hospitales en Miranda).");
                        appendRestartButton();
                        reenableButtons();
                    });
            }

            // Intento 1: GPS del Navegador (Requiere HTTPS)
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        if (locationSent) return;
                        locationSent = true;
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        enviarMensajeBackend("UBICACION:" + lat + "," + lon);
                    },
                    (error) => {
                        // Intento 2: Fallback a Geolocalización por IP
                        intentarUbicacionPorIP();
                    },
                    { timeout: 10000, enableHighAccuracy: true }
                );
            } else {
                intentarUbicacionPorIP();
            }
        } else {
            enviarMensajeBackend(optionKey);
        }
    }

    function appendUserMessage(text) {
        const msg = document.createElement('div');
        msg.className = 'ivss-chatbot-msg user-msg mb-3';
        msg.innerHTML = `
            <div class="ivss-chatbot-bubble shadow-sm p-2 px-3 rounded-3">
                ${text}
            </div>
        `;
        messagesContainer.appendChild(msg);
        scrollToBottom();
    }

    function appendBotMessage(text) {
        const msg = document.createElement('div');
        msg.className = 'ivss-chatbot-msg bot-msg mb-3';
        msg.innerHTML = `
            <div class="ivss-chatbot-bubble shadow-sm p-3 rounded-3">
                ${text}
            </div>
        `;
        messagesContainer.appendChild(msg);
        scrollToBottom();
    }

    function appendRestartButton() {
        const msg = document.createElement('div');
        msg.className = 'ivss-chatbot-msg bot-msg mb-3';
        msg.innerHTML = `
            <button class="btn btn-sm btn-light border text-danger rounded-pill ivss-btn-option shadow-sm" data-option="restart">
                <i class="fas fa-undo-alt me-1"></i> Regresar al inicio
            </button>
        `;
        messagesContainer.appendChild(msg);
        scrollToBottom();
    }

    function showTypingIndicator() {
        const msg = document.createElement('div');
        msg.id = 'ivss-typing';
        msg.className = 'ivss-chatbot-msg bot-msg mb-3';
        msg.innerHTML = `
            <div class="typing-indicator shadow-sm">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        `;
        messagesContainer.appendChild(msg);
        scrollToBottom();
    }

    function removeTypingIndicator() {
        const typing = document.getElementById('ivss-typing');
        if (typing) typing.remove();
    }

    function restartFlow() {
        messagesContainer.innerHTML = '';
        messagesContainer.innerHTML = initialMenuHTML;
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Send message to local PHP backend
    async function enviarMensajeBackend(texto) {
        showTypingIndicator();
        
        try {
            // Include CSRF token if meta tag exists
            let csrfToken = '';
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta) {
                csrfToken = meta.getAttribute('content');
            }

            const response = await fetch('/api/chat-local', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ mensaje: texto })
            });

            const data = await response.json();
            
            removeTypingIndicator();
            appendBotMessage(data.respuesta);
            appendRestartButton();
            reenableButtons();
            
        } catch (error) {
            removeTypingIndicator();
            appendBotMessage("Lo siento, hubo un problema conectando con el servidor local del IVSS.");
            appendRestartButton();
            reenableButtons();
        }
    }

    // Handle text input search
    const form = document.getElementById('ivss-chatbot-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const input = document.getElementById('ivss-chatbot-input');
            const val = input.value.trim();
            if (!val) return;

            appendUserMessage(val);
            input.value = '';
            
            enviarMensajeBackend(val);
        });
    }
});
