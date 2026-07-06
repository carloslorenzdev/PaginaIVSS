document.addEventListener('turbo:load', function() {
    const btnNuevo = document.getElementById('btn-nueva-categoria');
    if (btnNuevo) {
        btnNuevo.addEventListener('click', function() {
            const modal = document.getElementById('modal-create');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            document.getElementById('form-categoria').reset();
            document.getElementById('form-method').value = 'POST';
            document.getElementById('form-categoria').action = this.getAttribute('data-url');
            document.getElementById('modal-title').innerText = 'Nueva Categoría';
            document.getElementById('input-activa').checked = true;
            document.getElementById('input-orden').value = '0';
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

            document.getElementById('modal-title').innerText = 'Editar Categoría';
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('form-categoria').action = this.getAttribute('data-url');
            
            document.getElementById('input-nombre').value = this.getAttribute('data-nombre');
            document.getElementById('input-descripcion').value = this.getAttribute('data-descripcion') || '';
            document.getElementById('input-orden').value = this.getAttribute('data-orden') || '0';
            document.getElementById('input-activa').checked = this.getAttribute('data-activa') == '1';
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
