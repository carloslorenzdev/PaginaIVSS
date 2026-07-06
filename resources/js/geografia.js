import { generaEtiquetaOption } from "./helpers";

function listaMunicipios(idEstado = null) {
    const result = estados.filter(e => e.id_estado == idEstado);
    return result.length ? result[0].municipios : [];
}

function listaParroquias(idMunicipio = null, municipios) {
    const result = municipios.filter(e => e.id_municipio == idMunicipio);
    return result.length ? result[0].parroquias : [];
}

function renderizaSelectParroquias(sufijo, idMunicipio = null, idEstado = null) {
    const selectParroquia = document.querySelector(`select.estado[name="parroquia${sufijo}"]`);
    selectParroquia.disabled = true;

    if (!idEstado) {
        idEstado = document.querySelector(`select.estado[name="estado${sufijo}"]`).value;
    }

    if (!idMunicipio) {
        idMunicipio = document.querySelector(`select.estado[name="municipio${sufijo}"]`).value;
    }

    const municipios = listaMunicipios(idEstado);
    const parroquias = listaParroquias(idMunicipio, municipios);
    let html = generaEtiquetaOption('Seleccione Parroquia');

    if (parroquias.length) {
        parroquias.forEach(p => {
            html += generaEtiquetaOption(p.desc_parroquia, p.id_parroquia)
        });
    }

    selectParroquia.innerHTML = html;
    selectParroquia.disabled = false;
}

function renderizaSelectMunicipios(sufijo = null, idEstado = null) {
    const selectMunicipio = document.querySelector(`select.estado[name="municipio${sufijo}"]`);
    selectMunicipio.disabled = true;

    if (!idEstado) {
        idEstado = document.querySelector(`select.estado[name="estado${sufijo}"]`).value;
    }

    const municipios = listaMunicipios(idEstado);
    let html = generaEtiquetaOption('Seleccione Municipio');

    if (municipios.length) {
        municipios.map(m => {
            html += generaEtiquetaOption(m.nombre_municipio, m.id_municipio)
        });
    }
    console.log('renderizaMunicipos')
    selectMunicipio.innerHTML = html;
    selectMunicipio.disabled = false;
}

function renderizaTodoGrupoSelect(elementoParroquia) {
    let mun, est, par, sufix = '';

    if (elementoParroquia.dataset.grupo) {
        sufix = '_' + elementoParroquia.dataset.grupo;
    }

    estados.map((estado) => {
        estado.municipios.map((municipio) => {
            par = municipio.parroquias.filter((parroquia) => parroquia.id_parroquia == elementoParroquia.dataset.id);
            if (par.length) {
                mun = municipio;
                est = estado;
            }
        });
    });

    document.querySelector(`select.estado[name="estado${sufix}"]`).value = est.id_estado;
    renderizaSelectMunicipios(sufix, est.id_estado);
    document.querySelector(`select.estado[name="municipio${sufix}"]`).value = mun.id_municipio;
    renderizaSelectParroquias(sufix, mun.id_municipio, est.id_estado);
    elementoParroquia.value = elementoParroquia.dataset.id;
}

window.addEventListener('turbo:load', function () {
    const selecsEstadoMunParr = document.querySelectorAll('select.estado');
    if (selecsEstadoMunParr.length) {
        selecsEstadoMunParr.forEach((el) => {
            let sufijo = '';
            if (el.dataset.grupo) {
                sufijo = '_' + el.dataset.grupo;
            }
            // SI ES ESTADO O MUNICIPIO AGREGA EVENTO CHANGE
            if ((el.name).startsWith('estado')) {
                el.addEventListener('change', (e) => {
                    renderizaSelectMunicipios(sufijo, e.target.value)
                    renderizaSelectParroquias(sufijo, e.target.value)
                    const selectParroquia = document.querySelector(`select.estado[name="parroquia${sufijo}"]`);
                    selectParroquia.disabled = true;
                });
                if (el.value) {
                    renderizaSelectMunicipios(sufijo, el.value)
                }
            }
            if ((el.name).startsWith('municipio')) {
                el.addEventListener('change', (e) => {
                    renderizaSelectParroquias(sufijo, e.target.value)
                });
            }
            // SI PARROQUIA TIENE OLD REALIZA CAMBIOS
            if ((el.name).startsWith('parroquia') && el.dataset.id) {
                renderizaTodoGrupoSelect(el);
            }
        })
    }
});
