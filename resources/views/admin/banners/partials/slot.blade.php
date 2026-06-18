<div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
    <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800 rounded-t-xl">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
            {{ $titulo_slot }}
        </h3>
        <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">
            {{ $descripcion_slot }}
        </p>
    </div>

    <div class="p-4 md:p-5 flex-grow">
        @if($banner)
            <div class="mb-4">
                <p class="text-sm font-semibold mb-2 text-gray-800 dark:text-neutral-200">Imagen Actual:</p>
                <div class="relative rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                    <img src="{{ asset('storage/' . $banner->ruta_imagen) }}" alt="{{ $banner->titulo }}" class="w-full h-auto max-h-48 object-contain bg-gray-100">
                </div>
                <div class="mt-3">
                    <p class="text-sm"><span class="font-semibold text-gray-800 dark:text-neutral-200">Título:</span> <span class="text-gray-600 dark:text-neutral-400">{{ $banner->titulo }}</span></p>
                    @if($banner->enlace)
                        <p class="text-sm truncate"><span class="font-semibold text-gray-800 dark:text-neutral-200">Enlace:</span> <a href="{{ $banner->enlace }}" target="_blank" class="text-red-600 hover:underline">{{ $banner->enlace }}</a></p>
                    @endif
                </div>
            </div>

            <form action="{{ route('admin.banners.clearSlot', $slot_key) }}" method="POST" onsubmit="return confirm('¿Remover esta imagen? Dejará de mostrarse al público.');">
                @csrf
                <button type="submit" class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-none focus:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:bg-red-800/30 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20">
                    <i class="bx bx-trash"></i> Remover Imagen Actual
                </button>
            </form>

            <div class="my-4 flex items-center before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-neutral-500 dark:before:border-neutral-600 dark:after:border-neutral-600">
                <span class="text-sm text-gray-500 font-medium">Reemplazar</span>
            </div>
        @else
            <div class="mb-4 text-center py-6 bg-gray-50 border border-dashed border-gray-300 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                <i class="bx bx-image-alt text-4xl text-gray-400 mb-2"></i>
                <p class="text-sm text-gray-500 dark:text-neutral-400">Ninguna imagen configurada.</p>
            </div>
        @endif

        <form action="{{ route('admin.banners.updateSlot', $slot_key) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>
                <label for="titulo_{{ $slot_key }}" class="block text-sm font-medium mb-1 dark:text-white">Nombre / Referencia</label>
                <input type="text" id="titulo_{{ $slot_key }}" name="titulo" required class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
            </div>

            <div>
                <label for="enlace_{{ $slot_key }}" class="block text-sm font-medium mb-1 dark:text-white">Enlace (Opcional)</label>
                <input type="url" id="enlace_{{ $slot_key }}" name="enlace" placeholder="https://" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 dark:text-white">Subir Imagen</label>
                <input type="file" name="archivo" accept="image/*" required class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
                file:bg-gray-50 file:border-0
                file:me-4
                file:py-2 file:px-4
                dark:file:bg-neutral-700 dark:file:text-neutral-400">
            </div>

            <button type="submit" class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                <i class="bx bx-upload"></i> {{ $banner ? 'Subir y Reemplazar' : 'Subir Imagen' }}
            </button>
        </form>
    </div>
</div>
