// ================================================================
// MODAL ELIMINAR — Panel de Noticias
// ================================================================
function panelAbrirEliminar(id, titulo) {
    document.getElementById('panel-eliminar-titulo').textContent = '"' + titulo + '"';
    document.getElementById('panel-form-eliminar').action = '/admin/noticias/' + id;
    const m = document.getElementById('panel-modal-eliminar');
    if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
}
function panelCerrarEliminar() {
    const m = document.getElementById('panel-modal-eliminar');
    if (m) { m.style.display = 'none'; document.body.style.overflow = ''; }
}

// ================================================================
// MODAL APROBACIÓN MULTI-PASO — Panel de Noticias
// ================================================================
let panelPasoActual = 1;

function panelAbrirAprobar(id, titulo, resumen) {
    panelPasoActual = 1;

    // Resetear formulario
    const confirmEl = document.getElementById('panel-confirm-lectura');
    if (confirmEl) confirmEl.checked = false;
    const radioInm = document.querySelector('input[name="tipo_fecha"][value="inmediata"]');
    if (radioInm) radioInm.checked = true;
    const chkCar = document.getElementById('panel-check-carrusel');
    if (chkCar) chkCar.checked = false;
    const campoProg = document.getElementById('panel-campo-fecha');
    if (campoProg) campoProg.style.display = 'none';
    const inputFecha = document.getElementById('panel-input-fecha');
    if (inputFecha) inputFecha.value = '';

    // Resetear estilos de los labels de fecha
    const labelInm = document.getElementById('panel-label-inm');
    const labelProg = document.getElementById('panel-label-prog');
    if (labelInm)  { labelInm.style.borderColor = '#14b8a6'; labelInm.style.background = '#f0fdfa'; }
    if (labelProg) { labelProg.style.borderColor = '#d1d5db'; labelProg.style.background = ''; }

    // Resetear carrusel label
    const labelCar = document.getElementById('panel-label-carrusel');
    if (labelCar) { labelCar.style.borderColor = '#d1d5db'; labelCar.style.background = ''; }

    // Rellenar datos
    const tituloEl = document.getElementById('panel-aprobar-titulo');
    if (tituloEl) tituloEl.textContent = titulo;
    const resumenEl = document.getElementById('panel-aprobar-resumen');
    if (resumenEl) resumenEl.textContent = resumen || '';
    const form = document.getElementById('panel-form-aprobar');
    if (form) form.action = '/admin/noticias/' + id + '/publicar';

    panelActualizarVista();

    const m = document.getElementById('panel-modal-aprobar');
    if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
}

function panelCerrarAprobar() {
    const m = document.getElementById('panel-modal-aprobar');
    if (m) { m.style.display = 'none'; document.body.style.overflow = ''; }
}

function panelActualizarVista() {
    [1, 2, 3].forEach(n => {
        const el = document.getElementById('panel-paso-' + n);
        if (el) el.style.display = n === panelPasoActual ? 'block' : 'none';
    });

    // Dots
    document.querySelectorAll('#panel-steps-dots .pdot').forEach((dot, idx) => {
        if (idx === panelPasoActual - 1) { dot.style.width = '24px'; dot.style.background = '#14b8a6'; }
        else if (idx < panelPasoActual - 1) { dot.style.width = '8px'; dot.style.background = '#5eead4'; }
        else { dot.style.width = '8px'; dot.style.background = '#d1d5db'; }
    });

    const btnAnt = document.getElementById('panel-btn-ant');
    if (btnAnt) btnAnt.style.display = panelPasoActual > 1 ? 'inline-flex' : 'none';

    const btnSig = document.getElementById('panel-btn-sig');
    const btnPub = document.getElementById('panel-btn-pub');
    if (panelPasoActual === 3) {
        if (btnSig) btnSig.style.display = 'none';
        if (btnPub) btnPub.style.display = 'inline-flex';
    } else {
        if (btnSig) btnSig.style.display = 'inline-flex';
        if (btnPub) btnPub.style.display = 'none';
    }

    if (panelPasoActual === 1) panelVerificarLectura();
    else if (btnSig) btnSig.disabled = false;
}

function panelVerificarLectura() {
    const checked = document.getElementById('panel-confirm-lectura')?.checked ?? false;
    const btnSig = document.getElementById('panel-btn-sig');
    if (btnSig) btnSig.disabled = !checked;
}

function panelSiguiente() {
    if (panelPasoActual < 3) { panelPasoActual++; panelActualizarVista(); }
}
function panelAnterior() {
    if (panelPasoActual > 1) { panelPasoActual--; panelActualizarVista(); }
}

function panelToggleFecha() {
    const tipo = document.querySelector('input[name="tipo_fecha"]:checked')?.value;
    const campo = document.getElementById('panel-campo-fecha');
    const labelInm = document.getElementById('panel-label-inm');
    const labelProg = document.getElementById('panel-label-prog');
    const inputFecha = document.getElementById('panel-input-fecha');

    if (tipo === 'programada') {
        if (campo) campo.style.display = 'block';
        if (labelInm)  { labelInm.style.borderColor = '#d1d5db'; labelInm.style.background = ''; }
        if (labelProg) { labelProg.style.borderColor = '#a855f7'; labelProg.style.background = '#faf5ff'; }
    } else {
        if (campo) campo.style.display = 'none';
        if (inputFecha) inputFecha.value = '';
        if (labelProg) { labelProg.style.borderColor = '#d1d5db'; labelProg.style.background = ''; }
        if (labelInm)  { labelInm.style.borderColor = '#14b8a6'; labelInm.style.background = '#f0fdfa'; }
    }
    panelActualizarTextoCarrusel();
}

function panelToggleCarrusel() {
    const label = document.getElementById('panel-label-carrusel');
    const checked = document.getElementById('panel-check-carrusel')?.checked;
    if (label) { label.style.borderColor = checked ? '#f97316' : '#d1d5db'; label.style.background = checked ? '#fff7ed' : ''; }
    panelActualizarTextoCarrusel();
}

function panelActualizarTextoCarrusel() {
    const tipo = document.querySelector('input[name="tipo_fecha"]:checked')?.value;
    const span = document.getElementById('panel-texto-carrusel');
    if (!span) return;
    if (tipo === 'programada') {
        const val = document.getElementById('panel-input-fecha')?.value;
        span.textContent = val ? ' cuando llegue la fecha programada' : ' en la fecha que programes';
    } else {
        span.textContent = 'de inmediato';
    }
}

// ================================================================
// EVENT DELEGATION — Botones con data-accion (reemplaza onclick inline)
// ================================================================
document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-accion]');
    if (!btn) return;

    const accion = btn.dataset.accion;
    const id     = btn.dataset.id;
    const titulo = btn.dataset.titulo || '';
    const resumen = btn.dataset.resumen || '';

    if (accion === 'eliminar') {
        panelAbrirEliminar(id, titulo);
    } else if (accion === 'aprobar') {
        panelAbrirAprobar(id, titulo, resumen);
    } else if (accion === 'cerrar-eliminar') {
        panelCerrarEliminar();
    } else if (accion === 'cerrar-aprobar') {
        panelCerrarAprobar();
    } else if (accion === 'paso-anterior') {
        panelAnterior();
    } else if (accion === 'paso-siguiente') {
        panelSiguiente();
    }
});

// Exponer globalmente (necesario si Vite usa módulos ES)
window.panelAbrirEliminar          = panelAbrirEliminar;
window.panelCerrarEliminar         = panelCerrarEliminar;
window.panelAbrirAprobar           = panelAbrirAprobar;
window.panelCerrarAprobar          = panelCerrarAprobar;
window.panelVerificarLectura       = panelVerificarLectura;
window.panelSiguiente              = panelSiguiente;
window.panelAnterior               = panelAnterior;
window.panelToggleFecha            = panelToggleFecha;
window.panelToggleCarrusel         = panelToggleCarrusel;
window.panelActualizarTextoCarrusel = panelActualizarTextoCarrusel;

// Cerrar con ESC
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { panelCerrarEliminar(); panelCerrarAprobar(); }
});

// Event listeners para reemplazar los onchange inline (por CSP)
document.addEventListener('turbo:load', () => {
    const cl = document.getElementById('panel-confirm-lectura');
    if (cl) cl.addEventListener('change', panelVerificarLectura);

    const radios = document.querySelectorAll('#panel-modal-aprobar input[name="tipo_fecha"]');
    radios.forEach(r => r.addEventListener('change', panelToggleFecha));

    const pi = document.getElementById('panel-input-fecha');
    if (pi) pi.addEventListener('change', panelActualizarTextoCarrusel);

    const cc = document.getElementById('panel-check-carrusel');
    if (cc) cc.addEventListener('change', panelToggleCarrusel);
});
