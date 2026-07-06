// ================================================================
// MODAL ELIMINAR — Vista detalle de noticia
// ================================================================
function verAbrirEliminar() {
    const m = document.getElementById('modal-eliminar');
    if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
}
function verCerrarEliminar() {
    const m = document.getElementById('modal-eliminar');
    if (m) { m.style.display = 'none'; document.body.style.overflow = ''; }
}

// ================================================================
// MODAL DESPUBLICAR — Vista detalle de noticia
// ================================================================
function verAbrirDespublicar() {
    const m = document.getElementById('modal-despublicar');
    if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
}
function verCerrarDespublicar() {
    const m = document.getElementById('modal-despublicar');
    if (m) { m.style.display = 'none'; document.body.style.overflow = ''; }
}

// ================================================================
// MODAL APROBACIÓN MULTI-PASO — Vista detalle de noticia
// ================================================================
let verPasoActual = 1;
const verTotalPasos = 3;

function verAbrirAprobar() {
    verPasoActual = 1;

    const lcEl = document.getElementById('confirm-lectura');
    if (lcEl) lcEl.checked = false;
    const radioInm = document.querySelector('input[name="tipo_fecha"][value="inmediata"]');
    if (radioInm) radioInm.checked = true;
    const chkCar = document.getElementById('check-carrusel');
    if (chkCar) chkCar.checked = false;
    const campoProg = document.getElementById('campo-fecha-programada');
    if (campoProg) campoProg.classList.add('hidden');
    const inputFecha = document.getElementById('input-fecha-programada');
    if (inputFecha) inputFecha.value = '';

    // Resetear estilos de labels
    const labelInm  = document.getElementById('opcion-inmediata-label');
    const labelProg = document.getElementById('opcion-programada-label');
    if (labelInm)  { labelInm.style.borderColor = '#14b8a6'; labelInm.style.background = '#f0fdfa'; }
    if (labelProg) { labelProg.style.borderColor = '#e5e7eb'; labelProg.style.background = ''; }

    verActualizarVistaPaso();

    const m = document.getElementById('modal-aprobar');
    if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
}
function verCerrarAprobar() {
    const m = document.getElementById('modal-aprobar');
    if (m) { m.style.display = 'none'; document.body.style.overflow = ''; }
}

function verActualizarVistaPaso() {
    for (let i = 1; i <= verTotalPasos; i++) {
        const el = document.getElementById('aprobar-paso-' + i);
        if (el) el.style.display = i === verPasoActual ? 'block' : 'none';
    }

    // Dots
    document.querySelectorAll('#modal-aprobar .step-dot').forEach((dot, idx) => {
        dot.className = 'step-dot h-1.5 rounded-full transition-all duration-300';
        if (idx === verPasoActual - 1) { dot.classList.add('w-6', 'bg-teal-500'); }
        else if (idx < verPasoActual - 1) { dot.classList.add('w-2', 'bg-teal-300'); }
        else { dot.classList.add('w-2', 'bg-gray-300'); }
    });

    const btnA = document.getElementById('btn-anterior');
    if (btnA) btnA.style.display = verPasoActual > 1 ? 'inline-flex' : 'none';

    const btnS = document.getElementById('btn-siguiente');
    const btnP = document.getElementById('btn-publicar');
    if (verPasoActual === verTotalPasos) {
        if (btnS) btnS.style.display = 'none';
        if (btnP) btnP.style.display = 'inline-flex';
    } else {
        if (btnS) btnS.style.display = 'inline-flex';
        if (btnP) btnP.style.display = 'none';
    }

    if (verPasoActual === 1) verVerificarLectura();
    else if (btnS) btnS.disabled = false;
}

function verVerificarLectura() {
    const checked = document.getElementById('confirm-lectura')?.checked ?? false;
    const btnS = document.getElementById('btn-siguiente');
    if (btnS) btnS.disabled = !checked;
}

function verSiguiente() {
    if (verPasoActual < verTotalPasos) { verPasoActual++; verActualizarVistaPaso(); }
}
function verAnterior() {
    if (verPasoActual > 1) { verPasoActual--; verActualizarVistaPaso(); }
}

function verToggleFecha() {
    const tipo = document.querySelector('input[name="tipo_fecha"]:checked')?.value;
    const campoProg  = document.getElementById('campo-fecha-programada');
    const labelInm   = document.getElementById('opcion-inmediata-label');
    const labelProg  = document.getElementById('opcion-programada-label');
    const inputFecha = document.getElementById('input-fecha-programada');
    if (!campoProg) return;

    if (tipo === 'programada') {
        campoProg.classList.remove('hidden');
        if (labelInm)  { labelInm.style.borderColor = '#e5e7eb'; labelInm.style.background = ''; }
        if (labelProg) { labelProg.style.borderColor = '#a855f7'; labelProg.style.background = '#faf5ff'; }
    } else {
        campoProg.classList.add('hidden');
        if (inputFecha) inputFecha.value = '';
        if (labelProg) { labelProg.style.borderColor = '#e5e7eb'; labelProg.style.background = ''; }
        if (labelInm)  { labelInm.style.borderColor = '#14b8a6'; labelInm.style.background = '#f0fdfa'; }
    }
    verToggleCarruselLabel();
}

function verToggleCarruselLabel() {
    const tipo = document.querySelector('input[name="tipo_fecha"]:checked')?.value ?? 'inmediata';
    const span = document.getElementById('texto-cuando-carrusel');
    if (!span) return;
    if (tipo === 'programada') {
        const val = document.getElementById('input-fecha-programada')?.value;
        span.textContent = val ? 'cuando llegue la fecha programada' : 'en la fecha que programes';
    } else {
        span.textContent = 'de inmediato';
    }
}

// Exponer globalmente (necesario con módulos ES de Vite)
window.verAbrirEliminar     = verAbrirEliminar;
window.verCerrarEliminar    = verCerrarEliminar;
window.verAbrirDespublicar  = verAbrirDespublicar;
window.verCerrarDespublicar = verCerrarDespublicar;
window.verAbrirAprobar      = verAbrirAprobar;
window.verCerrarAprobar     = verCerrarAprobar;
window.verVerificarLectura  = verVerificarLectura;
window.verSiguiente         = verSiguiente;
window.verAnterior          = verAnterior;
window.verToggleFecha       = verToggleFecha;
window.verToggleCarruselLabel = verToggleCarruselLabel;

// Cerrar con ESC
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        verCerrarEliminar();
        verCerrarAprobar();
        verCerrarDespublicar();
    }
});

// Actualizar eventos que antes eran onchange inline
function initVerNoticia() {
    const fi = document.getElementById('input-fecha-programada');
    if (fi) fi.addEventListener('change', verToggleCarruselLabel);

    const cl = document.getElementById('confirm-lectura');
    if (cl) cl.addEventListener('change', verVerificarLectura);

    const radios = document.querySelectorAll('#modal-aprobar input[name="tipo_fecha"]');
    radios.forEach(r => r.addEventListener('change', verToggleFecha));

    const cc = document.getElementById('check-carrusel');
    if (cc) cc.addEventListener('change', verToggleCarruselLabel);
}

if (document.readyState === 'loading') {
    document.addEventListener('turbo:load', initVerNoticia);
} else {
    initVerNoticia();
}

// ================================================================
// EVENT DELEGATION — Botones con data-ver-accion (reemplaza onclick inline)
// ================================================================
document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-ver-accion]');
    if (!btn) return;

    const accion = btn.dataset.verAccion;

    if (accion === 'aprobar') {
        verAbrirAprobar();
    } else if (accion === 'despublicar') {
        verAbrirDespublicar();
    } else if (accion === 'eliminar') {
        verAbrirEliminar();
    } else if (accion === 'cerrar-aprobar') {
        verCerrarAprobar();
    } else if (accion === 'cerrar-despublicar') {
        verCerrarDespublicar();
    } else if (accion === 'cerrar-eliminar') {
        verCerrarEliminar();
    } else if (accion === 'paso-siguiente') {
        verSiguiente();
    } else if (accion === 'paso-anterior') {
        verAnterior();
    }
});
