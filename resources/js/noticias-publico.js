(function() {
    function initModule() {
            const buscador = document.getElementById('buscador-noticias');
            const contenedor = document.getElementById('contenedor-noticias');
            let timeout = null;

            buscador.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    const query = buscador.value;
                    fetch(`/noticias?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        contenedor.innerHTML = html;
                    })
                    .catch(error => console.error('Error al buscar noticias:', error));
                }, 400);
            });
            }

    if (document.readyState !== 'loading') {
        initModule();
    } else {
        document.addEventListener('DOMContentLoaded', initModule);
    }
    document.addEventListener('turbo:load', initModule);
})();
