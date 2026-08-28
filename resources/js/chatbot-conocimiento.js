// Use event delegation or IIFE to handle Turbo replacements
        (function() {
            function initConocimientos() {
                const modal = document.getElementById('modal-registro');
                const form = document.getElementById('form-registro');
                const formMethod = document.getElementById('form-method');
                const modalTitle = document.getElementById('modal-title');
                
                const btnNuevo = document.getElementById('btn-nuevo-registro');
                const btnCerrar = document.getElementById('btn-cerrar-modal');
                const btnCancelar = document.getElementById('btn-cancelar-modal');
                const formDelete = document.getElementById('form-delete');
                
                if (!modal || !form || !btnNuevo) return; // Prevent errors if DOM missing
                
                // Extraer la url de store desde el action original del formulario (ya que vite no parsea blade)
                const urlStore = form.getAttribute('action');

                function openModal() {
                    modal.classList.remove('hidden');
                }
                
                function closeModal() {
                    modal.classList.add('hidden');
                }
                
                // Clear existing listeners by cloning and replacing the button to avoid duplicates
                const newBtnNuevo = btnNuevo.cloneNode(true);
                btnNuevo.parentNode.replaceChild(newBtnNuevo, btnNuevo);
                
                newBtnNuevo.addEventListener('click', () => {
                    form.action = urlStore;
                    formMethod.value = 'POST';
                    modalTitle.textContent = 'Nuevo Conocimiento';
                    form.reset();
                    document.getElementById('input-activo').checked = true;
                    openModal();
                });
                
                btnCerrar.addEventListener('click', closeModal);
                btnCancelar.addEventListener('click', closeModal);
                
                // Cerrar al hacer clic fuera
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModal();
                });

                // Remove previous global click listener if exists
                if (window._conocimientoClickListener) {
                    document.removeEventListener('click', window._conocimientoClickListener);
                }

                const modalEliminar = document.getElementById('modal-eliminar');
                const btnCerrarEliminar = document.getElementById('btn-cerrar-eliminar');
                const btnConfirmarEliminar = document.getElementById('btn-confirmar-eliminar');

                function closeEliminarModal() {
                    modalEliminar.classList.add('hidden');
                    modalEliminar.classList.remove('flex');
                }

                btnCerrarEliminar.addEventListener('click', closeEliminarModal);
                modalEliminar.addEventListener('click', (e) => {
                    if (e.target === modalEliminar) closeEliminarModal();
                });

                btnConfirmarEliminar.addEventListener('click', () => {
                    formDelete.submit();
                });

                // Event delegation for Edit and Delete buttons
                window._conocimientoClickListener = function(e) {
                    // Handle Edit
                    const btnEdit = e.target.closest('.btn-edit');
                    if (btnEdit) {
                        form.action = btnEdit.dataset.updateUrl;
                        formMethod.value = 'PUT';
                        modalTitle.textContent = 'Editar Conocimiento';
                        
                        document.getElementById('input-pregunta').value = btnEdit.dataset.pregunta;
                        document.getElementById('input-palabras').value = btnEdit.dataset.palabras_clave;
                        document.getElementById('input-respuesta').value = btnEdit.dataset.respuesta;
                        document.getElementById('input-activo').checked = btnEdit.dataset.activo === '1';
                        
                        openModal();
                        return;
                    }

                    // Handle Delete
                    const btnDelete = e.target.closest('.btn-delete');
                    if (btnDelete) {
                        formDelete.action = btnDelete.dataset.deleteUrl;
                        modalEliminar.classList.remove('hidden');
                        modalEliminar.classList.add('flex');
                    }
                };

                document.addEventListener('click', window._conocimientoClickListener);

                // Auto-open modal if URL has ?pregunta=
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('pregunta')) {
                    newBtnNuevo.click();
                    document.getElementById('input-pregunta').value = urlParams.get('pregunta');
                    
                    // Remove the query param so it doesn't reopen on reload
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }

            // Init on first load and on Turbo load
            initConocimientos();
            document.addEventListener('turbo:load', initConocimientos);
        })();