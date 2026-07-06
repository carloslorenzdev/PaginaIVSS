document.addEventListener('turbo:load', function() {
    const optimizarBtns = document.querySelectorAll('.btn-optimizar');
    
    optimizarBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const url = this.getAttribute('data-url');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción limpiará los archivos temporales correspondientes.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, limpiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
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
                            Swal.fire(
                                '¡Optimizado!',
                                data.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                data.message || 'Ocurrió un error inesperado.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        document.body.style.cursor = 'default';
                        console.error('Error:', error);
                        Swal.fire(
                            'Error',
                            'Ocurrió un error al procesar la solicitud.',
                            'error'
                        );
                    });
                }
            });
        });
    });
});
