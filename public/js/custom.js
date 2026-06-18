async function submitConsultaPensionado(e) {
    e.preventDefault();
    const form = document.getElementById('formConsultaPensionado');
    const formData = new FormData(form);
    const btn = document.getElementById('btnConsultarPensionado');
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Consultando...';
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

        const data = await response.json();
        
        // Close modal
        HSOverlay.close(document.getElementById('modalConsultaPensionado'));

        if (data.success) {
            Swal.fire({
                title: 'www.ivss.gob.ve:28080 dice',
                text: data.message,
                icon: data.message.includes('no tiene') ? 'warning' : 'info',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3f6087'
            });
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
            text: 'Ocurrió un error inesperado al realizar la consulta.',
            icon: 'error',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#d33'
        });
    } finally {
        btn.innerHTML = 'Consultar';
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

    // Abrimos la ventana emergente ANTES del await para evitar que el navegador la bloquee
    const newWindow = window.open('', '_blank');
    if (!newWindow) {
        btn.innerHTML = originalBtnHtml;
        btn.disabled = false;
        Swal.fire({
            title: 'Popups Bloqueados',
            text: 'Por favor, habilite las ventanas emergentes (pop-ups) en su navegador para poder ver la planilla.',
            icon: 'warning',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    newWindow.document.write(`
        <html><head><title>Cargando...</title>
        <style>
            body { display:flex; justify-content:center; align-items:center; height:100vh; margin:0; background:#f4f6f9; }
            .spinner { width: 50px; height: 50px; border: 5px solid #e0e0e0; border-top-color: #003366; border-radius: 50%; animation: spin 1s linear infinite; }
            @keyframes spin { to { transform: rotate(360deg); } }
        </style>
        </head>
        <body>
            <div class="spinner"></div>
        </body></html>
    `);

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

        if (data.success) {
            // Cerramos el modal de búsqueda
            HSOverlay.close(document.getElementById('modalCuentaIndividual'));
            
            // Escribimos el HTML crudo en la ventana que ya abrimos
            newWindow.document.open();
            newWindow.document.write(data.html);
            newWindow.document.close();
            
        } else {
            newWindow.close(); // Cerramos la ventana si hubo error
            Swal.fire({
                title: 'Error en IVSS',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#d33'
            });
        }
    } catch (error) {
        if(newWindow) newWindow.close(); // Cerramos la ventana si crasheó

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

document.addEventListener('DOMContentLoaded', () => {
    const formPensionado = document.getElementById('formConsultaPensionado');
    if(formPensionado) formPensionado.addEventListener('submit', submitConsultaPensionado);

    const formCuenta = document.getElementById('formCuentaIndividual');
    if(formCuenta) formCuenta.addEventListener('submit', submitCuentaIndividual);
});
