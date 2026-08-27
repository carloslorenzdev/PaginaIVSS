(function() {
            function initPreguntas() {
                const modalEliminar = document.getElementById('modal-eliminar');
                const btnCerrarEliminar = document.getElementById('btn-cerrar-eliminar');
                const btnConfirmarEliminar = document.getElementById('btn-confirmar-eliminar');
                let formIdToDelete = null;

                if (!modalEliminar) return;

                function closeEliminarModal() {
                    modalEliminar.classList.add('hidden');
                    modalEliminar.classList.remove('flex');
                    formIdToDelete = null;
                }

                // Clear previous listeners
                const newBtnCerrar = btnCerrarEliminar.cloneNode(true);
                btnCerrarEliminar.parentNode.replaceChild(newBtnCerrar, btnCerrarEliminar);
                newBtnCerrar.addEventListener('click', closeEliminarModal);

                const newBtnConfirmar = btnConfirmarEliminar.cloneNode(true);
                btnConfirmarEliminar.parentNode.replaceChild(newBtnConfirmar, btnConfirmarEliminar);
                newBtnConfirmar.addEventListener('click', () => {
                    if (formIdToDelete) {
                        document.getElementById(formIdToDelete).submit();
                    }
                });

                modalEliminar.addEventListener('click', (e) => {
                    if (e.target === modalEliminar) closeEliminarModal();
                });

                // Attach to delete buttons globally
                if (window._preguntasDeleteListener) {
                    document.removeEventListener('click', window._preguntasDeleteListener);
                }

                window._preguntasDeleteListener = function(e) {
                    const btnDelete = e.target.closest('.btn-delete-pregunta');
                    if (btnDelete) {
                        formIdToDelete = btnDelete.dataset.formId;
                        modalEliminar.classList.remove('hidden');
                        modalEliminar.classList.add('flex');
                    }
                };

                document.addEventListener('click', window._preguntasDeleteListener);
            }

            initPreguntas();
            document.addEventListener('turbo:load', initPreguntas);
        })();