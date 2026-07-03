document.addEventListener('turbo:load', function() {
    // Alerta inicial (promocional)
    const modalPromocionalEl = document.getElementById('modalPromocional');
    if (modalPromocionalEl && modalPromocionalEl.getAttribute('data-mostrar-alerta') === 'true') {
        const modalPromocional = new bootstrap.Modal(modalPromocionalEl);
        
        modalPromocional.show();
    }

    // Lógica para el modal dinámico del carrusel
    const modalPromoDinamicoEl = document.getElementById('modalPromoDinamico');
    if (modalPromoDinamicoEl) {
        // Asegurarnos de limpiar eventos previos para evitar duplicaciones con Turbo
        const nuevoModalPromo = modalPromoDinamicoEl.cloneNode(true);
        modalPromoDinamicoEl.parentNode.replaceChild(nuevoModalPromo, modalPromoDinamicoEl);

        nuevoModalPromo.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ruta = button.getAttribute('data-ruta');
            const enlace = button.getAttribute('data-enlace');

            const imgConEnlace = document.getElementById('modalPromoDinamicoImgConEnlace');
            const imgSinEnlace = document.getElementById('modalPromoDinamicoImgSinEnlace');
            const linkTag = document.getElementById('modalPromoDinamicoLink');

            if (enlace && enlace.trim() !== '') {
                imgConEnlace.src = ruta;
                linkTag.href = enlace;
                linkTag.style.display = 'block';
                imgSinEnlace.style.display = 'none';
            } else {
                imgSinEnlace.src = ruta;
                imgSinEnlace.style.display = 'block';
                linkTag.style.display = 'none';
            }
        });
    }
});
