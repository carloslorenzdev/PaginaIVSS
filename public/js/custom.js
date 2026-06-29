async function submitConsultaPensionado(e) {
    e.preventDefault();
    const form = document.getElementById('formConsultaPensionado');
    const formData = new FormData(form);
    const btn = document.getElementById('btnConsultarPensionado');
    
    const originalBtnHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Consultando...';
    btn.disabled = true;

    try {
        const url = form.getAttribute('data-url');
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            },
            body: formData
        });

        if (!response.ok) {
            let errorMsg = `Error del servidor HTTP ${response.status}.`;
            try {
                const errData = await response.json();
                errorMsg = errData.message || errorMsg;
            } catch (e) {}
            throw new Error(errorMsg);
        }

        const data = await response.json();
        
        // Cierra el modal de busqueda
        HSOverlay.close(document.getElementById('modalConsultaPensionado'));

        if (data.success) {
            if (data.isHtml) {
                // Abrir ventana solo si hay HTML para mostrar
                const newWindow = window.open('', '_blank');
                if (!newWindow) {
                    Swal.fire({
                        title: 'Popups Bloqueados',
                        text: 'Por favor, habilite las ventanas emergentes (pop-ups) en su navegador para poder ver el estatus.',
                        icon: 'warning',
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }
                newWindow.document.open();
                newWindow.document.write(data.html);
                newWindow.document.close();
            } else {
                Swal.fire({
                    title: 'Resultado IVSS',
                    text: data.message,
                    icon: data.message && data.message.toLowerCase().includes('no tiene') ? 'warning' : 'info',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#3f6087'
                });
            }
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#d33'
            });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({
            title: 'Error',
            text: error.message || 'Ocurrió un error inesperado al realizar la consulta.',
            icon: 'error',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#d33'
        });
    } finally {
        btn.innerHTML = originalBtnHtml;
        btn.disabled = false;
    }
}

async function submitCuentaIndividual(e) {
    e.preventDefault();
    const form = document.getElementById('formCuentaIndividual');
    const formData = new FormData(form);
    const btn = document.getElementById('btnConsultarCuenta');
    
    // Cambiar estado del botón a cargando
    const originalBtnHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Consultando...';
    btn.disabled = true;

    try {
        const url = form.getAttribute('data-url');
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            },
            body: formData
        });

        if (!response.ok) {
            let errorMsg = `Error del servidor HTTP ${response.status}.`;
            try {
                const errData = await response.json();
                errorMsg = errData.message || errorMsg;
            } catch (e) {}
            throw new Error(errorMsg);
        }

        const data = await response.json();

        // Cerramos el modal de busqueda
        HSOverlay.close(document.getElementById('modalCuentaIndividual'));

        if (data.success) {
            // Escribimos el HTML crudo en una nueva ventana
            const newWindow = window.open('', '_blank');
            if (!newWindow) {
                Swal.fire({
                    title: 'Popups Bloqueados',
                    text: 'Por favor, habilite las ventanas emergentes (pop-ups) en su navegador para poder ver la planilla.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }
            newWindow.document.open();
            newWindow.document.write(data.html);
            newWindow.document.close();
        } else {
            Swal.fire({
                title: 'Resultado IVSS',
                text: data.message,
                icon: data.message && data.message.toLowerCase().includes('no se encuentra') ? 'warning' : 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#d33'
            });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({
            title: 'Error',
            text: error.message || 'Ocurrió un error inesperado al consultar la cuenta individual.',
            icon: 'error',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#d33'
        });
    } finally {
        // Restaurar estado del botón
        btn.innerHTML = originalBtnHtml;
        btn.disabled = false;
    }
}

async function submitOrdenPago(e) {
    e.preventDefault();
    const form = document.getElementById('formOrdenPago');
    const formData = new FormData(form);
    const btn = document.getElementById('btnOrdenPago');
    
    // Cambiar estado del botón a cargando
    const originalBtnHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Consultando...';
    btn.disabled = true;

    try {
        const url = form.getAttribute('action');
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json, application/pdf'
            }
        });

        const contentType = response.headers.get('content-type');

        if (response.ok && contentType && contentType.includes('application/pdf')) {
            // Es un PDF
            const blob = await response.blob();
            const pdfUrl = window.URL.createObjectURL(blob);
            
            const modalEl = document.getElementById('modalOrdenPago');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();
            }

            const newWindow = window.open(pdfUrl, '_blank');
            if (!newWindow) {
                Swal.fire('Atención', 'Por favor habilita las ventanas emergentes para descargar el PDF', 'warning');
            }
        } else {
            // Es un error
            let errorMessage = 'No se encontraron datos o hubo un error en la conexión.';
            try {
                const textResponse = await response.text();
                try {
                    const data = JSON.parse(textResponse);
                    errorMessage = data.message || errorMessage;
                } catch (e) {
                    // Si no es JSON, verificar el status HTTP
                    if (response.status === 419) {
                        errorMessage = 'Su sesión ha expirado, por favor recargue la página.';
                    } else if (response.status === 404) {
                        errorMessage = 'La ruta solicitada no existe. ¡Aún tiene la versión vieja de la página en caché! Por favor, recargue (Ctrl+F5).';
                    } else if (response.status >= 500) {
                        errorMessage = 'Error interno del servidor.';
                    }
                }
            } catch (e) {
                // Ignore
            }

            Swal.fire({
                title: 'Atención',
                text: errorMessage,
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#d33'
            });
        }

    } catch (error) {
        console.error("Error en submitOrdenPago:", error);
        Swal.fire({
            title: 'Error',
            text: error.message || 'Ocurrió un error inesperado al procesar la solicitud.',
            icon: 'error',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#d33'
        });
    } finally {
        btn.innerHTML = originalBtnHtml;
        btn.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const formPensionado = document.getElementById('formConsultaPensionado');
    if(formPensionado) formPensionado.addEventListener('submit', submitConsultaPensionado);

    const formCuenta = document.getElementById('formCuentaIndividual');
    if(formCuenta) formCuenta.addEventListener('submit', submitCuentaIndividual);

    const formOrden = document.getElementById('formOrdenPago');
    if(formOrden) formOrden.addEventListener('submit', submitOrdenPago);

    const formConstanciaTrabajo = document.getElementById('formConstanciaTrabajo');
    if(formConstanciaTrabajo) {
        formConstanciaTrabajo.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Servicio no disponible',
                text: 'El servicio de verificación de constancias de trabajo no se encuentra disponible en este momento.',
                icon: 'info',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3f6087'
            });
        });
    }
});
