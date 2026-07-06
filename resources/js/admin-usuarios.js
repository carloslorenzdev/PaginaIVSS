document.addEventListener('turbo:load', function() {
    // Manejo del modal de creación
    const btnNuevo = document.getElementById('btn-nuevo-usuario');
    if (btnNuevo) {
        btnNuevo.addEventListener('click', function() {
            const modal = document.getElementById('modal-usuario');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            document.getElementById('form-usuario').reset();
            document.getElementById('form-usuario-method').value = 'POST';
            document.getElementById('form-usuario').action = "/usuarios/registrar";
            document.getElementById('modal-usuario-title').innerText = 'Nuevo Registro';
            document.getElementById('input-usuario').readOnly = false;
            
            document.getElementById('password-container').classList.remove('hidden');
            document.getElementById('input-password').required = true;
            document.getElementById('input-password-confirmation').required = true;
        });
    }

    // Manejo del modal de edición
    const editBtns = document.querySelectorAll('.btn-edit-user');
    editBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const modal = document.getElementById('modal-usuario');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('modal-usuario-title').innerText = 'Editar Usuario';
            document.getElementById('form-usuario-method').value = 'PUT';
            
            const usuario = this.getAttribute('data-usuario');
            document.getElementById('form-usuario').action = "/usuarios/" + usuario + "/editar";
            
            document.getElementById('input-nombre').value = this.getAttribute('data-nombre');
            document.getElementById('input-usuario').value = usuario;
            document.getElementById('input-usuario').readOnly = true;
            document.getElementById('input-email').value = this.getAttribute('data-email');
            
            document.getElementById('password-container').classList.add('hidden');
            document.getElementById('input-password').required = false;
            document.getElementById('input-password-confirmation').required = false;
            
            const rol = this.getAttribute('data-rol');
            const radios = document.querySelectorAll('.input-rol');
            radios.forEach(radio => {
                if (radio.value === rol) radio.checked = true;
            });
            
            // Close the dropdown after clicking Edit
            const dropdownBtn = document.getElementById('hs-dropdown-' + usuario);
            if(dropdownBtn) {
                dropdownBtn.click();
            }
        });
    });

    // Cerrar modal
    const closeBtns = [document.getElementById('btn-close-modal-usuario'), document.getElementById('btn-cancelar-usuario')];
    closeBtns.forEach(function(btn) {
        if (btn) {
            btn.addEventListener('click', function() {
                const modal = document.getElementById('modal-usuario');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
    });
});
