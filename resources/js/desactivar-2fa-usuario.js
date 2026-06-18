import { buildEditor } from "../libs/tiptap/tiptap-editor";
import { ToastAlert } from "./toastify";

window.addEventListener('DOMContentLoaded', function () {
    const botonSubmit = document.querySelector('button#btn-desactivar-2fa');
    const editorObservacion = buildEditor('hs-editor-tiptap', 'Agrega el motivo');
    botonSubmit.addEventListener('click', function (e) {
        e.preventDefault();
        if (editorObservacion.storage.characterCount.characters() >= 10) {
            const content = editorObservacion.getHTML();
            const form = botonSubmit.closest('form');
            const input = form.querySelector('input[name="observacion"]');
            input.value = content;
            form.submit();
        } else {
            editorObservacion.chain().focus();
            ToastAlert(['danger', 'Mínimo 10 caracteres']);
        }
    });
});
