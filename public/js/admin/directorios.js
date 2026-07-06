document.addEventListener('turbo:load', function() {
    const btnNuevo = document.getElementById('btn-nuevo-registro');
    if (btnNuevo) {
        btnNuevo.addEventListener('click', function() {
            const modal = document.getElementById('modal-create');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            document.getElementById('form-directorio').reset();
            document.getElementById('form-method').value = 'POST';
            document.getElementById('form-directorio').action = this.getAttribute('data-store-url');
            document.getElementById('modal-title').innerText = 'Nuevo Registro';
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

            document.getElementById('modal-title').innerText = 'Editar Registro';
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('form-directorio').action = this.getAttribute('data-update-url');
            
            document.getElementById('input-estado').value = this.getAttribute('data-estado');
            document.getElementById('input-nombre').value = this.getAttribute('data-nombre');
            document.getElementById('input-direccion').value = this.getAttribute('data-direccion');
            document.getElementById('input-telefono').value = this.getAttribute('data-telefono');
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
