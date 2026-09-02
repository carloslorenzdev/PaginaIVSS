import { generaEtiquetaOption } from "./helpers";

(function() {
    function initModule() {
    const selectParroquia = document.querySelector('select.estado[name=parroquia]');
    // REDERIZA OFICINAS
    function renderizaOficinas(idParroquia) {
        const selectOficina = document.querySelector('select.oficina');
        if (!selectOficina || oficinas.length < 1) {
            return false;
        }
        const oficinasParroquia = oficinas.filter(o => Number(o.id_parroquia) == Number(idParroquia))
        selectOficina.replaceChildren();
        if (oficinasParroquia.length) {
            oficinasParroquia.forEach(o => {
                selectOficina.appendChild(new Option(`(${o.oficina.abreviatura}) - ${o.oficina.nombre_oficina}`, o.id_oficina));
            });
        }
        selectOficina.disabled = false;
    }

    if (selectParroquia) {
        selectParroquia.addEventListener('change', (e) => {
            renderizaOficinas(e.target.value);
        });
        if (selectParroquia.dataset.id) {
            renderizaOficinas(selectParroquia.dataset.id);
        }
    }
    }

    if (document.readyState !== 'loading') {
        initModule();
    } else {
        document.addEventListener('DOMContentLoaded', initModule);
    }
    document.addEventListener('turbo:load', initModule);
})();

