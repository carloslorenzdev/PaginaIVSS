document.addEventListener('DOMContentLoaded', function() {
    const iframe = document.getElementById('livePreviewFrame');
    const loader = document.getElementById('iframeLoader');
    let currentPreviewType = '';

    const closePreviewBtn = document.getElementById('closePreviewModal');
    if (closePreviewBtn) {
        closePreviewBtn.addEventListener('click', function() {
            iframe.src = "about:blank"; // Stop loading
        });
    }

    const fileInput = document.getElementById('membrete_img');
    if (fileInput) {
        fileInput.addEventListener('change', previewMembrete);
    }

    function previewMembrete() {
        const fileInput = document.getElementById('membrete_img');
        const previewContainer = document.getElementById('membretePreviewContainer');
        const previewImg = document.getElementById('membretePreviewImg');

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    if (img.width < 800 || img.height < 100) {
                        alert(`Advertencia: La resolución de la imagen es baja (${img.width}x${img.height}). Se recomienda mínimo 800x100.`);
                    }
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            previewContainer.classList.add('hidden');
            previewImg.src = "";
        }
    }

    if (iframe) {
        iframe.addEventListener('load', handleIframeLoad);
    }

    function handleIframeLoad() {
        if(iframe.src === "about:blank" || iframe.src === "") return;
        
        loader.style.display = 'none';
        iframe.style.opacity = '1';
        
        if (currentPreviewType === 'membrete') {
            const fileInput = document.getElementById('membrete_img');
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    try {
                        const doc = iframe.contentDocument || iframe.contentWindow.document;
                        const membreteImg = doc.querySelector('.membrete-strip img');
                        if (membreteImg) {
                            membreteImg.src = e.target.result;
                        }
                    } catch(err) {
                        console.error("CORS o error accediendo al iframe", err);
                    }
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    }

    const previewRealBtn = document.getElementById('btnPreviewMembreteReal');
    if (previewRealBtn) {
        previewRealBtn.addEventListener('click', function() {
            const fileInput = document.getElementById('membrete_img');
            if (!fileInput.files || !fileInput.files[0]) {
                alert('Por favor selecciona una imagen primero para ver la vista previa real.');
                return;
            }
            
            currentPreviewType = 'membrete';
            const baseUrl = this.getAttribute('data-inicio-url');
            
            loader.style.display = 'flex';
            iframe.style.opacity = '0';
            iframe.src = baseUrl;
            document.getElementById('hiddenPreviewBtn').click();
        });
    }
});
