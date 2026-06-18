import { ToastAlert } from './toastify';

window.addEventListener('DOMContentLoaded', function () {
    const inputVeracidad = document.querySelector('input[name="veracidad"][type="checkbox"]');
    if (inputVeracidad) {
        const formVeracidad = inputVeracidad.closest('form');
        const botonSubmit = formVeracidad.querySelector('button[type="submit"]');
        botonSubmit.addEventListener('click', function (e) {
            if (!inputVeracidad.checked) {
                e.preventDefault();
                ToastAlert(['danger', 'Debe confirmar la veracidad y cumplimiento legal']);
                // } else {
                //     formVeracidad.submit();
            }
        });
        inputVeracidad.addEventListener('change', function (e) {
            const input = e.target;
            if (input.checked) {
                botonSubmit.removeAttribute('disabled');
            } else {
                botonSubmit.setAttribute('disabled', true);
            }
        });
    }
});
