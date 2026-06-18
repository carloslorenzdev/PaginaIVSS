import { buildEditor } from "../libs/tiptap/tiptap-editor";

function initEditorConfig() {
    if (document.getElementById('hs-editor-tiptap')) {
        const editorContenido = buildEditor('hs-editor-tiptap', 'Escribe el contenido aquí...');
        const inputContenido = document.getElementById('contenido');

        if (inputContenido) {
            const form = inputContenido.closest('form');
            if (form) {
                form.addEventListener('submit', function () {
                    inputContenido.value = editorContenido.getHTML();
                });
            }
        }
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initEditorConfig);
} else {
    initEditorConfig();
}
