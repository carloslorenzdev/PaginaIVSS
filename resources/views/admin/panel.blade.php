@extends('layouts/app')

@section('titulo', 'Dashboard')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="Panel Principal" />
            <x-button.link href="{{ route('admin.noticias.crear') }}"
                class="rounded-lg text-red-500 hover:text-red-800 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
                <i class="bx bx-plus"></i>
                Nueva Noticia
            </x-button.link>
        </div>

        {{-- INDICADORES --}}
        @include('admin/panel/indicadores')

        {{-- BÚSQUEDA --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-1">
            <div class="col-span-1 sm:col-span-2 order-2 lg:order-1">
                @include('admin/panel/busqueda')
            </div>
        </div>

        {{-- TABLA --}}
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden rounded-lg space-y-3 pb-3">
                    @include('admin/panel/tabla')
                </div>
            </div>
        </div>

        {{ $noticias->onEachSide(1)->links() }}
    </x-section>

    {{-- ================================================================ --}}
    {{-- MODAL: ELIMINAR NOTICIA (solo admin)                             --}}
    {{-- ================================================================ --}}
    @hasanyrole('admin')
    <div id="panel-modal-eliminar" style="display:none;position:fixed;inset:0;z-index:70;align-items:center;justify-content:center;padding:1rem;">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" data-accion="cerrar-eliminar"></div>
        <div class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl w-full max-w-md p-6" style="animation: modalIn 0.2s ease-out forwards;">
            <div class="flex items-center gap-3 mb-4">
                <div class="size-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-trash text-2xl text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Noticia</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-2">¿Confirmas que deseas eliminar permanentemente:</p>
            <p id="panel-eliminar-titulo" class="font-semibold text-gray-900 dark:text-white mb-5 italic"></p>
            <p class="text-xs text-red-600 dark:text-red-400 mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                <i class="bx bx-error-circle mr-1"></i>
                Se eliminarán también todos los archivos y medios asociados.
            </p>
            <form id="panel-form-eliminar" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3 justify-end">
                    <button type="button" data-accion="cerrar-eliminar"
                        class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="py-2 px-4 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-trash"></i> Eliminar permanentemente
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endhasanyrole

    {{-- ================================================================ --}}
    {{-- MODAL: APROBACIÓN MULTI-PASO (admin y aprobador)                --}}
    {{-- ================================================================ --}}
    @hasanyrole('admin|aprobador')
    <div id="panel-modal-aprobar" style="display:none;position:fixed;inset:0;z-index:70;align-items:center;justify-content:center;padding:1rem;">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl w-full max-w-lg" style="animation: modalIn 0.2s ease-out forwards;">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                <div class="flex items-center gap-3">
                    <div class="size-9 rounded-full bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                        <i class="bx bx-check-shield text-lg text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-base">Aprobar Publicación</h3>
                        <div class="flex gap-1 mt-0.5" id="panel-steps-dots">
                            <span class="pdot" style="width:24px;height:6px;border-radius:3px;background:#14b8a6;transition:all .3s;"></span>
                            <span class="pdot" style="width:8px;height:6px;border-radius:3px;background:#d1d5db;transition:all .3s;"></span>
                            <span class="pdot" style="width:8px;height:6px;border-radius:3px;background:#d1d5db;transition:all .3s;"></span>
                        </div>
                    </div>
                </div>
                <button type="button" data-accion="cerrar-aprobar" class="text-gray-400 hover:text-gray-600 dark:hover:text-neutral-200">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>

            <form id="panel-form-aprobar" method="POST">
                @csrf
                <div class="px-6 py-5" style="min-height:280px;">

                    {{-- PASO 1 --}}
                    <div id="panel-paso-1">
                        <div class="text-center mb-5">
                            <div style="width:64px;height:64px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                <i class="bx bx-book-reader" style="font-size:2rem;color:#3b82f6;"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg">Paso 1 de 3 — Revisión de contenido</h4>
                            <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Confirma que revisaste el contenido completo</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-neutral-900/50 border border-gray-200 dark:border-neutral-700 rounded-xl p-4 mb-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-400 mb-1">Noticia a aprobar:</p>
                            <p id="panel-aprobar-titulo" class="font-semibold text-gray-900 dark:text-white text-sm"></p>
                            <p id="panel-aprobar-resumen" class="text-xs text-gray-500 dark:text-neutral-500 mt-1"></p>
                        </div>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" id="panel-confirm-lectura"
                                class="mt-0.5 shrink-0 border-gray-300 rounded text-teal-600 focus:ring-teal-500">
                            <span class="text-sm text-gray-700 dark:text-neutral-300">
                                Confirmo que he leído y revisado el contenido completo de esta noticia y está lista para su publicación.
                            </span>
                        </label>
                    </div>

                    {{-- PASO 2 --}}
                    <div id="panel-paso-2" style="display:none;">
                        <div class="text-center mb-5">
                            <div style="width:64px;height:64px;border-radius:50%;background:#faf5ff;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                <i class="bx bx-calendar-event" style="font-size:2rem;color:#a855f7;"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg">Paso 2 de 3 — Fecha de publicación</h4>
                            <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Elige cuándo será visible esta noticia</p>
                        </div>
                        <div class="space-y-3">
                            <label id="panel-label-inm" class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer" style="border-color:#14b8a6;background:#f0fdfa;">
                                <input type="radio" name="tipo_fecha" value="inmediata" checked>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Publicar ahora mismo</p>
                                    <p class="text-xs text-gray-500">La noticia será visible de inmediato</p>
                                </div>
                                <i class="bx bx-rocket ml-auto" style="font-size:1.25rem;color:#14b8a6;"></i>
                            </label>
                            <label id="panel-label-prog" class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer" style="border-color:#d1d5db;">
                                <input type="radio" name="tipo_fecha" value="programada">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Programar fecha</p>
                                    <p class="text-xs text-gray-500">Se publicará automáticamente en la fecha elegida</p>
                                </div>
                                <i class="bx bx-time-five ml-auto" style="font-size:1.25rem;color:#a855f7;"></i>
                            </label>
                            <div id="panel-campo-fecha" style="display:none;padding:4px 4px 0;">
                                <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Fecha y hora de publicación</label>
                                <input type="datetime-local" name="fecha_programada" id="panel-input-fecha"
                                    class="py-2.5 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <p class="text-xs text-gray-400 mt-1"><i class="bx bx-info-circle"></i> La noticia no será visible hasta esa fecha y hora</p>
                            </div>
                        </div>
                    </div>

                    {{-- PASO 3 --}}
                    <div id="panel-paso-3" style="display:none;">
                        <div class="text-center mb-5">
                            <div style="width:64px;height:64px;border-radius:50%;background:#fff7ed;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                <i class="bx bx-slideshow" style="font-size:2rem;color:#f97316;"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg">Paso 3 de 3 — Carrusel principal</h4>
                            <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">¿Agregar esta noticia al carrusel de inicio?</p>
                        </div>
                        <div class="space-y-3">
                            <label id="panel-label-carrusel" class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer" style="border-color:#d1d5db;">
                                <input type="checkbox" name="montar_carrusel" value="1" id="panel-check-carrusel"
                                    class="rounded text-orange-500 focus:ring-orange-500">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Sí, agregar al carrusel</p>
                                    <p class="text-xs text-gray-500">La imagen principal aparecerá en el carrusel
                                        <span id="panel-texto-carrusel">de inmediato</span>
                                    </p>
                                </div>
                                <i class="bx bx-images ml-auto" style="font-size:1.25rem;color:#fb923c;"></i>
                            </label>
                            <div class="p-4 rounded-xl border border-gray-100 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-900/30 text-center">
                                <p class="text-xs text-gray-500 dark:text-neutral-400">
                                    <i class="bx bx-info-circle mr-1"></i>
                                    Si no marcas esta opción, la noticia se publica normalmente pero no aparece en el carrusel
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700 flex items-center justify-between">
                    <div>
                        <button type="button" id="panel-btn-ant" data-accion="paso-anterior" style="display:none;"
                            class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all inline-flex items-center gap-2">
                            <i class="bx bx-arrow-back"></i> Anterior
                        </button>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" data-accion="cerrar-aprobar"
                            class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
                            Cancelar
                        </button>
                        <button type="button" id="panel-btn-sig" data-accion="paso-siguiente" disabled
                            class="py-2 px-4 text-sm font-semibold rounded-lg bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all inline-flex items-center gap-2">
                            Siguiente <i class="bx bx-right-arrow-alt"></i>
                        </button>
                        <button type="submit" id="panel-btn-pub" style="display:none;"
                            class="py-2 px-4 text-sm font-semibold rounded-lg bg-teal-600 text-white hover:bg-teal-700 transition-all inline-flex items-center gap-2">
                            <i class="bx bx-check-circle"></i> Confirmar publicación
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endhasanyrole

@endsection

@push('page-scripts')
@vite(['resources/js/countup-indicadores.js', 'resources/js/panel-noticias.js'])
<style @cspNonce>
@keyframes modalIn {
    from { opacity:0; transform:scale(0.95) translateY(10px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
</style>
@endpush


<x-modal-confirmar />
