import { generaEtiquetaOption } from "./helpers";

window.addEventListener('DOMContentLoaded', function () {
    const selectParroquia = document.querySelector('select.estado[name=parroquia]');
    // REDERIZA OFICINAS
    function renderizaOficinas(idParroquia) {
        const selectOficina = document.querySelector('select.oficina');
        if (!selectOficina || oficinas.length < 1) {
            return false;
        }
        const oficinasParroquia = oficinas.filter(o => Number(o.id_parroquia) == Number(idParroquia))
        let html = '';
        if (oficinasParroquia.length) {
            oficinasParroquia.forEach(o => {
                html += generaEtiquetaOption(
                    `(${o.oficina.abreviatura}) - ${o.oficina.nombre_oficina}`,
                    o.id_oficina
                );
            });
        }
        selectOficina.innerHTML = html;
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
});
