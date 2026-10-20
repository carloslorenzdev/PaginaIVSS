import { buildEditor } from "../libs/tiptap/tiptap-editor";

(function() {
    function initModule() {
    const checkAutorizado = document.querySelector('input#sw-autorizado');
    const camposAutorizado = document.querySelector('div#campos-autorizado');
    const botonSubmit = document.querySelector('button#btn-procesar-solicitud');
    const editorObservacion = buildEditor('hs-editor-tiptap', 'Agrega una observación si aplica');

    function handleCamposAutorizado(input) {
        if (input.checked) {
            camposAutorizado.classList.remove('hidden');
            camposAutorizado.classList.add('block');
        } else {
            camposAutorizado.classList.remove('block');
            camposAutorizado.classList.add('hidden');
        }
    }

    handleCamposAutorizado(checkAutorizado);

    checkAutorizado.addEventListener('change', function (e) {
        handleCamposAutorizado(e.target);
    });

    botonSubmit.addEventListener('click', function (e) {
        e.preventDefault();
        const content = editorObservacion.getHTML();
        const form = botonSubmit.closest('form');
        const input = form.querySelector('input[name="observacion"]');
        input.value = editorObservacion.storage.characterCount.characters() ? content : null;
        form.submit();
    });
    }

    if (document.readyState !== 'loading') {
        initModule();
    } else {
        document.addEventListener('DOMContentLoaded', initModule);
    }
    document.addEventListener('livewire:navigated', initModule);
})();

