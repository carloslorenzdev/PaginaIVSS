import { generaEtiquetaOption } from "./helpers";

function renderizaActividadEconomica(valorTipoEmpresa, valorActividad = null) {
    const actividadesEmpresa = actividadesEconomicas.filter(ac => {
        return ac.id_tipo_empresa == valorTipoEmpresa;
    })

    const selectActividad = document.querySelector('select[name="actividad_economica"]');

    selectActividad.disabled = true;
    let html = generaEtiquetaOption('Seleccione Actividad Económica');

    if (actividadesEmpresa.length) {
        actividadesEmpresa.forEach(ac => {
            html += generaEtiquetaOption(ac.desc_actividad, ac.id_actividad)
        });
    }

    selectActividad.innerHTML = html;
    selectActividad.value = valorActividad;
    selectActividad.disabled = false;
}

window.addEventListener('DOMContentLoaded', function () {
    const selectTipoEmpresa = document.querySelector('select[name="tipo_empresa"]');
    if (selectTipoEmpresa) {
        const selectActividad = document.querySelector('select[name="actividad_economica"]');
        if (selectActividad.dataset.id) {
            renderizaActividadEconomica(selectTipoEmpresa.value, selectActividad.dataset.id);
        }

        selectTipoEmpresa.addEventListener('change', function (e) {
            renderizaActividadEconomica(e.target.value);
        });
    }
});
