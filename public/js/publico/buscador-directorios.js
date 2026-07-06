document.addEventListener('turbo:load', function() {
    // Buscador interactivo genérico
    const buscador = document.getElementById('buscadorEstados');
    const items = document.querySelectorAll('.estado-item');

    let directoryData = {};
    const dataElement = document.getElementById('directorio-data');
    if (dataElement) {
        try {
            directoryData = JSON.parse(dataElement.textContent);
        } catch (e) {
            console.error("Error parsing directorio data", e);
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

    // Modal logic for all directories (using event delegation for robustness)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-ver-oficina, .btn-ver-farmacia, .btn-ver-centro');
        if (!btn) return;

        const estado = btn.getAttribute('data-estado');
        if (!estado) return;
        
        const estadoNombreEl = document.getElementById('modalEstadoNombre');
        if(estadoNombreEl) estadoNombreEl.textContent = estado;
        
        const container = document.getElementById('oficinasListContainer') || 
                          document.getElementById('farmaciasListContainer') || 
                          document.getElementById('centrosListContainer');
                          
        if(!container) return;
        container.innerHTML = ''; // Clear previous

        if (directoryData[estado] && directoryData[estado].length > 0) {
            const accordionHtml = document.createElement('div');
            
            directoryData[estado].forEach((item, index) => {
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
    });

    // Event delegation for dynamically added accordions
    const genericContainer = document.getElementById('oficinasListContainer') || 
                             document.getElementById('farmaciasListContainer') || 
                             document.getElementById('centrosListContainer');
                             
    if (genericContainer) {
        genericContainer.removeEventListener('click', window._accordionClickHandler);
        window._accordionClickHandler = function(e) {
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
        };
        genericContainer.addEventListener('click', window._accordionClickHandler);
    }
});
