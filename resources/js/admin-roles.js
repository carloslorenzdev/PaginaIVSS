(function() {
            function initRoles() {
                const modalForm = document.getElementById('modal-form');
                const formRole = document.getElementById('form-role');
                const formMethod = document.getElementById('form-method');
                const inputNombre = document.getElementById('input-nombre');
                const modalTitle = document.getElementById('modal-title');
                
                const btnNuevo = document.getElementById('btn-nuevo');
                const btnCerrar = document.getElementById('btn-close-modal');
                const btnCancelar = document.getElementById('btn-cancelar');

                if (!modalForm || !formRole || !btnNuevo) return;

                function openModal() { modalForm.classList.remove('hidden'); modalForm.classList.add('flex'); }
                function closeModal() { modalForm.classList.add('hidden'); modalForm.classList.remove('flex'); }

                const newBtnNuevo = btnNuevo.cloneNode(true);
                btnNuevo.parentNode.replaceChild(newBtnNuevo, btnNuevo);
                
                newBtnNuevo.addEventListener('click', function() {
                    formRole.action = this.getAttribute('data-url');
                    formMethod.value = 'POST';
                    modalTitle.innerHTML = '<i class="bx bx-shield-plus text-teal-600"></i> Nuevo Rol';
                    formRole.reset();
                    openModal();
                });

                btnCerrar.addEventListener('click', closeModal);
                btnCancelar.addEventListener('click', closeModal);
                modalForm.addEventListener('click', (e) => { if (e.target === modalForm) closeModal(); });

                // Modal Eliminar
                const modalEliminar = document.getElementById('modal-eliminar');
                const btnCerrarEliminar = document.getElementById('btn-cerrar-eliminar');
                const formEliminar = document.getElementById('form-eliminar');
                
                function closeEliminar() { modalEliminar.classList.add('hidden'); modalEliminar.classList.remove('flex'); }
                btnCerrarEliminar.addEventListener('click', closeEliminar);
                modalEliminar.addEventListener('click', (e) => { if (e.target === modalEliminar) closeEliminar(); });

                // Event Delegation
                if (window._rolesClickListener) {
                    document.removeEventListener('click', window._rolesClickListener);
                }

                window._rolesClickListener = function(e) {
                    const btnEdit = e.target.closest('.btn-edit');
                    if (btnEdit) {
                        formRole.action = btnEdit.getAttribute('data-url');
                        formMethod.value = 'PUT';
                        modalTitle.innerHTML = '<i class="bx bx-edit text-teal-600"></i> Editar Rol';
                        inputNombre.value = btnEdit.getAttribute('data-nombre');
                        openModal();
                        return;
                    }

                    const btnDelete = e.target.closest('.btn-delete');
                    if (btnDelete) {
                        formEliminar.action = btnDelete.getAttribute('data-url');
                        document.getElementById('modal-eliminar-nombre').innerText = '"' + btnDelete.getAttribute('data-nombre') + '"';
                        modalEliminar.classList.remove('hidden');
                        modalEliminar.classList.add('flex');
                    }
                };

                document.addEventListener('click', window._rolesClickListener);
            }

            initRoles();
            document.addEventListener('turbo:load', initRoles);
        })();