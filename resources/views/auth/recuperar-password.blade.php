@extends('layouts/blank')

@section('titulo', 'Recuperar Contraseña')

@section('content')
    <main class="flex flex-wrap justify-center min-h-[calc(100vh-50px)]">
        <div class="hidden md:block w-1/2 relative overflow-hidden">
            <div class="size-full absolute z-0">
                <x-svg.laberinto class="h-full stroke-gray-400/30 dark:stroke-red-900/90" />
            </div>
            <div class="flex flex-col h-full relative">
                <div class="px-6 pt-6">
                    <a href="/" class="inline-flex">
                        <x-svg.ivss class="size-16 fill-red-600 dark:fill-neutral-200" />
                    </a>
                </div>
                <div class="grow flex flex-col justify-center px-6 space-y-2">
                    <div class="animate-fade-in-left animate-delay-100 animate-duration-200">
                        <h1 class="text-5xl/10 font-bold tracking-tight text-shadow-xs animate-fade-in-down animate-delay-100 bg-linear-to-r from-red-500 to-violet-500 dark:from-red-500 dark:via-rose-500 dark:via-20% dark:to-pink-600 bg-clip-text text-transparent">
                            Recuperación de Acceso
                        </h1>
                        <p class="text-md tracking-tight text-gray-800 dark:text-white text-shadow-xs">
                            Sigue los pasos para restablecer tu contraseña usando tu Autenticador.
                        </p>
                    </div>
                </div>
                <div>
                    @include('layouts/sections/footer')
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/2">
            <div class="flex flex-col justify-center h-full">
                <div class="flex items-center justify-between px-6 pt-4">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">
                        <i class="bx bx-arrow-back"></i> Volver al Login
                    </a>
                    <div>
                        @include('layouts/sections/navbar/mode-theme')
                    </div>
                </div>
                <div class="grow px-6 md:px-16 lg:px-24 flex flex-col justify-center items-center">
                    <div class="w-full md:max-w-md space-y-3 animate-fade-in-left">
                        <div class="flex justify-center md:hidden">
                            <x-logo />
                        </div>
                        
                        <div id="step-1" class="space-y-6">
                            <div class="text-center md:text-left mt-6">
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
                                    Paso 1: Identificación
                                </h2>
                                <h5 class="text-gray-600 dark:text-neutral-400">
                                    Ingresa tu nombre de usuario
                                </h5>
                            </div>
                            <form id="form-step-1" class="space-y-6" onsubmit="event.preventDefault(); verifyUser();">
                                <div>
                                    <x-input.label for="usuario">Usuario</x-input.label>
                                    <x-input type="text" id="usuario" name="usuario" placeholder="Tu usuario" required />
                                </div>
                                <x-input.button class="w-full" type="submit" id="btn-step-1">
                                    Continuar
                                </x-input.button>
                            </form>
                        </div>

                        <div id="step-2" class="space-y-6 hidden">
                            <div class="text-center md:text-left mt-6">
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
                                    Paso 2: Autenticación 2FA
                                </h2>
                                <h5 class="text-gray-600 dark:text-neutral-400">
                                    Ingresa el código de 6 dígitos de tu aplicación Authenticator
                                </h5>
                            </div>
                            <form id="form-step-2" class="space-y-6" onsubmit="event.preventDefault(); verifyCode();">
                                <div>
                                    <x-input.label for="codigo">Código OTP</x-input.label>
                                    <x-input type="text" id="codigo" name="codigo" placeholder="000000" maxlength="6" required />
                                </div>
                                <x-input.button class="w-full" type="submit" id="btn-step-2">
                                    Verificar Código
                                </x-input.button>
                            </form>
                        </div>

                        <div id="step-3" class="space-y-6 hidden">
                            <div class="text-center md:text-left mt-6">
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
                                    Paso 3: Nueva Contraseña
                                </h2>
                                <h5 class="text-gray-600 dark:text-neutral-400">
                                    Ingresa tu nueva contraseña
                                </h5>
                            </div>
                            <form id="form-step-3" class="space-y-6" onsubmit="event.preventDefault(); resetPassword();">
                                <div>
                                    <x-input.label for="password">Nueva Contraseña</x-input.label>
                                    <x-input.password id="password" name="password" placeholder="Mínimo 8 caracteres" required />
                                </div>
                                <div>
                                    <x-input.label for="password_confirmation">Confirmar Contraseña</x-input.label>
                                    <x-input.password id="password_confirmation" name="password_confirmation" placeholder="Confirmar contraseña" required />
                                </div>
                                <x-input.button class="w-full" type="submit" id="btn-step-3">
                                    Restablecer Contraseña
                                </x-input.button>
                            </form>
                        </div>
                        
                    </div>
                </div>
                <div class="block md:hidden">
                    @include('layouts/sections/footer')
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const csrfToken = '{{ csrf_token() }}';
        let currentUsername = '';
        let currentCode = '';

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
                        usuario: currentUsername, 
                        codigo: currentCode, 
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
    </script>
@endsection
