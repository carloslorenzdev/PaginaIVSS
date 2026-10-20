<div x-data="bannersData"
     x-on:close-modal.window="cerrarEliminar"
     x-on:keydown.escape.window="cerrarEliminar">
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-2">
            <div>
                <x-titulo titulo="Banners y Alertas" class="text-gradient font-extrabold text-3xl" />
                <p class="text-sm text-gray-500 dark:text-neutral-400 mt-2 font-medium">
                    Gestiona directamente las imágenes y alertas emergentes que se muestran en el portal principal.
                </p>
            </div>
            
            <x-breadcrumb>
                <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                    Panel
                </x-breadcrumb.item>
                <x-breadcrumb.current>
                    Banners y Alertas
                </x-breadcrumb.current>
            </x-breadcrumb>
        </div>

        {{-- FLASH MESSAGES --}}
        @if (session()->has('success'))
            <div class="bg-teal-50 border border-teal-200 text-teal-800 dark:bg-teal-900/30 dark:border-teal-800 dark:text-teal-200 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="bx bx-check-circle text-xl text-teal-600 dark:text-teal-400"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-teal-500 hover:text-teal-700">
                    <i class="bx bx-x text-lg"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- SLOT 1: ALERTA EMERGENTE (POPUP) -->
            <div class="flex flex-col bg-white border border-gray-100 shadow-sm rounded-2xl dark:bg-neutral-800 dark:border-neutral-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50">
                    <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2 text-lg">
                        <div class="size-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center">
                            <i class="bx bx-bell text-lg"></i>
                        </div>
                        Alerta Emergente (Popup)
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">
                        Se muestra al abrir la página web.
                    </p>
                </div>

                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        @if($alertaImg)
                            <div class="mb-5">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Imagen Actual:</span>
                                <div class="relative group rounded-xl overflow-hidden border border-gray-200 bg-gray-50 dark:bg-neutral-900">
                                    <img src="{{ asset('storage/' . $alertaImg) }}" alt="Alerta Emergente" class="w-full h-48 object-contain">
                                </div>
                                <div class="mt-3 text-xs bg-gray-50 dark:bg-neutral-900 p-3 rounded-lg border border-gray-100 dark:border-neutral-700">
                                    <p class="font-bold text-gray-800 dark:text-white">Título: <span class="font-normal">{{ $alertaTitulo ?? 'Sin título' }}</span></p>
                                    @if($alertaEnlace)
                                        <p class="font-bold text-gray-800 dark:text-white mt-1">Enlace: <a href="{{ $alertaEnlace }}" target="_blank" class="text-teal-600 underline font-normal">{{ $alertaEnlace }}</a></p>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <button type="button" wire:click="limpiarAlerta" wire:confirm="¿Deseas remover la alerta emergente actual?" class="w-full py-2 px-3 text-xs font-bold rounded-lg border border-red-200 text-red-600 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/30 transition-all flex items-center justify-center gap-1.5">
                                        <i class="bx bx-trash"></i> Remover Alerta Actual
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="mb-5 p-6 border-2 border-dashed border-gray-200 dark:border-neutral-700 rounded-xl text-center">
                                <i class="bx bx-bell-off text-3xl text-gray-400 mb-2"></i>
                                <p class="text-xs font-medium text-gray-500">No hay ninguna alerta activa.</p>
                            </div>
                        @endif

                        <form wire:submit="guardarAlerta" class="space-y-4 pt-4 border-t border-gray-100 dark:border-neutral-700">
                            <div>
                                <label class="block text-xs font-bold mb-1 text-gray-700 dark:text-neutral-300">Título / Descripción <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nuevoAlertaTitulo" class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-xs focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200" placeholder="Ej. Jornada de Vacunación Nacional">
                                @error('nuevoAlertaTitulo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold mb-1 text-gray-700 dark:text-neutral-300">Enlace de Destino (Opcional)</label>
                                <input type="url" wire:model="nuevoAlertaEnlace" class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-xs focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200" placeholder="https://...">
                                @error('nuevoAlertaEnlace') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold mb-1 text-gray-700 dark:text-neutral-300">
                                    {{ $alertaImg ? 'Cambiar Imagen' : 'Subir Imagen' }} <span class="text-red-500">*</span>
                                </label>
                                <input type="file" wire:model="nuevoAlertaArchivo" accept="image/*" class="w-full py-1.5 px-2 text-xs rounded-xl border border-gray-200 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-red-50 file:text-red-700">
                                @error('nuevoAlertaArchivo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" wire:loading.attr="disabled" class="w-full py-2.5 px-4 text-xs font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="guardarAlerta"><i class="bx bx-save"></i> Guardar Alerta</span>
                                <span wire:loading wire:target="guardarAlerta"><i class="bx bx-loader-alt bx-spin"></i> Guardando...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SLOT 2: CARRUSEL DE PROMOCIONES (BANNERS) -->
            <div class="col-span-1 lg:col-span-2 flex flex-col bg-white border border-gray-100 shadow-sm rounded-2xl dark:bg-neutral-800 dark:border-neutral-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2 text-lg">
                            <div class="size-8 rounded-lg bg-teal-100 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center">
                                <i class="bx bx-images text-lg"></i>
                            </div>
                            Banners Promocionales
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">
                            Imágenes que rotan en el carrusel secundario de promociones.
                        </p>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Formulario Nuevo Banner -->
                    <form wire:submit="guardarBanner" class="p-4 rounded-xl border border-gray-100 dark:border-neutral-700 bg-gray-50/60 dark:bg-neutral-900/50 grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-bold mb-1 text-gray-700 dark:text-neutral-300">Título / Nombre <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="bannerTitulo" class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-xs focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200" placeholder="Ej. Campaña Salud">
                            @error('bannerTitulo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-1 text-gray-700 dark:text-neutral-300">Enlace (Opcional)</label>
                            <input type="url" wire:model="bannerEnlace" class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-xs focus:border-teal-500 focus:ring-teal-500 dark:text-neutral-200" placeholder="https://...">
                            @error('bannerEnlace') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-1 text-gray-700 dark:text-neutral-300">Imagen (Banner) <span class="text-red-500">*</span></label>
                            <input type="file" wire:model="bannerArchivo" accept="image/*" class="w-full py-1 px-2 text-xs rounded-xl border border-gray-200 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-teal-50 file:text-teal-700">
                            @error('bannerArchivo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-full flex justify-end">
                            <button type="submit" wire:loading.attr="disabled" class="py-2 px-5 text-xs font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg transition-all inline-flex items-center gap-1.5">
                                <span wire:loading.remove wire:target="guardarBanner"><i class="bx bx-plus"></i> Añadir Banner</span>
                                <span wire:loading wire:target="guardarBanner"><i class="bx bx-loader-alt bx-spin"></i> Subiendo...</span>
                            </button>
                        </div>
                    </form>

                    <!-- Lista de Banners -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($banners as $b)
                            <div class="relative group rounded-xl border border-gray-100 dark:border-neutral-700 bg-white dark:bg-neutral-900 overflow-hidden shadow-sm hover:shadow-md transition-all" wire:key="banner-{{ $b->id }}">
                                <img src="{{ asset('storage/' . $b->ruta_imagen) }}" alt="{{ $b->titulo }}" class="w-full h-36 object-cover">
                                <div class="p-3 flex items-center justify-between">
                                    <div class="min-w-0 pr-2">
                                        <h5 class="text-xs font-bold text-gray-800 dark:text-white truncate">{{ $b->titulo }}</h5>
                                        @if($b->enlace)
                                            <a href="{{ $b->enlace }}" target="_blank" class="text-[10px] text-teal-600 hover:underline truncate block">{{ $b->enlace }}</a>
                                        @endif
                                    </div>
                                    <button type="button" @click="abrirEliminar({{ $b->id }})" wire:loading.attr="disabled" class="p-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors" title="Eliminar">
                                        <i class="bx bx-trash text-base"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full p-8 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700 rounded-xl">
                                <i class="bx bx-images text-4xl text-gray-400 mb-2"></i>
                                <p class="text-xs font-medium text-gray-500">No hay banners promocionales agregados aún.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-section>

    {{-- MODAL DELETE --}}
    <div x-show="deleteModalOpen"
         x-cloak
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrarEliminar"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 p-6 animate-modal">
            <div class="flex items-center gap-4 mb-4">
                <div class="size-12 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600">
                    <i class="bx bx-trash text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-lg">Eliminar Banner</h4>
                    <p class="text-xs text-gray-500">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-neutral-900/50 p-4 rounded-xl border border-gray-100 dark:border-neutral-700 mb-6">
                <div wire:loading.flex wire:target="confirmDeleteBanner" class="items-center justify-center py-2 text-red-600">
                    <i class="bx bx-loader-alt bx-spin text-xl"></i>
                </div>
                <div wire:loading.remove wire:target="confirmDeleteBanner">
                    <p class="text-sm text-gray-700 dark:text-neutral-300">
                        ¿Confirmas que deseas eliminar el banner: <strong class="text-gray-900 dark:text-white">"{{ $deletingTitulo ?: 'este banner' }}"</strong>?
                    </p>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" @click="cerrarEliminar" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300">Cancelar</button>
                <button type="button" wire:click="deleteBanner" wire:loading.attr="disabled" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 inline-flex items-center gap-2">
                    <span wire:loading.remove wire:target="deleteBanner">Eliminar</span>
                    <span wire:loading wire:target="deleteBanner"><i class="bx bx-loader-alt bx-spin"></i> Eliminando...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script nonce="{{ app('csp-nonce') }}">
(function() {
    function initBanners() {
        if (window.Alpine && typeof window.Alpine.data === 'function') {
            window.Alpine.data('bannersData', () => ({
                deleteModalOpen: false,
                abrirEliminar(id) {
                    this.deleteModalOpen = true;
                    if (this.$wire) this.$wire.confirmDeleteBanner(id);
                },
                cerrarEliminar() {
                    this.deleteModalOpen = false;
                }
            }));
        }
    }
    initBanners();
    document.addEventListener('alpine:init', initBanners);
    document.addEventListener('livewire:navigated', initBanners);
})();
</script>
