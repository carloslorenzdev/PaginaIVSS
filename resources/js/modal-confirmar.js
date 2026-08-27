document.addEventListener('click', function(e) {
    const btnAbrir = e.target.closest('.btn-confirmar-accion');
    if (btnAbrir) {
        e.preventDefault();
        const modalConfirmar = document.getElementById('modal-confirmar');
        if (!modalConfirmar) return;

        const action = btnAbrir.dataset.action;
        const mensaje = btnAbrir.dataset.mensaje;
        const method = btnAbrir.dataset.method || 'POST';
        
        document.getElementById('form-confirmar').action = action;
        document.getElementById('modal-confirmar-mensaje').textContent = mensaje;
        document.getElementById('modal-confirmar-method').value = method;
        
        modalConfirmar.classList.remove('hidden');
        modalConfirmar.classList.add('flex');
        return;
    }

    const btnCerrar = e.target.closest('#btn-cerrar-confirmar');
    const backdrop = e.target.closest('#modal-confirmar-backdrop');
    
    if (btnCerrar || backdrop) {
        const modalConfirmar = document.getElementById('modal-confirmar');
        if (modalConfirmar) {
            modalConfirmar.classList.add('hidden');
            modalConfirmar.classList.remove('flex');
        }
    }
});
