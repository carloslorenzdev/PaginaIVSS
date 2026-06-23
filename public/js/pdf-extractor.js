import * as pdfjsLib from '/js/pdf.mjs';
pdfjsLib.GlobalWorkerOptions.workerSrc = '/js/pdf.worker.mjs';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-boletin') || document.getElementById('form-revista');
    const pdfInput = document.getElementById('archivo_pdf');
    const hiddenImage = document.getElementById('imagen_base64');
    const btnGuardar = document.getElementById('btn_guardar');
    const btnText = document.getElementById('btn_text');

    if (!form || !pdfInput || !hiddenImage || !btnGuardar || !btnText) return;

    form.addEventListener('submit', async function(e) {
        const file = pdfInput.files[0];
        // If no file or not PDF, let it submit normally
        if (!file || file.type !== 'application/pdf') return; 
        
        // If image already extracted, let it submit
        if (hiddenImage.value !== '') return;

        e.preventDefault();
        
        // Disable button and show processing state
        btnGuardar.disabled = true;
        btnGuardar.classList.add('opacity-50', 'cursor-not-allowed');
        const originalText = btnText.innerHTML;
        btnText.innerHTML = "Procesando Portada...";

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({data: arrayBuffer}).promise;
            const page = await pdf.getPage(1);
            
            const viewport = page.getViewport({scale: 1.5});
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            await page.render({canvasContext: context, viewport: viewport}).promise;
            
            hiddenImage.value = canvas.toDataURL('image/jpeg', 0.8);
        } catch (error) {
            console.error("Error extrayendo imagen del PDF:", error);
            // Fallback: it will submit with empty hiddenImage
        }

        btnText.innerHTML = "Guardando...";
        form.submit();
    });
});
