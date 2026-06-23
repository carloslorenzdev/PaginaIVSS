import * as pdfjsLib from '/js/pdf.mjs';
import { PageFlip } from '/js/vendor/page-flip.module.js';

const flipbookWrapper = document.getElementById("flipbook-container");
if (flipbookWrapper) {
    const pdfUrlRaw = flipbookWrapper.dataset.pdfUrl;
    const workerUrl = flipbookWrapper.dataset.workerUrl;

    const flipbookContainer = document.getElementById("flipbook");
    const loader = document.getElementById("flipbook-loader");
    const progressText = document.getElementById("flipbook-progress");
    const pageCurrent = document.getElementById("page-current");
    const pageTotal = document.getElementById("page-total");
    
    let pageFlip;
    let baseScale = 1;
    let zoomLevel = 1;

    const initRevista = async () => {
        try {
            pdfjsLib.GlobalWorkerOptions.workerSrc = workerUrl;

            progressText.innerText = "Descargando documento...";
            
            const urlToFetch = String(pdfUrlRaw);
            if (!urlToFetch || urlToFetch === 'undefined') {
                throw new Error("La URL del PDF est\u00e1 vac\u00eda o es inv\u00e1lida.");
            }

            const pdf = await pdfjsLib.getDocument({ url: urlToFetch }).promise;
            const totalPages = pdf.numPages;
            
            pageTotal.innerText = totalPages;
            progressText.innerText = `Procesando 0 de ${totalPages} p\u00e1ginas...`;

            // Obtener el tamao real de la primera pgina para calcular el aspect ratio exacto
            const firstPage = await pdf.getPage(1);
            // Usamos scale 1.5 para buena resolucin de lectura
            const viewport1 = firstPage.getViewport({ scale: 1.5 });
            const PAGE_WIDTH = viewport1.width;
            const PAGE_HEIGHT = viewport1.height;

            const pagesData = [];

            // Renderizar pginas secuencialmente para no saturar memoria
            for (let i = 1; i <= totalPages; i++) {
                const page = await pdf.getPage(i);
                // Usar exactamente el mismo ancho/alto para todas (asumiendo que todas son iguales)
                const viewport = page.getViewport({ scale: 1.5 });
                
                const canvas = document.createElement("canvas");
                const context = canvas.getContext("2d");
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                await page.render(renderContext).promise;
                progressText.innerText = `Procesando ${i} de ${totalPages} p\u00e1ginas...`;
                
                pagesData.push({ index: i, canvas: canvas });
            }
            
            pagesData.sort((a, b) => a.index - b.index);

            pagesData.forEach(data => {
                const pageDiv = document.createElement("div");
                pageDiv.classList.add("page");
                pageDiv.appendChild(data.canvas);
                flipbookContainer.appendChild(pageDiv);
            });

            // Ocultar Loader correctamente
            loader.classList.remove("d-flex");
            loader.classList.add("d-none");
            loader.style.display = "none";
            
            flipbookContainer.style.display = "block";

            // Determinar si estamos en un dispositivo móvil por el ancho de pantalla
            const isMobile = window.innerWidth < 768;

            // Inicializar PageFlip con tamaño "stretch" y min/max idénticos para emular "fixed" 
            // pero permitiendo que la librería active el modo Retrato (1 página) en móviles
            pageFlip = new PageFlip(flipbookContainer, {
                width: PAGE_WIDTH,
                height: PAGE_HEIGHT,
                size: "stretch",
                minWidth: PAGE_WIDTH,
                maxWidth: PAGE_WIDTH,
                minHeight: PAGE_HEIGHT,
                maxHeight: PAGE_HEIGHT,
                drawShadow: true,
                showCover: true,
                usePortrait: isMobile, // En escritorio forzamos 2 páginas, en móvil 1
                mobileScrollSupport: true
            });

            pageFlip.loadFromHTML(document.querySelectorAll('.page'));

            // FUNCIN PARA AUTO-ESCALAR (Zoom y Ajuste de Pantalla)
            const updateScale = () => {
                // Obtener el tamao disponible del contenedor padre
                const containerWidth = flipbookWrapper.clientWidth;
                const containerHeight = flipbookWrapper.clientHeight;
                
                // Si el libro est en landscape (2 pginas), su ancho es el doble
                const isLandscape = pageFlip.getOrientation() === 'landscape';
                const bookWidth = isLandscape ? PAGE_WIDTH * 2 : PAGE_WIDTH;
                const bookHeight = PAGE_HEIGHT;
                
                // Calcular la escala para que encaje al 90% del tamao del contenedor
                const scaleX = (containerWidth * 0.9) / bookWidth;
                const scaleY = (containerHeight * 0.9) / bookHeight;
                
                // Elegir la menor escala para que no se desborde ni a lo ancho ni a lo alto
                baseScale = Math.min(scaleX, scaleY);
                
                // Aplicar la transformacin CSS final
                flipbookContainer.style.transform = `scale(${baseScale * zoomLevel})`;
            };

            // Escuchar eventos para recalcular la escala
            window.addEventListener('resize', updateScale);
            pageFlip.on('changeOrientation', updateScale);
            
            // Llamar una vez para ajuste inicial
            setTimeout(updateScale, 100);

            // EVENTOS DE NAVEGACIN UI
            pageFlip.on("flip", (e) => {
                pageCurrent.innerText = e.data + 1;
            });

            document.getElementById("btn-prev").addEventListener("click", () => {
                pageFlip.flipPrev();
            });

            document.getElementById("btn-next").addEventListener("click", () => {
                pageFlip.flipNext();
            });

            // EVENTOS DE LA TOOLBAR DE ZOOM
            document.getElementById("btn-zoom-in").addEventListener("click", () => {
                zoomLevel += 0.2;
                updateScale();
            });
            
            document.getElementById("btn-zoom-out").addEventListener("click", () => {
                if (zoomLevel > 0.4) {
                    zoomLevel -= 0.2;
                    updateScale();
                }
            });

            document.getElementById("btn-zoom-reset").addEventListener("click", () => {
                zoomLevel = 1;
                // Si hacemos reset, intentamos volver al centro si hay scroll
                flipbookWrapper.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
                updateScale();
            });

            // EVENTO DE PANTALLA COMPLETA
            document.getElementById("btn-fullscreen").addEventListener("click", () => {
                if (!document.fullscreenElement) {
                    flipbookWrapper.requestFullscreen().catch(err => {
                        console.error("Error al intentar pantalla completa:", err);
                    });
                } else {
                    document.exitFullscreen();
                }
            });
            
            // Permitir hacer scroll cuando se hace zoom (Drag and Drop / Panning es ms complejo, 
            // pero le daremos "overflow: auto" al wrapper temporalmente si el zoom es mayor a 1)
            flipbookWrapper.style.overflow = "auto";

        } catch (error) {
            console.error("Error cargando el flipbook:", error);
            progressText.innerText = "Error cargando la revista: " + (error.message || error);
            progressText.classList.replace("text-white-50", "text-danger");
            const spinner = document.querySelector("#flipbook-loader .spinner-border");
            if (spinner) spinner.style.display = "none";
        }
    };

    initRevista();
}
