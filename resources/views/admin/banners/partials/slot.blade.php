<div class="flex flex-col bg-white border border-gray-100 shadow-sm rounded-2xl dark:bg-neutral-800 dark:border-neutral-700 overflow-hidden h-full">
    <div class="p-5 border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50">
        <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2 text-lg">
            <div class="size-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center">
                <i class="bx bx-image text-lg"></i>
            </div>
            {{ $titulo_slot }}
        </h3>
        <p class="text-sm text-gray-500 dark:text-neutral-400 mt-2 ml-10">
            {{ $descripcion_slot }}
        </p>
    </div>

    <div class="p-6 flex-grow flex flex-col justify-between">
        <div>
            @if($banner)
                <div class="mb-5">
                    <p class="text-sm font-semibold mb-3 text-gray-800 dark:text-neutral-200 uppercase tracking-wider text-[11px]">Imagen Actual</p>
                    <div class="relative rounded-xl overflow-hidden border border-gray-100 dark:border-neutral-700 shadow-inner bg-gray-50 dark:bg-neutral-900/50 flex justify-center items-center h-48 p-2">
                        <img src="{{ asset('storage/' . $banner->ruta_imagen) }}" alt="{{ $banner->titulo }}" class="w-full h-auto max-h-44 object-contain drop-shadow-md rounded">
                    </div>
                    <div class="mt-4 bg-gray-50 dark:bg-neutral-900/30 rounded-xl p-4 border border-gray-100 dark:border-neutral-700/50">
                        <p class="text-sm mb-1"><span class="font-bold text-gray-800 dark:text-neutral-200">Título:</span> <span class="text-gray-600 dark:text-neutral-400 font-medium">{{ $banner->titulo }}</span></p>
                        @if($banner->enlace)
                            <p class="text-sm truncate"><span class="font-bold text-gray-800 dark:text-neutral-200">Enlace:</span> <a href="{{ $banner->enlace }}" target="_blank" class="text-red-600 hover:text-red-700 dark:text-red-400 hover:underline font-medium ml-1"><i class="bx bx-link-external"></i> {{ $banner->enlace }}</a></p>
                        @endif
                    </div>
                </div>

                <button type="button" class="btn-confirmar-accion w-full py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40 transition-colors" data-action="{{ route('admin.banners.clearSlot', $slot_key) }}" data-method="POST" data-mensaje="¿Remover esta imagen? Dejará de mostrarse al público.">
                    <i class="bx bx-trash text-lg"></i> Remover Imagen Actual
                </button>

                <div class="my-6 flex items-center before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:before:border-neutral-700 dark:after:border-neutral-700">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500">Reemplazar</span>
                </div>
            @else
                <div class="mb-6 text-center py-10 bg-gray-50/50 dark:bg-neutral-900/20 border-2 border-dashed border-gray-200 dark:border-neutral-700 rounded-2xl">
                    <div class="size-16 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4 shadow-sm">
                        <i class="bx bx-image-alt text-3xl text-gray-400 dark:text-neutral-500"></i>
                    </div>
                    <h4 class="text-gray-800 dark:text-neutral-200 font-bold mb-1">Sin imagen</h4>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Configura una imagen para este espacio.</p>
                </div>
            @endif
        </div>

        <form action="{{ route('admin.banners.updateSlot', $slot_key) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-gray-50/50 dark:bg-neutral-900/20 p-5 rounded-xl border border-gray-100 dark:border-neutral-700/50">
            @csrf
            
            <div>
                <label for="titulo_{{ $slot_key }}" class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Nombre / Referencia</label>
                <input type="text" id="titulo_{{ $slot_key }}" name="titulo" required class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
            </div>

            <div>
                <label for="enlace_{{ $slot_key }}" class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Enlace (Opcional)</label>
                <input type="url" id="enlace_{{ $slot_key }}" name="enlace" placeholder="https://" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Subir Imagen</label>
                <input type="file" name="archivo" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 file:transition-colors dark:file:bg-red-900/30 dark:file:text-red-400 dark:hover:file:bg-red-900/50">
            </div>

            <button type="submit" class="w-full mt-4 py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white hover:from-red-700 hover:to-red-600 shadow-md hover:shadow-lg shadow-red-500/30 transition-all">
                <i class="bx bx-upload text-lg"></i> {{ $banner ? 'Subir y Reemplazar' : 'Subir Imagen' }}
            </button>
        </form>
    </div>
</div>
