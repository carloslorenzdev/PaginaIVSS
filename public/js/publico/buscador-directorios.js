document.addEventListener('turbo:load', function() {
    // Buscador interactivo generico
    const buscador = document.getElementById('buscadorEstados');
    const items = document.querySelectorAll('.estado-item');

    let directoryData = {};
    if (typeof window.currentDirectoryData !== 'undefined') {
        directoryData = window.currentDirectoryData;
    } else {
        const dataElement = document.getElementById('directorio-data');
        if (dataElement) {
            try {
                directoryData = JSON.parse(dataElement.textContent);
            } catch (e) {
                console.error("Error parsing directorio data", e);
            }
        }
    }

    if(buscador) {
        buscador.addEventListener('keyup', function(e) {
            const term = e.target.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            
            items.forEach(item => {
                const nombre = item.querySelector('.estado-nombre').textContent.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                if(nombre.includes(term)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Siempre remover el listener anterior si existe para asegurarnos de usar la última versión del código
    if (window._directoryClickHandler) {
        document.removeEventListener('click', window._directoryClickHandler);
    }

    window._directoryClickHandler = function(e) {
        const btn = e.target.closest('.btn-ver-oficina, .btn-ver-farmacia, .btn-ver-centro');
        if (!btn) return;

        // Al hacer click, asegurarnos de usar la data más reciente de la vista actual
        let currentDirectoryData = typeof window.currentDirectoryData !== 'undefined' ? window.currentDirectoryData : {};
        
        // Fallback si no está la variable global
        if (Object.keys(currentDirectoryData).length === 0) {
            const currentDataEl = document.getElementById('directorio-data');
            if (currentDataEl) {
                try {
                    currentDirectoryData = JSON.parse(currentDataEl.textContent);
                } catch (err) {}
            }
        }

        const estado = btn.getAttribute('data-estado');
        if (!estado) return;
        
        const modalTarget = btn.getAttribute('data-bs-target');
        const targetModal = document.querySelector(modalTarget);
        if (!targetModal) return;

        const estadoNombreEl = targetModal.querySelector('#modalEstadoNombre');
        if(estadoNombreEl) estadoNombreEl.textContent = estado;
        
        const container = targetModal.querySelector('#oficinasListContainer') || 
                          targetModal.querySelector('#farmaciasListContainer') || 
                          targetModal.querySelector('#centrosListContainer');
                          
        if(!container) return;
        container.innerHTML = ''; // Clear previous

        // Buscar la llave que hace match sin acentos y en mayusculas/minusculas
        const searchKey = estado.toUpperCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        let matchedKey = estado;
        
        for (const key in currentDirectoryData) {
            if (key.toUpperCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "") === searchKey) {
                matchedKey = key;
                break;
            }
        }

        if (currentDirectoryData[matchedKey] && currentDirectoryData[matchedKey].length > 0) {
            const accordionHtml = document.createElement('div');
            
            currentDirectoryData[matchedKey].forEach((item, index) => {
                const itemName = item.nombre || item.facility;
                
                const itemHtml = `
                <div class="border rounded-3 mb-3 shadow-sm bg-white overflow-hidden">
                    <div class="p-3 bg-light text-primary d-flex justify-content-between align-items-center custom-accordion-header" style="cursor: pointer;">
                        <span class="fw-bold"><i class="fas fa-building me-2"></i> ${itemName}</span>
                        <i class="fas fa-chevron-down text-muted" style="transition: transform 0.3s;"></i>
                    </div>
                    <div class="custom-accordion-body" style="background-color: #fff;">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fas fa-map-marker-alt text-danger mt-1 me-3"></i>
                            <div>
                                <strong class="d-block text-dark">Dirección:</strong>
                                <span class="text-secondary">${item.direccion || item.address || 'Información no disponible'}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="fas fa-phone-alt text-success mt-1 me-3"></i>
                            <div>
                                <strong class="d-block text-dark">Teléfono:</strong>
                                <span class="text-secondary">${item.telefono || 'Información no disponible'}</span>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                accordionHtml.innerHTML += itemHtml;
            });
            container.appendChild(accordionHtml);
        } else {
            container.innerHTML = `
                <div class="text-center p-4">
                    <i class="fas fa-info-circle text-muted fa-3x mb-3 opacity-50"></i>
                    <h5 class="fw-bold text-dark">Información no disponible</h5>
                    <p class="text-muted mb-0">Esta información no se encuentra disponible en este momento.</p>
                </div>
            `;
        }
    };
    
    document.addEventListener('click', window._directoryClickHandler);

    // Event delegation for dynamically added accordions
    if (!window._accordionInit) {
        window._accordionInit = true;
        document.addEventListener('click', function(e) {
            const header = e.target.closest('.custom-accordion-header');
            if (header) {
                const body = header.nextElementSibling;
                if (body) {
                    body.classList.toggle('open');
                }
                const icon = header.querySelector('.fa-chevron-down');
                if (icon) {
                    icon.classList.toggle('fa-flip-vertical');
                }
            }
        });
    }
});
