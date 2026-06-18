/**
 * Genera etiqueta option para select
 * @param {string} descripcion
 * @param {string|int|null} valor
 * @returns
 */
function generaEtiquetaOption(descripcion, valor = null) {
    return `<option value="${valor}">${descripcion}</option>`;
}

export {
    generaEtiquetaOption
};

