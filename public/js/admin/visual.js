(function() {
    function initModule() {
        const iframe = document.getElementById('livePreviewFrame');
        const loader = document.getElementById('iframeLoader');
        const modal = document.getElementById('previewModal');
        let currentPreviewType = '';

        function openModal() {
            if (!modal) return;
            if (window.HSOverlay && typeof window.HSOverlay.open === 'function') {
                try {
                    window.HSOverlay.open(modal);
                    return;
                } catch(e) {}
            }
            const hiddenBtn = document.getElementById('hiddenPreviewBtn');
            if (hiddenBtn) {
                hiddenBtn.click();
            } else {
                modal.classList.remove('hidden');
                modal.classList.add('open');
                modal.style.display = 'flex';
                modal.style.pointerEvents = 'auto';
            }
        }

        function closeModal() {
            if (!modal) return;
            if (window.HSOverlay && typeof window.HSOverlay.close === 'function') {
                try {
                    window.HSOverlay.close(modal);
                } catch(e) {}
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('open');
                modal.style.display = 'none';
                modal.style.pointerEvents = 'none';
            }
            if (iframe) {
                iframe.src = "about:blank";
                iframe.style.opacity = '0';
            }
        }

        const closePreviewBtn = document.getElementById('closePreviewModal');
        if (closePreviewBtn) {
            closePreviewBtn.addEventListener('click', closeModal);
        }

        // 1. VISTA PREVIA INSTANTÁNEA DEL MEMBRETE
        const fileInput = document.getElementById('membrete_img');
        if (fileInput) {
            fileInput.addEventListener('change', previewMembrete);
        }

        function previewMembrete() {
            const input = document.getElementById('membrete_img');
            const previewContainer = document.getElementById('membretePreviewContainer');
            const previewImg = document.getElementById('membretePreviewImg');
            const dimensionsSpan = document.getElementById('membreteDimensions');
            const warningEl = document.getElementById('membreteResolutionWarning');
            const warningText = document.getElementById('resDimensionsText');

            if (!input || !previewContainer || !previewImg) return;

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    previewContainer.style.display = 'block';

                    const tempImg = new Image();
                    tempImg.onload = function() {
                        const width = tempImg.naturalWidth || tempImg.width;
                        const height = tempImg.naturalHeight || tempImg.height;

                        if (dimensionsSpan) {
                            dimensionsSpan.textContent = `${width} × ${height} px`;
                        }

                        if (warningEl && warningText) {
                            if (width < 800 || height < 100) {
                                warningText.textContent = `${width}x${height} px`;
                                warningEl.classList.remove('hidden');
                                warningEl.style.display = 'flex';
                            } else {
                                warningEl.classList.add('hidden');
                                warningEl.style.display = 'none';
                            }
                        }
                    };
                    tempImg.src = e.target.result;
                };

                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
                previewContainer.style.display = 'none';
                previewImg.src = "";
            }
        }

        // 2. VISTA PREVIA REAL DENTRO DEL IFRAME
        if (iframe) {
            iframe.addEventListener('load', handleIframeLoad);
        }

        function handleIframeLoad() {
            if (!iframe || iframe.src === "about:blank" || iframe.src === "") return;

            if (loader) loader.style.display = 'none';
            iframe.style.opacity = '1';

            if (currentPreviewType === 'membrete') {
                const input = document.getElementById('membrete_img');
                if (input && input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        try {
                            const doc = iframe.contentDocument || iframe.contentWindow.document;
                            if (doc) {
                                const target = doc.querySelector('.membrete-strip img') 
                                    || doc.querySelector('header img')
                                    || doc.querySelector('.cintillo-img');
                                if (target) {
                                    target.src = e.target.result;
                                }
                            }
                        } catch(err) {
                            console.warn("Aviso: No se pudo inyectar imagen en el iframe (posible política de seguridad):", err);
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        }

        window.handleIframeLoad = handleIframeLoad;

        const previewRealBtn = document.getElementById('btnPreviewMembreteReal');
        if (previewRealBtn) {
            previewRealBtn.addEventListener('click', function() {
                const input = document.getElementById('membrete_img');
                if (!input || !input.files || !input.files[0]) {
                    alert('Por favor selecciona una imagen primero para ver la vista previa real.');
                    return;
                }

                currentPreviewType = 'membrete';
                const baseUrl = this.getAttribute('data-inicio-url') || '/';

                if (loader) loader.style.display = 'flex';
                iframe.style.opacity = '0';
                iframe.src = baseUrl;

                openModal();
            });
        }

        // 3. VISTA PREVIA INSTANTÁNEA PARA FONDOS DE SECCIÓN
        document.querySelectorAll('.input-bg-preview').forEach(function(bgInput) {
            bgInput.addEventListener('change', function() {
                const targetId = this.getAttribute('data-preview-target');
                const targetImg = document.getElementById(targetId);

                if (targetImg && this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        targetImg.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    }

    if (document.readyState !== 'loading') {
        initModule();
    } else {
        document.addEventListener('DOMContentLoaded', initModule);
    }
    document.addEventListener('livewire:navigated', initModule);
})();
