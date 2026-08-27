@forelse ($noticias as $noticia)
    <x-card class="relative p-5 glass table-row-hover text-gray-800 dark:text-neutral-200 transition-all duration-300 rounded-xl mb-3 border-l-4" style="border-left-color: {{ $noticia->publicado ? '#14b8a6' : '#f59e0b' }}">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            {{-- TÍTULO --}}
            <div class="col-span-full lg:col-span-2">
                <div class="flex flex-col items-start gap-1">
                    <a href="{{ route('admin.noticias.ver', $noticia->id) }}" class="hover:text-blue-600 dark:hover:text-blue-400 truncate max-w-xs transition-colors duration-200">
                        <p class="block font-bold text-lg truncate">{{ $noticia->titulo }}</p>
                    </a>
                    @if($noticia->resumen)
                        <small class="block text-gray-500 dark:text-neutral-400 truncate max-w-xs mt-0.5">
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
                    @if($noticia->fecha_publicacion && $noticia->fecha_publicacion->isFuture())
                        <x-badge color="purple"><i class="bx bx-calendar-event"></i> Programada ({{ $noticia->fecha_publicacion->diffForHumans() }})</x-badge>
                    @else
                        <x-badge color="teal"><i class="bx bx-check"></i> Publicada</x-badge>
                    @endif
                @else
                    <x-badge color="yellow"><i class="bx bx-time"></i> Borrador</x-badge>
                @endif
            </div>
            {{-- AUTOR --}}
            <div class="md:col-span-1 lg:col-span-1">
                <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">Autor</p>
                <p class="text-sm">{{ $noticia->autor?->nombre ?? 'â€”' }}</p>
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
                class="py-1.5 px-2.5 inline-flex items-center justify-center size-8 rounded-full border border-gray-200 bg-white/50 text-gray-800 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 dark:bg-neutral-800/50 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:hover:text-blue-400 transition-all shadow-sm hover:shadow"
                title="Ver detalle">
                <i class="bx bx-edit text-sm"></i>
            </a>

            {{-- PUBLICAR / DESPUBLICAR --}}
            @can('noticias.publicar')
                @if($noticia->publicado)
                      <button type="button"
                          class="btn-confirmar-accion py-1.5 px-2.5 inline-flex items-center justify-center size-8 rounded-full border border-yellow-200 bg-yellow-50/50 text-yellow-700 hover:bg-yellow-100 hover:text-yellow-800 hover:border-yellow-300 dark:bg-yellow-900/10 dark:border-yellow-800/50 dark:text-yellow-500 dark:hover:bg-yellow-900/30 transition-all inline shadow-sm hover:shadow"
                          data-action="{{ route('admin.noticias.publicar', $noticia->id) }}"
                          data-method="POST"
                          data-mensaje="¿Deseas regresar esta noticia a borrador?"
                          title="Despublicar">
                          <i class="bx bx-hide text-sm"></i>
                      </button>
                @else
                    <button type="button"
                        data-accion="aprobar"
                        data-id="{{ $noticia->id }}"
                        data-titulo="{{ addslashes($noticia->titulo) }}"
                        data-resumen="{{ addslashes($noticia->resumen ?? '') }}"
                        class="py-1.5 px-2.5 inline-flex items-center justify-center size-8 rounded-full border border-teal-200 bg-teal-50/50 text-teal-700 hover:bg-teal-100 hover:text-teal-800 hover:border-teal-300 dark:bg-teal-900/10 dark:border-teal-800/50 dark:text-teal-500 dark:hover:bg-teal-900/30 transition-all shadow-sm hover:shadow"
                        title="Aprobar y publicar">
                        <i class="bx bx-show text-sm"></i>
                    </button>
                @endif
            @endcan

            {{-- ELIMINAR (solo admin) --}}
            @can('noticias.eliminar')
                <button type="button"
                    data-accion="eliminar"
                    data-id="{{ $noticia->id }}"
                    data-titulo="{{ addslashes($noticia->titulo) }}"
                    class="py-1.5 px-2.5 inline-flex items-center justify-center size-8 rounded-full border border-red-200 bg-red-50/50 text-red-700 hover:bg-red-100 hover:text-red-800 hover:border-red-300 dark:bg-red-900/10 dark:border-red-800/50 dark:text-red-500 dark:hover:bg-red-900/30 transition-all shadow-sm hover:shadow"
                    title="Eliminar noticia">
                    <i class="bx bx-trash text-sm"></i>
                </button>
            @endcan
        </div>
    </x-card>
@empty
    <x-empty />
@endforelse
