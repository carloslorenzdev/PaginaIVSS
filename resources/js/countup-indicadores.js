import { CountUp } from "countup.js";

window.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.countup').forEach((elemento) => {
        if (!elemento) {
            return;
        }

        /**
         * @type {import("countup.js").CountUpOptions}
         */
        const options = {
            startVal: 0,
            duration: 1,
            separator: '.',
            decimal: ',',
            decimalPlaces: 0,
        };

        let numero = Number(elemento.dataset.numero);
        let inicio = Number(numero * 0.8).toFixed();

        options.startVal = inicio

        if (numero) {
            if (elemento.dataset.prefix) {
                options.prefix = `${elemento.dataset.prefix} `;
            }
            if (elemento.dataset.suffix) {
                options.suffix = ` ${elemento.dataset.suffix}`;
            }
            if (elemento.dataset.decimales) {
                options.decimalPlaces = Number(elemento.dataset.decimales);
            }

            let demo = new CountUp(elemento, numero, options);

            if (!demo.error) {
                demo.start();
            } else {
                console.error(demo.error);
            }
        }
    });
});
