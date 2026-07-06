@forelse ($noticias as $noticia)
    <x-card class="relative p-5 hover:bg-gray-100/50 dark:hover:bg-neutral-700/50 text-gray-800 dark:text-neutral-200">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            {{-- TÍTULO --}}
            <div class="col-span-full lg:col-span-2">
                <div class="flex flex-col items-start gap-1">
                    <a href="{{ route('admin.noticias.ver', $noticia->id) }}" class="hover:underline truncate max-w-xs">
                        <p class="block font-medium truncate">{{ $noticia->titulo }}</p>
                    </a>
                    @if($noticia->resumen)
                        <small class="block text-gray-500 dark:text-neutral-500 truncate max-w-xs">
                            {{ $noticia->resumen }}
                        </small>
                    @endif
                    <div class="flex flex-wrap gap-1 mt-1">
                        @foreach($noticia->categorias->take(2) as $cat)
                            <x-badge color="blue">{{ $cat->nombre }}</x-badge>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- ESTADO --}}
            <div class="md:col-span-1 lg:col-span-1">
                <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">Estado</p>
                @if($noticia->publicado)
                    <x-badge color="teal"><i class="bx bx-check"></i> Publicada</x-badge>
                @else
                    <x-badge color="yellow"><i class="bx bx-time"></i> Borrador</x-badge>
                @endif
            </div>
            {{-- AUTOR --}}
            <div class="md:col-span-1 lg:col-span-1">
                <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">Autor</p>
                <p class="text-sm">{{ $noticia->autor?->nombre ?? '—' }}</p>
            </div>
            {{-- FECHA --}}
            <div class="md:col-span-1 lg:col-span-1">
                <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">Fecha</p>
                <p class="text-sm">{{ $noticia->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        {{-- ACCIONES --}}
        <div class="absolute top-5 right-5 flex gap-2">
            {{-- Ver / Editar --}}
            <a href="{{ route('admin.noticias.ver', $noticia->id) }}"
                class="py-1.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-600 transition-all"
                title="Ver detalle">
                <i class="bx bx-edit"></i>
            </a>

            {{-- PUBLICAR / DESPUBLICAR --}}
            @hasanyrole('admin|aprobador')
                @if($noticia->publicado)
                      <button type="button"
                          class="btn-confirmar-accion py-1.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 hover:bg-yellow-100 dark:bg-yellow-900/20 dark:border-yellow-800 dark:text-yellow-400 transition-all inline"
                          data-action="{{ route('admin.noticias.publicar', $noticia->id) }}"
                          data-method="POST"
                          data-mensaje="¿Deseas regresar esta noticia a borrador?"
                          title="Despublicar">
                          <i class="bx bx-hide"></i>
                      </button>
                @else
                    <button type="button"
                        data-accion="aprobar"
                        data-id="{{ $noticia->id }}"
                        data-titulo="{{ addslashes($noticia->titulo) }}"
                        data-resumen="{{ addslashes($noticia->resumen ?? '') }}"
                        class="py-1.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-lg border border-teal-200 bg-teal-50 text-teal-700 hover:bg-teal-100 dark:bg-teal-900/20 dark:border-teal-800 dark:text-teal-400 transition-all"
                        title="Aprobar y publicar">
                        <i class="bx bx-show"></i>
                    </button>
                @endif
            @endhasanyrole

            {{-- ELIMINAR (solo admin) --}}
            @hasanyrole('admin')
                <button type="button"
                    data-accion="eliminar"
                    data-id="{{ $noticia->id }}"
                    data-titulo="{{ addslashes($noticia->titulo) }}"
                    class="py-1.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-lg border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400 transition-all"
                    title="Eliminar noticia">
                    <i class="bx bx-trash"></i>
                </button>
            @endhasanyrole
        </div>
    </x-card>
@empty
    <x-empty />
@endforelse
