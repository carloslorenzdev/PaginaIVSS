import 'preline';
import './bootstrap';
import { ToastAlert } from './toastify';

(function() {
    function initModule() {
        // Limpiar backdrops huérfanos que pudieran quedar de navegaciones anteriores
        document.querySelectorAll('[data-hs-overlay-backdrop-template], .modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('overflow-hidden', 'modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';

        if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
            window.HSStaticMethods.autoInit();
        }
        const elementoToast = document.querySelector('#hs-new-toast');
        if (elementoToast) {
            elementoToast.remove();
            ToastAlert(elementoToast.innerHTML);
        }

        const sidebarElement = document.querySelector('#hs-application-sidebar');
        const cintillo = document.querySelector('section#cintillo');
        if (sidebarElement && cintillo) {
            const opcionesIntersection = {
                root: null,
                rootMargin: '0px',
                threshold: 1.0,
            };
            const callbackIntersection = (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        sidebarElement.classList.add('top-[50px]');
                        sidebarElement.classList.remove('top-0');
                    } else {
                        sidebarElement.classList.add('top-0');
                        sidebarElement.classList.remove('top-[50px]');
                    }
                });
            };
            const observerCintillo = new IntersectionObserver(callbackIntersection, opcionesIntersection);
            observerCintillo.observe(cintillo);
        }
    }

    if (document.readyState !== 'loading') {
        initModule();
    } else {
        document.addEventListener('DOMContentLoaded', initModule);
    }
    document.addEventListener('livewire:navigated', initModule);
})();
