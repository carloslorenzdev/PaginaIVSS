@extends('layouts/app')

@section('titulo', 'Gestión de Enlaces')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Gestión de Enlaces Dinámicos" class="text-gradient font-extrabold text-3xl" />
        </div>
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Enlaces Dinámicos
            </x-breadcrumb.current>
        </x-breadcrumb>

        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-2xl p-6 md:p-8 shadow-sm max-w-5xl mx-auto">
            <div class="mb-8 border-b border-gray-100 dark:border-neutral-800 pb-5">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <i class="bx bx-link-alt text-xl"></i>
                    </div>
                    Configuración de Redirecciones
                </h3>
                <p class="text-sm font-medium text-gray-500 mt-3 leading-relaxed max-w-3xl">
                    Aquí puedes configurar las direcciones (URLs) a las que llevarán los botones principales de la página pública.
                    Si dejas un campo vacío, el botón correspondiente no hará nada o recargará la página por defecto.
                </p>
                <div class="mt-3 inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300 text-xs font-semibold border border-blue-200/60 dark:border-blue-900/50">
                    <i class="bx bx-info-circle text-base text-blue-500"></i>
                    <span>Haz clic en el botón de estado o en el icono del ojo (<i class="bx bx-show text-emerald-600"></i> / <i class="bx bx-hide text-amber-500"></i>) para <strong>ocultar o activar</strong> cualquier enlace en la página pública sin perder la URL configurada.</span>
                </div>
            </div>

            <form action="{{ route('admin.config.enlaces.guardar') }}" method="POST" class="space-y-6">
                @csrf

                @foreach($grupos as $nombreGrupo => $clavesGrupo)
                    <div class="border border-gray-100 dark:border-neutral-700/50 rounded-xl overflow-hidden shadow-sm bg-gray-50/50 dark:bg-neutral-800/30 transition-all hover:shadow-md group">
                        <div class="bg-gray-100/50 dark:bg-neutral-800/80 border-b border-gray-100 dark:border-neutral-700/50 px-5 py-4 flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-gray-200 dark:bg-neutral-700 flex items-center justify-center text-gray-600 dark:text-neutral-400 group-hover:bg-red-100 group-hover:text-red-600 dark:group-hover:bg-red-900/30 dark:group-hover:text-red-400 transition-colors">
                                <i class="bx bx-folder"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-800 dark:text-neutral-200">
                                {{ $nombreGrupo }}
                            </h3>
                        </div>
                        <div class="p-5 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach($clavesGrupo as $clave => $titulo)
                            @php
                                $esVisible = ($visibilidad['visible_' . $clave] ?? '1') !== '0';
                            @endphp
                            <div class="enlace-card" data-clave="{{ $clave }}">
                                <div class="flex items-center justify-between mb-1.5">
                                    <label for="{{ $clave }}" class="block text-sm font-bold dark:text-white text-gray-700">
                                        {{ $titulo }}
                                    </label>
                                    
                                    <!-- Botón de estado / visibilidad -->
                                    <button type="button" 
                                            data-clave="{{ $clave }}"
                                            class="btn-toggle-visibilidad inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full border transition-all cursor-pointer shadow-sm hover:scale-105 active:scale-95 focus:outline-none {{ $esVisible ? 'text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 border-emerald-200 dark:border-emerald-800/50 hover:bg-emerald-100' : 'text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 border-amber-200 dark:border-amber-800/50 hover:bg-amber-100' }}"
                                            title="{{ $esVisible ? 'Clic para ocultar en la página pública' : 'Clic para activar en la página pública' }}">
                                        <i class="badge-icon bx {{ $esVisible ? 'bx-show text-sm text-emerald-600' : 'bx-hide text-sm text-amber-600' }}"></i>
                                        <span class="badge-text">{{ $esVisible ? 'Visible' : 'Oculto al público' }}</span>
                                    </button>
                                </div>

                                <!-- Input oculto para persistencia en guardado global -->
                                <input type="hidden" name="visible_{{ $clave }}" id="input-vis-{{ $clave }}" value="{{ $esVisible ? '1' : '0' }}">

                                <div class="relative flex items-center group/input">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
                                        <i class="bx bx-link text-gray-400 group-focus-within/input:text-red-500 transition-colors"></i>
                                    </div>
                                    <input type="url" name="{{ $clave }}" id="{{ $clave }}" value="{{ $enlaces[$clave] ?? '' }}" 
                                           placeholder="https://ejemplo.com"
                                           class="input-enlace-url py-2.5 px-4 ps-10 pe-12 block w-full rounded-xl text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:text-neutral-300 dark:placeholder-neutral-500 shadow-sm hover:border-gray-300 dark:hover:border-neutral-600 transition-all {{ $esVisible ? 'border-gray-200 dark:border-neutral-700' : 'border-dashed border-amber-300 dark:border-amber-700/60 bg-amber-50/20 dark:bg-neutral-800/50 text-gray-400' }}">

                                    <!-- Botón del ojo a la derecha del input -->
                                    <button type="button" 
                                            data-clave="{{ $clave }}"
                                            class="btn-toggle-visibilidad absolute inset-y-0 end-0 pe-2.5 flex items-center justify-center focus:outline-none"
                                            title="{{ $esVisible ? 'Clic para ocultar en la página pública' : 'Clic para activar en la página pública' }}">
                                        <div class="eye-box size-8 rounded-lg flex items-center justify-center transition-all cursor-pointer {{ $esVisible ? 'text-emerald-600 hover:bg-emerald-100/70 dark:text-emerald-400' : 'text-amber-500 hover:bg-amber-100/70 dark:text-amber-400' }}">
                                            <i class="eye-icon bx {{ $esVisible ? 'bx-show text-lg' : 'bx-hide text-lg' }}"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-neutral-800">
                    <button type="submit" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2 transform hover:-translate-y-0.5">
                        <i class="bx bx-save text-lg"></i> Guardar Enlaces
                    </button>
                </div>
            </form>
        </div>
    </x-section>
@endsection

@push('page-scripts')
<script nonce="{{ app('csp-nonce') }}">
(function () {
    function initEnlacesToggle() {
        const toggleUrl = "{{ route('admin.config.enlaces.toggle') }}";
        const csrfToken = "{{ csrf_token() }}";

        document.querySelectorAll('.btn-toggle-visibilidad').forEach(btn => {
            if (btn.dataset.boundToggle === 'true') return;
            btn.dataset.boundToggle = 'true';

            btn.addEventListener('click', async function (e) {
                e.preventDefault();
                const clave = this.getAttribute('data-clave');
                if (!clave) return;

                const card = document.querySelector(`.enlace-card[data-clave="${clave}"]`);
                if (!card) return;

                // Elementos dentro de la tarjeta del enlace
                const hiddenInput = card.querySelector(`#input-vis-${clave}`);
                const urlInput = card.querySelector('.input-enlace-url');
                const badgeBtn = card.querySelector('.btn-toggle-visibilidad:not(.absolute)');
                const badgeIcon = badgeBtn ? badgeBtn.querySelector('.badge-icon') : null;
                const badgeText = badgeBtn ? badgeBtn.querySelector('.badge-text') : null;
                const eyeBtn = card.querySelector('.btn-toggle-visibilidad.absolute');
                const eyeBox = eyeBtn ? eyeBtn.querySelector('.eye-box') : null;
                const eyeIcon = eyeBtn ? eyeBtn.querySelector('.eye-icon') : null;

                // Deshabilitar temporalmente mientras procesa
                if (badgeBtn) badgeBtn.style.pointerEvents = 'none';
                if (eyeBtn) eyeBtn.style.pointerEvents = 'none';

                // Estado de carga
                if (eyeIcon) {
                    eyeIcon.className = 'eye-icon bx bx-loader-alt animate-spin text-lg text-gray-400';
                }
                if (badgeIcon) {
                    badgeIcon.className = 'badge-icon bx bx-loader-alt animate-spin text-sm';
                }

                try {
                    const response = await fetch(toggleUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ clave: clave })
                    });

                    const data = await response.json();

                    if (data && data.success) {
                        const isVisible = (data.visible === true || data.valor === '1');
                        
                        // Actualizar input oculto
                        if (hiddenInput) {
                            hiddenInput.value = isVisible ? '1' : '0';
                        }

                        // Actualizar Badge / Botón superior
                        if (badgeBtn) {
                            if (isVisible) {
                                badgeBtn.className = 'btn-toggle-visibilidad inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full border transition-all cursor-pointer shadow-sm hover:scale-105 active:scale-95 focus:outline-none text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 border-emerald-200 dark:border-emerald-800/50 hover:bg-emerald-100';
                                badgeBtn.title = 'Clic para ocultar en la página pública';
                                if (badgeIcon) badgeIcon.className = 'badge-icon bx bx-show text-sm text-emerald-600';
                                if (badgeText) badgeText.textContent = 'Visible';
                            } else {
                                badgeBtn.className = 'btn-toggle-visibilidad inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full border transition-all cursor-pointer shadow-sm hover:scale-105 active:scale-95 focus:outline-none text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 border-amber-200 dark:border-amber-800/50 hover:bg-amber-100';
                                badgeBtn.title = 'Clic para activar en la página pública';
                                if (badgeIcon) badgeIcon.className = 'badge-icon bx bx-hide text-sm text-amber-600';
                                if (badgeText) badgeText.textContent = 'Oculto al público';
                            }
                        }

                        // Actualizar Botón del Ojo dentro del input
                        if (eyeBtn) {
                            eyeBtn.title = isVisible ? 'Clic para ocultar en la página pública' : 'Clic para activar en la página pública';
                        }
                        if (eyeBox) {
                            eyeBox.className = isVisible 
                                ? 'eye-box size-8 rounded-lg flex items-center justify-center transition-all cursor-pointer text-emerald-600 hover:bg-emerald-100/70 dark:text-emerald-400'
                                : 'eye-box size-8 rounded-lg flex items-center justify-center transition-all cursor-pointer text-amber-500 hover:bg-amber-100/70 dark:text-amber-400';
                        }
                        if (eyeIcon) {
                            eyeIcon.className = isVisible
                                ? 'eye-icon bx bx-show text-lg'
                                : 'eye-icon bx bx-hide text-lg';
                        }

                        // Actualizar estilos del input URL
                        if (urlInput) {
                            if (isVisible) {
                                urlInput.classList.remove('border-dashed', 'border-amber-300', 'dark:border-amber-700/60', 'bg-amber-50/20', 'dark:bg-neutral-800/50', 'text-gray-400');
                                urlInput.classList.add('border-gray-200', 'dark:border-neutral-700');
                            } else {
                                urlInput.classList.remove('border-gray-200', 'dark:border-neutral-700');
                                urlInput.classList.add('border-dashed', 'border-amber-300', 'dark:border-amber-700/60', 'bg-amber-50/20', 'dark:bg-neutral-800/50', 'text-gray-400');
                            }
                        }

                        // Notificación Toast con SweetAlert2
                        if (typeof Swal !== 'undefined') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            });
                            Toast.fire({
                                icon: isVisible ? 'success' : 'info',
                                title: data.message || (isVisible ? 'Enlace ahora visible al público' : 'Enlace ocultado al público')
                            });
                        }
                    }
                } catch (error) {
                    // Silenciar errores en consola si la petición es abortada
                } finally {
                    if (badgeBtn) badgeBtn.style.pointerEvents = '';
                    if (eyeBtn) eyeBtn.style.pointerEvents = '';
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEnlacesToggle);
    } else {
        initEnlacesToggle();
    }
    document.addEventListener('livewire:navigated', initEnlacesToggle);
})();
</script>
@endpush
