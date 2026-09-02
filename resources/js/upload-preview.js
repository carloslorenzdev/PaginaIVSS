import { ToastAlert } from './toastify.js';

(function() {
    function initModule() {
    const fileInput = document.getElementById('dropzone-file');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');
    const uploadLabel = document.getElementById('upload-label');
    const eliminarInput = document.getElementById('eliminar_imagen_input');
    const uploadContainer = document.getElementById('upload-container');

    // Crear el loader div si no existe
    if (uploadContainer && !document.getElementById('upload-loader-div')) {
        const loaderDiv = document.createElement('div');
        loaderDiv.id = 'upload-loader-div';
        loaderDiv.className = 'absolute inset-0 bg-white dark:bg-neutral-800 flex flex-col items-center justify-center z-30 transition-opacity';
        loaderDiv.style.display = 'none';
        loaderDiv.innerHTML = `
            <div class="w-20 h-20 mb-4 relative">
                <svg class="w-full h-full text-gray-100 dark:text-neutral-700 drop-shadow-sm" viewBox="0 0 36 36">
                    <path class="stroke-current" fill="none" stroke-width="4" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path id="progress-circle" class="stroke-current text-red-600 transition-all duration-200 ease-out" fill="none" stroke-width="4" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute top-0 left-0 w-full h-full flex flex-col items-center justify-center">
                    <span id="progress-text" class="text-sm font-extrabold text-gray-800 dark:text-neutral-200 tracking-tight">0%</span>
                </div>
            </div>
            <p class="text-sm font-bold text-gray-700 dark:text-neutral-300">Procesando imagen...</p>
        `;
        uploadContainer.appendChild(loaderDiv);
    }

    // Manejar cambio de archivo
    if(fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validación: Solo permitir PNG, JPG, Webp
                const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    ToastAlert(['danger', { mensaje: 'Formato Inválido', ayuda: 'Por favor, sube únicamente un archivo de imagen válido (PNG, JPG, WebP).' }]);
                    this.value = ''; // Limpiar el input
                    return;
                }

                const loaderDiv = document.getElementById('upload-loader-div');
                const progressCircle = document.getElementById('progress-circle');
                const progressText = document.getElementById('progress-text');
                
                if(uploadLabel) uploadLabel.style.display = 'none';
                if(loaderDiv) {
                    loaderDiv.style.display = 'flex';
                    loaderDiv.style.opacity = '1';
                    progressCircle.setAttribute('stroke-dasharray', '0, 100');
                    progressText.textContent = '0%';
                }

                // Animación de progreso artificial para UX
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += Math.floor(Math.random() * 15) + 8; // Incrementos rápidos
                    if (progress > 95) progress = 95; // Pausar al 95% hasta que cargue en memoria
                    
                    if(progressCircle) progressCircle.setAttribute('stroke-dasharray', `${progress}, 100`);
                    if(progressText) progressText.textContent = `${progress}%`;
                }, 100);

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Completar hasta 100% después de leer el archivo
                    setTimeout(() => {
                        clearInterval(progressInterval);
                        if(progressCircle) progressCircle.setAttribute('stroke-dasharray', '100, 100');
                        if(progressText) progressText.textContent = '100%';
                        
                        // Ocultar loader y mostrar preview
                        setTimeout(() => {
                            if(imagePreview) imagePreview.src = e.target.result;
                            if(loaderDiv) loaderDiv.style.opacity = '0';
                            setTimeout(() => {
                                if(loaderDiv) loaderDiv.style.display = 'none';
                                if(previewContainer) {
                                    previewContainer.style.display = 'block';
                                    previewContainer.classList.remove('hidden');
                                }
                            }, 300);
                        }, 400); // Pausa breve en 100% para que el usuario lo vea
                    }, 500); // Duración mínima de la carga para apreciar la animación
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Manejar eliminación
    const removeBtn = document.getElementById('remove-image-btn');
    if(removeBtn) {
        removeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if(fileInput) fileInput.value = '';
            if(imagePreview) imagePreview.src = '#';
            if(previewContainer) {
                previewContainer.style.display = 'none';
                previewContainer.classList.add('hidden');
            }
            if(uploadLabel) uploadLabel.style.display = 'flex';
            if(eliminarInput) eliminarInput.value = '1';
        });
    }

    // Trigger click en imagen para abrir file chooser
    if(imagePreview) {
        imagePreview.addEventListener('click', function() {
            if(fileInput) fileInput.click();
        });
    }
    }

    if (document.readyState !== 'loading') {
        initModule();
    } else {
        document.addEventListener('DOMContentLoaded', initModule);
    }
    document.addEventListener('turbo:load', initModule);
})();

