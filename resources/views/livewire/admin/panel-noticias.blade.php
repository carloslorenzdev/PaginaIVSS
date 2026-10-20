<div x-data="panelNoticiasData"
     x-on:close-modal.window="cerrarTodo"
     x-on:keydown.escape.window="cerrarTodo">
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
            <div>
                <x-titulo titulo="Panel Principal" class="text-gradient font-extrabold text-3xl" />
                <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Resumen general y administración del portal</p>
            </div>
            @can('noticias.crear')
                <x-button.link href="{{ route('admin.noticias.crear') }}"
                    class="rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white hover:from-red-700 hover:to-red-600 shadow-md hover:shadow-lg shadow-red-500/30 hover:-translate-y-0.5 transition-all duration-300 font-semibold px-5 py-2.5 flex items-center gap-2">
                    <i class="bx bx-plus-circle text-lg"></i>
                    <span>Nueva Noticia</span>
                </x-button.link>
            @endcan
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

        {{-- INDICADORES KPI --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-neutral-800 rounded-2xl p-5 border border-gray-100 dark:border-neutral-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider">Publicadas</p>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ number_format($publicadas) }}</h3>
                    </div>
                    <div class="size-12 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center text-2xl">
                        <i class="bx bx-check-double"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-2xl p-5 border border-gray-100 dark:border-neutral-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider">Visitas Hoy</p>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ number_format($visitasHoy) }}</h3>
                    </div>
                    <div class="size-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl">
                        <i class="bx bx-line-chart"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-2xl p-5 border border-gray-100 dark:border-neutral-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider">Visitas Mes</p>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ number_format($visitasMes) }}</h3>
                    </div>
                    <div class="size-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center text-2xl">
                        <i class="bx bx-calendar"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-2xl p-5 border border-gray-100 dark:border-neutral-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider">Total Visitas</p>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ number_format($visitasTotales) }}</h3>
                    </div>
                    <div class="size-12 rounded-xl bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center text-2xl">
                        <i class="bx bx-globe"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- BÚSQUEDA Y FILTROS --}}
        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-4 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="relative w-full md:w-2/3">
                <input type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar noticias por título, resumen o categoría..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200">
                <i class="bx bx-search absolute left-3.5 top-3 text-lg text-gray-400"></i>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <button type="button" wire:click="$set('filtroEstado', 'todos')"
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $filtroEstado === 'todos' ? 'bg-red-600 text-white shadow-md shadow-red-500/30' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-neutral-300 hover:bg-gray-200' }}">
                    Todas
                </button>
                <button type="button" wire:click="$set('filtroEstado', 'publicadas')"
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $filtroEstado === 'publicadas' ? 'bg-green-600 text-white shadow-md shadow-green-500/30' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-neutral-300 hover:bg-gray-200' }}">
                    Publicadas
                </button>
                <button type="button" wire:click="$set('filtroEstado', 'borradores')"
                    class="px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $filtroEstado === 'borradores' ? 'bg-yellow-600 text-white shadow-md shadow-yellow-500/30' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-neutral-300 hover:bg-gray-200' }}">
                    Borradores
                </button>
            </div>
        </div>

        {{-- TABLA DE NOTICIAS --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                    <thead class="bg-gray-50/75 dark:bg-neutral-800/75 text-xs font-bold text-gray-500 dark:text-neutral-400 uppercase tracking-wider text-left">
                        <tr>
                            <th class="px-6 py-4">Noticia</th>
                            <th class="px-6 py-4">Categoría</th>
                            <th class="px-6 py-4">Autor</th>
                            <th class="px-6 py-4">Estado</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-700/60 text-sm">
                        @forelse($noticias as $noticia)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-neutral-700/40 transition-colors" wire:key="noticia-{{ $noticia->id }}">
                                <td class="px-6 py-4">
                                    <div class="max-w-md">
                                        <h4 class="font-bold text-gray-900 dark:text-white line-clamp-1 hover:text-red-600 transition-colors">
                                            {{ $noticia->titulo }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-neutral-400 line-clamp-1 mt-0.5">
                                            {{ $noticia->resumen ?? 'Sin resumen' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Categorías Asignadas a la Noticia --}}
                                    <div class="flex flex-wrap gap-1 max-w-[200px]">
                                        @forelse($noticia->categorias as $cat)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 border border-red-100 dark:border-red-900/30">
                                                {{ $cat->nombre }}
                                            </span>
                                        @empty
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium text-gray-400 dark:text-neutral-500 italic">
                                                Sin categoría
                                            </span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 dark:text-neutral-300">
                                    {{ $noticia->autor->name ?? 'Sistema' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($noticia->publicado)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <span class="size-1.5 rounded-full bg-green-600"></span> Publicada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            <span class="size-1.5 rounded-full bg-yellow-600"></span> Borrador
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.noticias.ver', $noticia->id) }}"
                                            class="p-2 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-neutral-700 transition-colors"
                                            title="Ver / Editar Noticia">
                                            <i class="bx bx-edit text-lg"></i>
                                        </a>

                                        @can('noticias.publicar')
                                            @if($noticia->publicado)
                                                <button type="button"
                                                    wire:click="despublicar({{ $noticia->id }})"
                                                    wire:loading.attr="disabled"
                                                    class="p-2 rounded-lg text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 dark:hover:bg-neutral-700 transition-colors"
                                                    title="Mover a Borrador">
                                                    <i class="bx bx-hide text-lg" wire:loading.remove wire:target="despublicar({{ $noticia->id }})"></i>
                                                    <i class="bx bx-loader-alt bx-spin text-lg text-yellow-600" wire:loading wire:target="despublicar({{ $noticia->id }})"></i>
                                                </button>
                                            @else
                                                <button type="button"
                                                    @click="abrirAprobarModal({{ $noticia->id }})"
                                                    wire:loading.attr="disabled"
                                                    class="p-2 rounded-lg text-gray-500 hover:text-green-600 hover:bg-green-50 dark:hover:bg-neutral-700 transition-colors"
                                                    title="Publicar Noticia">
                                                    <i class="bx bx-check-circle text-lg" wire:loading.remove wire:target="abrirAprobar({{ $noticia->id }})"></i>
                                                    <i class="bx bx-loader-alt bx-spin text-lg text-green-600" wire:loading wire:target="abrirAprobar({{ $noticia->id }})"></i>
                                                </button>
                                            @endif
                                        @endcan

                                        @can('noticias.eliminar')
                                            <button type="button"
                                                @click="abrirEliminarModal({{ $noticia->id }})"
                                                wire:loading.attr="disabled"
                                                class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-neutral-700 transition-colors"
                                                title="Eliminar Noticia">
                                                <i class="bx bx-trash text-lg" wire:loading.remove wire:target="confirmDelete({{ $noticia->id }})"></i>
                                                <i class="bx bx-loader-alt bx-spin text-lg text-red-600" wire:loading wire:target="confirmDelete({{ $noticia->id }})"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-neutral-400">
                                    <i class="bx bx-news text-4xl mb-2 text-gray-300"></i>
                                    <p class="font-medium text-sm">No se encontraron noticias con los criterios especificados.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-5 border-t border-gray-100 dark:border-neutral-700">
                {{ $noticias->links() }}
            </div>
        </div>
    </x-section>
    
    {{-- MODAL APROBACIÓN MULTI-PASO (WIZARD FLUIDO 100% EN CLIENTE) --}}
    <div x-show="aprobarModalOpen"
         x-cloak
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity" 
             @click="cerrarAprobarModal"></div>

        <div class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 animate-modal">
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                <div class="flex items-center gap-3">
                    <div class="size-9 rounded-full bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                        <i class="bx bx-check-shield text-lg text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-base">Aprobar Publicación</h3>
                        {{-- Indicador de Pasos --}}
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="h-1.5 rounded-full transition-all duration-300" 
                                  :class="pasoClass(1)"></span>
                            <span class="h-1.5 rounded-full transition-all duration-300" 
                                  :class="pasoClass(2)"></span>
                            <span class="h-1.5 rounded-full transition-all duration-300" 
                                  :class="pasoClass(3)"></span>
                        </div>
                    </div>
                </div>
                <button type="button" 
                        @click="cerrarAprobarModal" 
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-neutral-200">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>

            {{-- SPINNER AL CARGAR DATOS DE LA NOTICIA --}}
            <div wire:loading.flex wire:target="abrirAprobar" class="items-center justify-center p-12">
                <div class="flex flex-col items-center gap-3">
                    <i class="bx bx-loader-alt bx-spin text-3xl text-teal-600"></i>
                    <span class="text-xs text-gray-500 font-medium">Cargando noticia...</span>
                </div>
            </div>

            <div wire:loading.remove wire:target="abrirAprobar">
                <div class="p-6">
                    {{-- PASO 1: Confirmación de Lectura --}}
                    <div x-show="pasoActual === 1" class="space-y-4">
                        <p class="text-xs font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wider">Paso 1 de 3 &mdash; Verificación de Contenido</p>
                        <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl p-4 border border-gray-200 dark:border-neutral-700">
                            <p class="text-xs text-gray-500 mb-1">Título de la noticia:</p>
                            <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $aprobarTitulo }}</p>
                            @if($aprobarResumen)
                                <p class="text-xs text-gray-600 dark:text-neutral-300 mt-2 italic">{{ $aprobarResumen }}</p>
                            @endif
                        </div>
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 dark:border-neutral-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-neutral-700/50">
                            <input type="checkbox" x-model="confirmLectura" class="mt-0.5 rounded text-teal-600 focus:ring-teal-500">
                            <span class="text-xs text-gray-700 dark:text-neutral-300 font-medium">
                                Confirmo que he leído y verificado la noticia, asegurando que cumple con los lineamientos editoriales institucionales.
                            </span>
                        </label>
                    </div>

                    {{-- PASO 2: Programación de Fecha --}}
                    <div x-show="pasoActual === 2" class="space-y-4" style="display: none;">
                        <p class="text-xs font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wider">Paso 2 de 3 &mdash; Momento de Publicación</p>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-3.5 rounded-xl border cursor-pointer border-gray-200 dark:border-neutral-700" 
                                   :class="tipoFecha === 'inmediata' ? 'border-teal-500 bg-teal-50/50 dark:bg-teal-900/20' : ''">
                                <input type="radio" x-model="tipoFecha" value="inmediata" class="text-teal-600 focus:ring-teal-500">
                                <div>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white">Publicar Inmediatamente</p>
                                    <p class="text-[11px] text-gray-500">La noticia estará visible en el portal ahora mismo.</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-3.5 rounded-xl border cursor-pointer border-gray-200 dark:border-neutral-700" 
                                   :class="tipoFecha === 'programada' ? 'border-teal-500 bg-teal-50/50 dark:bg-teal-900/20' : ''">
                                <input type="radio" x-model="tipoFecha" value="programada" class="text-teal-600 focus:ring-teal-500">
                                <div>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white">Programar Publicación</p>
                                    <p class="text-[11px] text-gray-500">Se publicará automáticamente en la fecha indicada.</p>
                                </div>
                            </label>

                            <div x-show="tipoFecha === 'programada'" class="pt-2" style="display: none;">
                                <label class="block text-xs font-bold text-gray-700 dark:text-neutral-300 mb-1">Fecha y Hora Programada</label>
                                <input type="datetime-local" x-model="fechaProgramada" class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 text-xs dark:bg-neutral-900 dark:text-white">
                            </div>
                        </div>
                    </div>

                    {{-- PASO 3: Opciones de Destacado y Confirmación --}}
                    <div x-show="pasoActual === 3" class="space-y-4" style="display: none;">
                        <p class="text-xs font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wider">Paso 3 de 3 &mdash; Opciones Adicionales</p>
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-gray-200 dark:border-neutral-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-neutral-700/50">
                            <input type="checkbox" x-model="montarCarrusel" class="mt-0.5 rounded text-teal-600 focus:ring-teal-500">
                            <div>
                                <p class="text-xs font-bold text-gray-900 dark:text-white">Destacar en el Carrusel Principal</p>
                                <p class="text-[11px] text-gray-500">Muestra la portada de esta noticia en la rotación del banner principal del portal.</p>
                            </div>
                        </label>
                        <div class="p-3 bg-teal-50 dark:bg-teal-900/20 border border-teal-100 dark:border-teal-800 rounded-xl text-xs text-teal-800 dark:text-teal-300">
                            <i class="bx bx-info-circle mr-1"></i> Todo listo para confirmar la publicación. Haz clic en "Confirmar Publicación" para finalizar.
                        </div>
                    </div>
                </div>

                {{-- Footer con Botones de Navegación del Wizard --}}
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-900/50">
                    <div>
                        <button type="button" 
                                x-show="pasoActual > 1" 
                                @click="irPaso(pasoActual - 1)" 
                                class="py-2 px-3 text-xs font-bold rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50"
                                style="display: none;">
                            <i class="bx bx-left-arrow-alt"></i> Anterior
                        </button>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" 
                                @click="cerrarAprobarModal" 
                                class="py-2 px-4 text-xs font-bold rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </button>

                        {{-- Botón Siguiente en Paso 1 --}}
                        <button type="button" 
                                x-show="pasoActual === 1" 
                                @click="irPaso(2)" 
                                :disabled="!confirmLectura" 
                                class="py-2 px-4 text-xs font-bold rounded-lg bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-40 disabled:cursor-not-allowed">
                            Siguiente <i class="bx bx-right-arrow-alt"></i>
                        </button>

                        {{-- Botón Siguiente en Paso 2 --}}
                        <button type="button" 
                                x-show="pasoActual === 2" 
                                @click="irPaso(3)" 
                                class="py-2 px-4 text-xs font-bold rounded-lg bg-teal-600 text-white hover:bg-teal-700"
                                style="display: none;">
                            Siguiente <i class="bx bx-right-arrow-alt"></i>
                        </button>

                        {{-- Botón Confirmar en Paso 3 --}}
                        <button type="button" 
                                x-show="pasoActual === 3" 
                                @click="confirmarPublicar" 
                                wire:loading.attr="disabled" 
                                class="py-2 px-5 text-xs font-bold rounded-lg bg-teal-600 text-white hover:bg-teal-700 shadow-md shadow-teal-500/30 disabled:opacity-50 inline-flex items-center gap-2"
                                style="display: none;">
                            <span wire:loading.remove wire:target="confirmarPublicacion">
                                <i class="bx bx-check-circle"></i> Confirmar Publicación
                            </span>
                            <span wire:loading wire:target="confirmarPublicacion">
                                <i class="bx bx-loader-alt bx-spin"></i> Publicando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL ELIMINAR (INSTANTÁNEO) --}}
    <div x-show="deleteModalOpen"
         x-cloak
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
             @click="cerrarEliminarModal"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 p-6 animate-modal">
            <div class="flex items-center gap-4 mb-4">
                <div class="size-12 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600">
                    <i class="bx bx-trash text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-lg">Eliminar Noticia</h4>
                    <p class="text-xs text-gray-500">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-neutral-900/50 p-4 rounded-xl border border-gray-100 dark:border-neutral-700 mb-4">
                <div wire:loading.flex wire:target="confirmDelete" class="items-center justify-center py-2">
                    <i class="bx bx-loader-alt bx-spin text-2xl text-red-600"></i>
                </div>
                <div wire:loading.remove wire:target="confirmDelete">
                    <p class="text-xs text-gray-600 dark:text-neutral-400 mb-1">¿Confirmas que deseas eliminar permanentemente la noticia:</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white italic">"{{ $deletingTitulo ?: 'esta noticia' }}"</p>
                </div>
            </div>
            <p class="text-xs text-red-600 dark:text-red-400 mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-2.5">
                <i class="bx bx-error-circle mr-1"></i> Se eliminarán también todos los archivos multimedia asociados.
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" 
                        @click="cerrarEliminarModal" 
                        class="py-2 px-4 text-xs font-bold rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="button" 
                        @click="confirmarEliminar" 
                        wire:loading.attr="disabled" 
                        class="py-2 px-4 text-xs font-bold rounded-xl bg-red-600 text-white hover:bg-red-700 shadow-md shadow-red-500/30 disabled:opacity-50 inline-flex items-center gap-2">
                    <span wire:loading.remove wire:target="delete">Eliminar permanentemente</span>
                    <span wire:loading wire:target="delete"><i class="bx bx-loader-alt bx-spin"></i> Eliminando...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPT ALPINE Y ESTILOS CON NONCE CSP --}}
    <script nonce="{{ app('csp-nonce') }}">
    (function() {
        function registrarPanelNoticias() {
            if (window.Alpine && typeof window.Alpine.data === 'function') {
                window.Alpine.data('panelNoticiasData', () => ({
                    aprobarModalOpen: false,
                    deleteModalOpen: false,
                    pasoActual: 1,
                    confirmLectura: false,
                    tipoFecha: 'inmediata',
                    fechaProgramada: '',
                    montarCarrusel: false,
                    aprobarId: null,

                    abrirAprobarModal(id) {
                        this.aprobarId = id;
                        this.pasoActual = 1;
                        this.confirmLectura = false;
                        this.tipoFecha = 'inmediata';
                        this.fechaProgramada = '';
                        this.montarCarrusel = false;
                        this.aprobarModalOpen = true;
                        if (this.$wire) {
                            this.$wire.abrirAprobar(id);
                        }
                    },

                    cerrarAprobarModal() {
                        this.aprobarModalOpen = false;
                        this.pasoActual = 1;
                        if (this.$wire) {
                            this.$wire.cerrarAprobar();
                        }
                    },

                    irPaso(num) {
                        this.pasoActual = num;
                    },

                    pasoClass(paso) {
                        if (this.pasoActual === paso) return 'w-6 bg-teal-500';
                        if (this.pasoActual > paso) return 'w-2 bg-teal-500';
                        return 'w-2 bg-gray-300 dark:bg-neutral-600';
                    },

                    confirmarPublicar() {
                        this.aprobarModalOpen = false;
                        if (this.$wire) {
                            this.$wire.confirmarPublicacion(this.montarCarrusel, this.tipoFecha, this.fechaProgramada || null, this.aprobarId);
                        }
                    },

                    abrirEliminarModal(id) {
                        this.deleteModalOpen = true;
                        if (this.$wire) {
                            this.$wire.confirmDelete(id);
                        }
                    },

                    cerrarEliminarModal() {
                        this.deleteModalOpen = false;
                        if (this.$wire) {
                            this.$wire.closeDeleteModal();
                        }
                    },

                    confirmarEliminar() {
                        this.deleteModalOpen = false;
                        if (this.$wire) {
                            this.$wire.delete();
                        }
                    },

                    cerrarTodo() {
                        this.aprobarModalOpen = false;
                        this.deleteModalOpen = false;
                        this.pasoActual = 1;
                        this.confirmLectura = false;
                        this.tipoFecha = 'inmediata';
                        this.fechaProgramada = '';
                        this.montarCarrusel = false;
                    }
                }));
            }
        }

        registrarPanelNoticias();
        document.addEventListener('alpine:init', registrarPanelNoticias);
        document.addEventListener('livewire:navigated', registrarPanelNoticias);
    })();
    </script>
</div>
