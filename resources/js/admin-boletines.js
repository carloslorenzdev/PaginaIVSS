document.addEventListener('turbo:load', function() {
    const btnNuevo = document.getElementById('btn-nuevo-boletin');
    if (btnNuevo) {
        btnNuevo.addEventListener('click', function() {
            const modal = document.getElementById('modal-create');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            document.getElementById('form-boletin').reset();
            document.getElementById('form-method').value = 'POST';
            document.getElementById('form-boletin').action = this.getAttribute('data-url');
            document.getElementById('modal-title').innerText = 'Subir Boletín';
            document.getElementById('archivo_pdf').required = true;
            document.getElementById('pdf-required-mark').style.display = 'inline';
            document.getElementById('pdf-help-text').innerText = 'Solo formato PDF. Tamaño máximo 20MB.';
            document.getElementById('input-fecha').value = new Date().toISOString().split('T')[0];
        });
    }

    const closeBtns = [document.getElementById('btn-close-modal'), document.getElementById('btn-cancelar')];
    closeBtns.forEach(function(btn) {
        if (btn) {
            btn.addEventListener('click', function() {
                const modal = document.getElementById('modal-create');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
    });

    const editBtns = document.querySelectorAll('.btn-edit');
    editBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const modal = document.getElementById('modal-create');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('modal-title').innerText = 'Editar Boletín';
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('form-boletin').action = this.getAttribute('data-url');
            
            document.getElementById('input-titulo').value = this.getAttribute('data-titulo');
            document.getElementById('input-fecha').value = this.getAttribute('data-fecha');
            
            // En edición, el PDF es opcional
            document.getElementById('archivo_pdf').required = false;
            document.getElementById('pdf-required-mark').style.display = 'none';
            document.getElementById('pdf-help-text').innerText = 'Deja vacío para mantener el PDF actual. Solo formato PDF. Tamaño máximo 20MB.';
        });
    });

    // Lógica para el modal de eliminar
    const deleteBtns = document.querySelectorAll('.btn-delete');
    deleteBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const modal = document.getElementById('modal-eliminar');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            document.getElementById('form-eliminar').action = this.getAttribute('data-url');
            document.getElementById('modal-eliminar-nombre').innerText = '"' + this.getAttribute('data-nombre') + '"';
        });
    });

    const closeDeleteBtns = [document.getElementById('btn-cerrar-eliminar')];
    closeDeleteBtns.forEach(function(btn) {
        if (btn) {
            btn.addEventListener('click', function() {
                const modal = document.getElementById('modal-eliminar');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
    });
});
