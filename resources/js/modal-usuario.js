window.addEventListener('DOMContentLoaded', function () {
    const formModal = document.getElementById('formModal');
    const exampleModal = document.querySelector('div#modal-example');

    function handleModal(event) {
        const button = event.target.closest('button');
        const tipo = button.getAttribute('data-tipo');
        const usuario = button.getAttribute('data-usuario');
        const titulo = exampleModal.querySelector('h3#descripcion-modal');
        const spanIcono = exampleModal.querySelector('span#icono-modal');
        const spanTipo = exampleModal.querySelector('p.text-gray-500 span#tipo');
        const spanUsuario = exampleModal.querySelector('p.text-gray-500 span.font-bold');
        const botonSubmit = formModal.querySelector('button[type=submit]');
        let metodo = 'POST';

        spanUsuario.textContent = usuario;
        titulo.textContent = tipo;
        spanTipo.textContent = tipo.toLowerCase();
        botonSubmit.textContent = `Sí, ${tipo.toLowerCase()}`;

        if (tipo === 'Bloquear') {
            spanIcono.className = spanIcono.className.replaceAll('yellow', 'red');
        } else {
            spanIcono.className = spanIcono.className.replaceAll('red', 'yellow');
        }

        const inputMetod = formModal.querySelector('input[name=_method]');
        inputMetod.value = metodo;
        formModal.action = button.getAttribute('data-ruta');
    }

    document.querySelectorAll('button#modal-example').forEach((btn) => {
        btn.addEventListener('click', handleModal);
    });
});

