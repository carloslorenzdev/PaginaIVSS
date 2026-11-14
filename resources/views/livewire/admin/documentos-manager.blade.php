<div x-data="documentosData"
     x-on:close-modal.window="cerrarTodo"
     x-on:keydown.escape.window="cerrarTodo">

    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <x-titulo titulo="Documentos Institucionales" class="text-gradient font-extrabold text-3xl" />
                <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">
                    Administre, suba y organice los archivos de Marco Normativo, Contrataciones Públicas y Biblioteca de Formas.
                </p>
            </div>
            
            @can('documentos.crear')
                <button type="button"
                    @click="abrirCrear"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-red-500/20 hover:shadow-lg hover:from-red-700 hover:to-red-800 transition-all transform hover:-translate-y-0.5 disabled:opacity-50">
                    <i class="bx bx-plus text-lg" wire:loading.remove wire:target="openCreateModal"></i>
                    <i class="bx bx-loader-alt bx-spin text-lg" wire:loading wire:target="openCreateModal"></i>
                    <span>Subir Documento</span>
                </button>
            @endcan
        </div>

        {{-- FLASH MESSAGES --}}
        @if (session()->has('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="bx bx-check-circle text-xl text-emerald-600 dark:text-emerald-400"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="bx bx-x text-lg"></i>
                </button>
            </div>
        @endif

        {{-- RESUMEN / ESTADÍSTICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-gray-100 dark:bg-neutral-700 flex items-center justify-center text-gray-700 dark:text-gray-200">
                    <i class="bx bx-folder text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Total Documentos</span>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totales['total'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-red-50 dark:bg-red-950/40 flex items-center justify-center text-red-600 dark:text-red-400">
                    <i class="bx bx-balance text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Marco Normativo</span>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totales['marco'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-amber-50 dark:bg-amber-950/40 flex items-center justify-center text-amber-600 dark:text-amber-400">
                    <i class="bx bx-briefcase text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Contrataciones</span>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totales['contrataciones'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-blue-50 dark:bg-blue-950/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <i class="bx bx-file-blank text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Biblioteca de Formas</span>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totales['formas'] }}</p>
                </div>
            </div>
        </div>

        {{-- BARRA DE FILTROS --}}
        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-4 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                {{-- Búsqueda --}}
                <div class="relative">
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Buscar por título, categoría..."
                        class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                    <i class="bx bx-search absolute left-3.5 top-2.5 text-lg text-gray-400"></i>
                </div>

                {{-- Sección --}}
                <div>
                    <select wire:model.live="filtroSeccion"
                        class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                        <option value="">Todas las Secciones</option>
                        @foreach($seccionesDisponibles as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Categoría --}}
                <div>
                    <select wire:model.live="filtroCategoria"
                        class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                        <option value="">Todas las Categorías</option>
                        @foreach($categoriasDisponibles as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Estado --}}
                <div>
                    <select wire:model.live="filtroEstado"
                        class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                        <option value="">Todos los Estados</option>
                        <option value="activos">Publicados (Activos)</option>
                        <option value="inactivos">Ocultos (Inactivos)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- SKELETON PLACEHOLDERS --}}
        <div wire:loading wire:target="search, filtroSeccion, filtroCategoria, filtroEstado, gotoPage, previousPage, nextPage">
            <x-skeleton.list :count="5" />
        </div>

        {{-- TABLA DE DOCUMENTOS --}}
        <div wire:loading.remove wire:target="search, filtroSeccion, filtroCategoria, filtroEstado, gotoPage, previousPage, nextPage" class="space-y-3">
            @forelse($documentos as $item)
                <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-4 sm:p-5 hover:shadow-md transition-all duration-300 relative group" wire:key="doc-{{ $item->id }}">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                        
                        {{-- ICONO Y DETALLES DEL DOCUMENTO --}}
                        <div class="flex items-start gap-3.5 flex-grow min-w-0">
                            <div class="size-11 rounded-xl flex items-center justify-center flex-shrink-0 {{ $item->tiene_archivo ? 'bg-red-50 dark:bg-red-950/30 text-red-600' : 'bg-gray-100 dark:bg-neutral-800 text-gray-400' }}">
                                <i class="{{ $item->tiene_archivo ? $item->icono_formato : 'fas fa-file-dashed text-gray-400' }} text-2xl"></i>
                            </div>

                            <div class="min-w-0 flex-grow">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    {{-- Badge Sección --}}
                                    @php
                                        $badgeColor = match($item->seccion) {
                                            'marco_normativo' => 'bg-red-50 text-red-700 dark:bg-red-950/40 dark:text-red-300 border-red-200 dark:border-red-900',
                                            'contrataciones_publicas' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border-amber-200 dark:border-amber-900',
                                            'biblioteca_formas' => 'bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 border-blue-200 dark:border-blue-900',
                                            default => 'bg-gray-100 text-gray-700 dark:bg-neutral-800 dark:text-neutral-300 border-gray-200',
                                        };
                                        $nombreSeccion = $seccionesDisponibles[$item->seccion] ?? ucfirst(str_replace('_', ' ', $item->seccion));
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold border {{ $badgeColor }}">
                                        {{ $nombreSeccion }}
                                    </span>

                                    {{-- Badge Categoría --}}
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-600 dark:bg-neutral-800 dark:text-neutral-300">
                                        <i class="bx bx-tag-alt me-1 text-xs"></i> {{ $item->categoria }}
                                    </span>

                                    {{-- Badge Estado Archivo --}}
                                    @if($item->tiene_archivo)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300">
                                            <i class="bx bx-check-circle me-1"></i> {{ strtoupper($item->formato) }} ({{ $item->tamano_formateado }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/40 dark:border-amber-800 dark:text-amber-300">
                                            <i class="bx bx-time-five me-1"></i> Archivo pendiente por subir
                                        </span>
                                    @endif

                                    @if(!$item->activo)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/40 dark:border-rose-800 dark:text-rose-300">
                                            Oculto
                                        </span>
                                    @endif
                                </div>

                                <h4 class="font-bold text-gray-900 dark:text-white text-base leading-snug">
                                    {{ $item->titulo }}
                                </h4>

                                @if($item->descripcion)
                                    <p class="text-xs text-gray-500 dark:text-neutral-400 mt-0.5 line-clamp-1">
                                        {{ $item->descripcion }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- ACCIONES Y BOTONES --}}
                        <div class="flex items-center gap-2 flex-shrink-0 self-end lg:self-center">
                            {{-- Descargar/Ver Archivo --}}
                            @if($item->tiene_archivo)
                                <a href="{{ $item->url }}" target="_blank"
                                    title="Descargar / Ver archivo"
                                    class="size-9 rounded-xl flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-900 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-300 transition-colors shadow-sm">
                                    <i class="bx bx-download text-lg"></i>
                                </a>
                            @endif

                            {{-- Toggle Activo --}}
                            @can('documentos.editar')
                                <button type="button"
                                    wire:click="toggleActivo({{ $item->id }})"
                                    title="{{ $item->activo ? 'Ocultar documento' : 'Publicar documento' }}"
                                    class="size-9 rounded-xl flex items-center justify-center transition-colors shadow-sm {{ $item->activo ? 'bg-emerald-50 hover:bg-emerald-100 text-emerald-600 dark:bg-emerald-950/30 dark:hover:bg-emerald-900/40' : 'bg-gray-100 hover:bg-gray-200 text-gray-400 dark:bg-neutral-800 dark:hover:bg-neutral-700' }}">
                                    <i class="bx {{ $item->activo ? 'bx-show' : 'bx-hide' }} text-lg"></i>
                                </button>
                            @endcan

                            {{-- Editar --}}
                            @can('documentos.editar')
                                <button type="button"
                                    @click="abrirEditar({{ $item->id }})"
                                    wire:loading.attr="disabled"
                                    title="Editar o reemplazar archivo"
                                    class="size-9 rounded-xl flex items-center justify-center bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-950/30 dark:hover:bg-blue-900/40 dark:text-blue-400 transition-colors shadow-sm">
                                    <i class="bx bx-edit text-lg"></i>
                                </button>
                            @endcan

                            {{-- Eliminar --}}
                            @can('documentos.eliminar')
                                <button type="button"
                                    @click="abrirEliminar({{ $item->id }})"
                                    wire:loading.attr="disabled"
                                    title="Eliminar documento"
                                    class="size-9 rounded-xl flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-950/30 dark:hover:bg-red-900/40 dark:text-red-400 transition-colors shadow-sm">
                                    <i class="bx bx-trash text-lg"></i>
                                </button>
                            @endcan
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl">
                    <i class="bx bx-folder-open text-4xl text-gray-300 dark:text-neutral-600 mb-2 block"></i>
                    <h4 class="font-bold text-gray-700 dark:text-neutral-300">No se encontraron documentos</h4>
                    <p class="text-sm text-gray-400 dark:text-neutral-500 mt-1">Pruebe ajustando los filtros de búsqueda o registre un nuevo documento.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-4">
            {{ $documentos->links() }}
        </div>
    </x-section>

    {{-- MODAL CREAR / EDITAR (Oculto por defecto con display: none y x-cloak) --}}
    <div x-show="modalOpen"
         x-cloak
         style="display: none;"
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrar"></div>
        <div class="relative w-full max-w-xl rounded-2xl bg-white shadow-2xl dark:bg-neutral-800 overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 max-h-[90vh] flex flex-col">
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 px-6 py-4 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-red-50 dark:bg-red-950/40 flex items-center justify-center text-red-600 dark:text-red-400 flex-shrink-0">
                        <i class="bx {{ $editingId ? 'bx-edit' : 'bx-cloud-upload' }} text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg">
                            {{ $editingId ? 'Editar Documento' : 'Subir Nuevo Documento' }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-neutral-400">
                            Complete los campos y adjunte el archivo para la sección seleccionada.
                        </p>
                    </div>
                </div>
                <button type="button" @click="cerrar" class="size-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-neutral-700 text-gray-500 hover:bg-gray-200 hover:text-gray-700 dark:hover:bg-neutral-600 dark:text-neutral-400 transition-colors">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <form wire:submit="save" class="overflow-y-auto p-6 space-y-4 flex-grow">
                {{-- Sección --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-neutral-300 mb-1.5">
                        Sección del Portal <span class="text-red-500">*</span>
                    </label>
                    <select wire:model.live="seccion" class="w-full py-2.5 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                        @foreach($seccionesDisponibles as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('seccion') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Categoría (Selector existente o Nueva) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-neutral-300 mb-1.5">
                            Categoría Existente <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="categoria" class="w-full py-2.5 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                            <option value="">Seleccione una categoría...</option>
                            @foreach($categoriasDisponibles as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-neutral-300 mb-1.5">
                            O Nueva Categoría
                        </label>
                        <input type="text" wire:model="nuevaCategoria" placeholder="Escribir si no existe..." class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                    </div>
                </div>
                @error('categoria') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror

                {{-- Título del Documento --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-neutral-300 mb-1.5">
                        Título del Documento <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="docTitulo" placeholder="Ej. Solicitud de Prestaciones en Dinero (Forma 14-04)" class="w-full py-2.5 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                    @error('docTitulo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Descripción breve --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-neutral-300 mb-1.5">
                        Descripción (Opcional)
                    </label>
                    <textarea wire:model="descripcion" rows="2" placeholder="Detalle adicional sobre el contenido o trámite..." class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm"></textarea>
                    @error('descripcion') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Subida de Archivo --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-neutral-300 mb-1.5">
                        Archivo Adjunto (PDF, DOC, DOCX, XLS, ZIP - Máx. 50MB)
                    </label>

                    @if($currentArchivo)
                        <div class="mb-2 p-2.5 rounded-xl bg-gray-50 dark:bg-neutral-900 border border-gray-200 dark:border-neutral-700 flex items-center justify-between">
                            <div class="flex items-center gap-2 min-w-0">
                                <i class="bx bx-file text-red-600 text-lg"></i>
                                <span class="text-xs font-semibold text-gray-700 dark:text-neutral-300 truncate">
                                    {{ $currentNombreOriginal ?: basename($currentArchivo) }}
                                </span>
                            </div>
                            <span class="text-xs text-gray-400">Archivo actual</span>
                        </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-200 dark:border-neutral-700 rounded-xl p-4 text-center hover:border-red-400 transition-colors bg-gray-50/50 dark:bg-neutral-900/30">
                        <input type="file" wire:model="archivo" id="fileUpload" class="hidden">
                        <label for="fileUpload" class="cursor-pointer block">
                            <i class="bx bx-cloud-upload text-3xl text-gray-400 dark:text-neutral-500 mb-1"></i>
                            <p class="text-sm font-semibold text-gray-700 dark:text-neutral-300">
                                {{ $archivo ? $archivo->getClientOriginalName() : 'Haga clic para seleccionar archivo' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">Formatos admitidos: .pdf, .doc, .docx, .xls, .xlsx, .zip</p>
                        </label>

                        <div wire:loading wire:target="archivo" class="mt-2 text-xs text-red-600 font-semibold flex items-center justify-center gap-1.5">
                            <i class="bx bx-loader-alt bx-spin"></i> Cargando archivo...
                        </div>
                    </div>
                    @error('archivo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Orden y Estado --}}
                <div class="grid grid-cols-2 gap-3 pt-1">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-neutral-300 mb-1.5">
                            Orden de Aparición
                        </label>
                        <input type="number" wire:model="orden" min="0" class="w-full py-2 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                        @error('orden') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center pt-5">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="activo" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                            <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-neutral-300">Publicado</span>
                        </label>
                    </div>
                </div>

                {{-- Footer / Botones Modal --}}
                <div class="pt-4 border-t border-gray-100 dark:border-neutral-700 flex items-center justify-end gap-2.5">
                    <button type="button" @click="cerrar" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-5 py-2 text-sm font-bold text-white shadow-md shadow-red-500/20 hover:from-red-700 hover:to-red-800 transition-all disabled:opacity-50">
                        <i class="bx bx-loader-alt bx-spin" wire:loading wire:target="save"></i>
                        <span>{{ $editingId ? 'Guardar Cambios' : 'Registrar Documento' }}</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- MODAL ELIMINAR (Oculto por defecto con display: none y x-cloak) --}}
    <div x-show="deleteModalOpen"
         x-cloak
         style="display: none;"
         class="fixed inset-0 z-[80] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="cerrarEliminar"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl dark:bg-neutral-800 overflow-hidden border border-gray-100 dark:border-neutral-700 z-10 p-6 text-center">
            <div class="size-14 rounded-2xl bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-400 flex items-center justify-center mx-auto mb-4">
                <i class="bx bx-trash text-3xl"></i>
            </div>
            <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2">¿Eliminar Documento?</h3>
            <p class="text-sm text-gray-500 dark:text-neutral-400 mb-6">
                Está a punto de eliminar <strong class="text-gray-800 dark:text-neutral-200">"{{ $deletingTitulo }}"</strong>. Si tiene un archivo asociado, también se eliminará permanentemente del servidor.
            </p>
            <div class="flex items-center justify-center gap-3">
                <button type="button" @click="cerrarEliminar" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-colors">
                    Cancelar
                </button>
                <button type="button" wire:click="delete" wire:loading.attr="disabled" class="inline-flex items-center gap-2 rounded-xl bg-red-600 hover:bg-red-700 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-red-500/20 transition-all disabled:opacity-50">
                    <i class="bx bx-loader-alt bx-spin" wire:loading wire:target="delete"></i>
                    <span>Sí, Eliminar</span>
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPT ALPINE Y REGISTRO COMPONENTE --}}
    <script nonce="{{ app('csp-nonce') }}">
    (function() {
        function initDocumentos() {
            if (window.Alpine && typeof window.Alpine.data === 'function') {
                window.Alpine.data('documentosData', () => ({
                    modalOpen: false,
                    deleteModalOpen: false,
                    abrirCrear() {
                        this.modalOpen = true;
                        if (this.$wire) this.$wire.openCreateModal();
                    },
                    abrirEditar(id) {
                        this.modalOpen = true;
                        if (this.$wire) this.$wire.openEditModal(id);
                    },
                    cerrar() {
                        this.modalOpen = false;
                        if (this.$wire) this.$wire.closeModal();
                    },
                    abrirEliminar(id) {
                        this.deleteModalOpen = true;
                        if (this.$wire) this.$wire.confirmDelete(id);
                    },
                    cerrarEliminar() {
                        this.deleteModalOpen = false;
                        if (this.$wire) this.$wire.closeDeleteModal();
                    },
                    cerrarTodo() {
                        this.modalOpen = false;
                        this.deleteModalOpen = false;
                        if (this.$wire) {
                            this.$wire.closeModal();
                            this.$wire.closeDeleteModal();
                        }
                    }
                }));
            }
        }
        initDocumentos();
        document.addEventListener('alpine:init', initDocumentos);
        document.addEventListener('livewire:navigated', initDocumentos);
    })();
    </script>
</div>
