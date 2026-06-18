document.addEventListener('DOMContentLoaded', function() {
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
            <div class="w-12 h-12 border-4 border-gray-200 border-t-red-600 rounded-full animate-spin mb-3"></div>
            <p class="text-sm font-semibold text-gray-700 dark:text-neutral-300">Procesando imagen...</p>
        `;
        uploadContainer.appendChild(loaderDiv);
    }

    // Manejar cambio de archivo
    if(fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const loaderDiv = document.getElementById('upload-loader-div');
                
                if(uploadLabel) uploadLabel.style.display = 'none';
                if(loaderDiv) {
                    loaderDiv.style.display = 'flex';
                    loaderDiv.style.opacity = '1';
                }

                const reader = new FileReader();
                reader.onload = function(e) {
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
                    }, 800);
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
});
