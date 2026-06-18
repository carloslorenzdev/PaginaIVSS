import 'preline';
import './bootstrap';
import { ToastAlert } from './toastify';

window.addEventListener('DOMContentLoaded', function () {
    const elementoToast = document.querySelector('#hs-new-toast');
    if (elementoToast) {
        elementoToast.remove();
        ToastAlert(elementoToast.innerHTML);
    }

    const sidebarElement = document.querySelector('#hs-application-sidebar');
    if (sidebarElement) {
        let cintillo = document.querySelector('section#cintillo');
        const opcionesIntersection = {
            root: document,
            rootMargin: '0px',
            threshold: 1.0, // PRESENCIA COMPLETA
        };
        const callbackIntersection = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // PRESENTE EN LA PANTALLA
                    sidebarElement.classList.add('top-[50px]');
                    sidebarElement.classList.remove('top-0');
                } else {
                    // NO PRESENTE
                    sidebarElement.classList.add('top-0');
                    sidebarElement.classList.remove('top-[50px]');
                }
            });
        };
        const observerCintillo = new IntersectionObserver(callbackIntersection, opcionesIntersection);
        observerCintillo.observe(cintillo);
    }
});
