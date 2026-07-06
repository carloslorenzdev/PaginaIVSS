import { buildEditor } from "../libs/tiptap/tiptap-editor";
import { ToastAlert } from "./toastify";

window.addEventListener('turbo:load', function () {
    const botonSubmit = document.querySelector('button#btn-editar-usuario');
    const editorObservacion = buildEditor('hs-editor-tiptap', 'Agrega una observación');
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
