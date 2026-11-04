const csrfToken = '{{ csrf_token() }}';
        let currentUsername = '';
        let currentCode = '';
        let currentResetToken = '';

        async function verifyUser() {
            const btn = document.getElementById('btn-step-1');
            const usuarioInput = document.getElementById('usuario');
            const usuario = usuarioInput.value.trim();
            if(!usuario) return;

            btn.disabled = true;
            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Verificando...';

            try {
                const res = await fetch('{{ route("password.verify-user") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ usuario })
                });
                const data = await res.json();

                if(!res.ok) {
                    if(res.status === 403 && data.has_2fa === false) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Atención',
                            text: data.message,
                            confirmButtonColor: '#d33'
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Error de validación', 'error');
                    }
                } else {
                    currentUsername = usuario;
                    document.getElementById('step-1').classList.add('hidden');
                    document.getElementById('step-2').classList.remove('hidden');
                    document.getElementById('codigo').focus();
                }
            } catch (error) {
                Swal.fire('Error', 'Ocurrió un error inesperado', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Continuar';
            }
        }

        async function verifyCode() {
            const btn = document.getElementById('btn-step-2');
            const codigo = document.getElementById('codigo').value.trim();
            if(!codigo) return;

            btn.disabled = true;
            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Verificando...';

            try {
                const res = await fetch('{{ route("password.verify-code") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ usuario: currentUsername, codigo })
                });
                const data = await res.json();

                if(!res.ok) {
                    Swal.fire('Error', data.message || 'Código incorrecto', 'error');
                } else {
                    currentCode = codigo;
                    currentResetToken = data.reset_token;
                    document.getElementById('step-2').classList.add('hidden');
                    document.getElementById('step-3').classList.remove('hidden');
                    document.getElementById('password').focus();
                }
            } catch (error) {
                Swal.fire('Error', 'Ocurrió un error inesperado', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Verificar Código';
            }
        }

        async function resetPassword() {
            const btn = document.getElementById('btn-step-3');
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;
            
            if(!password || password !== password_confirmation) {
                return Swal.fire('Error', 'Las contraseñas no coinciden o están vacías', 'error');
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Restableciendo...';

            try {
                const res = await fetch('{{ route("password.update") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify({ 
                        reset_token: currentResetToken,
                        password, 
                        password_confirmation 
                    })
                });
                const data = await res.json();

                if(!res.ok) {
                    let msg = data.message || 'Error al restablecer';
                    if(data.errors && data.errors.password) {
                        msg = data.errors.password[0];
                    }
                    Swal.fire('Error', msg, 'error');
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Contraseña restablecida correctamente',
                        confirmButtonColor: '#3085d6',
                    }).then(() => {
                        window.location.href = '{{ route("login") }}';
                    });
                }
            } catch (error) {
                Swal.fire('Error', 'Ocurrió un error inesperado', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Restablecer Contraseña';
            }
        }