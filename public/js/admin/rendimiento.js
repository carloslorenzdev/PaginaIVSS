document.addEventListener('DOMContentLoaded', function() {
    const optimizarBtns = document.querySelectorAll('.btn-optimizar');
    
    optimizarBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const url = this.getAttribute('data-url');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!confirm('¿Estás seguro? Esta acción limpiará los archivos temporales correspondientes.')) {
                return;
            }

            // Cambiar el cursor a espera y deshabilitar temporalmente clics
            document.body.style.cursor = 'wait';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
            .then(data => {
                document.body.style.cursor = 'default';
                if (data.success) {
                    alert('¡Optimizado! ' + data.message);
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Ocurrió un error inesperado.'));
                }
            })
            .catch(error => {
                document.body.style.cursor = 'default';
                console.error('Error:', error);
                alert('Error: Ocurrió un error al procesar la solicitud.');
            });
        });
    });
});
