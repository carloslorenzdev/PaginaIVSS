document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Alerta de Seguridad',
                html: '<p>Por medidas de seguridad, es <strong>obligatorio</strong> que asigne una nueva contraseña personal.</p><br><p>Una vez cambiada, por favor diríjase a su <b>Perfil</b> y active la <b>Autenticación 2FA</b>.</p>',
                icon: 'warning',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#dc2626',
                allowOutsideClick: false
            });
        });