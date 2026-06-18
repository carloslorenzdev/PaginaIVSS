import Toastify from 'toastify-js';

/**
 * Variavble para generar alerta
 */
let alerta = {
    color: 'blue',
    icono: 'bx-user',
    mensaje: null,
    ayuda: null,
    acciones: [],
    adicional: '',
}

/**
 * resetea variale de alerta
*/
function reseteaVariable() {
    alerta = {
        color: 'blue',
        icono: 'bx-user',
        mensaje: null,
        ayuda: null,
        acciones: [],
        adicional: '',
    }
}

function tostifyCustomClose(el) {
    const parent = el.closest('.toastify');
    const close = parent.querySelector('.toast-close');
    close.click();
}

/**
 * Setea color para el tipo de alerta
 * @param {string} tipo
 */
function setColor(tipo) {
    switch (tipo) {
        case 'success':
            alerta.color = 'teal';
            alerta.icono = 'bx-check';
            break;

        case 'info':
            alerta.color = 'blue';
            alerta.icono = 'bx-info-circle';
            break;

        case 'danger':
            alerta.color = 'red';
            alerta.icono = 'bx-error-circle';
            break;

        case 'warning':
            alerta.color = 'yellow';
            alerta.icono = 'bx-error';
            break;
    }
}

/**
 * Setea variable con los mensajes
 * @param {string|object} datos
 */
function setMensaje(datos) {
    if (datos.hasOwnProperty('mensaje')) {
        // OBJETO
        alerta.mensaje = datos.mensaje
        alerta.ayuda = datos.hasOwnProperty('ayuda') ? datos.ayuda : null;
        alerta.acciones = datos.hasOwnProperty('acciones') ? datos.acciones : [];
    } else {
        // STRING
        alerta.adicional = 'flex flex-column items-center';
        alerta.mensaje = datos;
    }
}

/**
 * genra contenio de la alerta
 * @return {string}
 */
function generaContenidoAlerta() {
    let ayuda = '';
    let acciones = '';
    if (alerta.ayuda) {
        ayuda = `<div class="mt-3 text-sm text-${alerta.color}-800 dark:text-${alerta.color}-500">
            ${alerta.ayuda}
        </div>`;
    }
    if (alerta.acciones.length) {
        alerta.acciones.forEach(accion => {
            acciones += `<a href="${accion.ruta}" class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-none focus:underline dark:text-blue-500">
                ${accion.descripcion}
            </a>`;
        });
        acciones = `<div class="flex justify-start gap-x-4 mt-3">${acciones}</div>`;
    }
    return `
    <h3 id="hs-toast-avatar-label" class="font-semibold text-sm mb-0 text-${alerta.color}-800 dark:text-${alerta.color}-500">
        ${alerta.mensaje}
    </h3>
    ${ayuda}
    ${acciones}
    `;
}

/**
 * Genera alerta del tipo segun el array
 * @return {string}
 */
function generaAlerta() {
    const { color, icono } = alerta;
    const body = generaContenidoAlerta();
    return `<div class="max-w-sm relative rounded-xl shadow-lg" role="alert" tabindex="-1" aria-labelledby="hs-toast-avatar-label">
        <div class="flex p-4 rounded-xl bg-${color}-100 border border-${color}-200 dark:bg-${color}-800/20 dark:border-${color}-700/30">
            <div class="shrink-0">
                <div class="inline-block size-8 rounded-full bg-${color}-200 dark:bg-${color}-800/70">
                    <div class="h-full flex justify-center items-center text-xl text-${color}-800 dark:text-${color}-500">
                        <i class="bx ${icono}"></i>
                    </div>
                </div>
                <button id="toast-alert-close" type="button"
                    class="absolute top-3 end-3 inline-flex shrink-0 justify-center items-center size-5 rounded-lg opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 text-${color}-800 dark:text-${color}-500"
                    aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="ms-4 me-5 ${alerta.adicional}">${body}</div>
        </div>
    </div>`;
}

/**
 * Formatea datos.Gnera html o texto para la alerta
 * @param {string|array} datos
 * @return {string}
*/
function generaAlertaHtml(datos) {
    if (Array.isArray(datos)) {
        setColor(datos[0]);
        setMensaje(datos[1]);
        datos = generaAlerta();
    }
    return datos;
}

/**
 * Funcion que activa el Toastify
 * @param {string|array} datos
*/
function ToastAlert(datos) {
    reseteaVariable();
    datos = generaAlertaHtml(datos);
    Toastify({
        text: datos,
        className: "hs-toastify-on:opacity-100 opacity-0 fixed -top-[150px] right-[20px] z-[90] transition-all duration-300 w-[320px] bg-white text-sm text-gray-700 border border-gray-200 rounded-xl shadow-lg [&>.toast-close]:hidden dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400",
        duration: 5000,
        close: true,
        escapeMarkup: false,
    }).showToast();
    const botonX = document.querySelector('#toast-alert-close');
    botonX.addEventListener('click', function (e) {
        tostifyCustomClose(e.target);
    });
}

export { ToastAlert }
