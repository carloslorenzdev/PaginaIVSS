<div>
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        {{-- ENCABEZADO --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <x-titulo titulo="Documentos Institucionales" class="text-gradient font-extrabold text-3xl" />
                <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">
                    Catálogo oficial: Marco Normativo, Contrataciones Públicas y Biblioteca de Formas. Suba o descargue el archivo correspondiente a cada documento sin complicaciones.
                </p>
            </div>
        </div>

        {{-- MENSAJES FLASH --}}
        @if (session()->has('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-2.5">
                    <i class="bx bx-check-circle text-xl text-emerald-600 dark:text-emerald-400"></i>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="bx bx-x text-lg"></i>
                </button>
            </div>
        @endif

        {{-- RESUMEN / ESTADÍSTICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-gray-100 dark:bg-neutral-700 flex items-center justify-center text-gray-700 dark:text-gray-200 flex-shrink-0">
                    <i class="bx bx-folder text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Total Documentos</span>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totales['total'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
                    <i class="bx bx-check-circle text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Archivos Subidos</span>
                    <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">{{ $totales['subidos'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-amber-50 dark:bg-amber-950/40 flex items-center justify-center text-amber-600 dark:text-amber-400 flex-shrink-0">
                    <i class="bx bx-time-five text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Pendientes por Subir</span>
                    <p class="text-xl font-bold text-amber-600 dark:text-amber-400">{{ $totales['pendientes'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-blue-50 dark:bg-blue-950/40 flex items-center justify-center text-blue-600 dark:text-blue-400 flex-shrink-0">
                    <i class="bx bx-layer text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Secciones</span>
                    <p class="text-xs text-gray-700 dark:text-neutral-300 font-bold mt-0.5 truncate">
                        M: {{ $totales['marco'] }} | C: {{ $totales['contrataciones'] }} | F: {{ $totales['formas'] }}
                    </p>
                </div>
            </div>
        </div>

        {{-- BARRA DE FILTROS --}}
        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-4 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                {{-- Búsqueda por nombre o categoría --}}
                <div class="relative">
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Buscar documento por título..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                    <i class="bx bx-search absolute left-3.5 top-3 text-lg text-gray-400"></i>
                </div>

                {{-- Filtro por Sección --}}
                <div>
                    <select wire:model.live="filtroSeccion"
                        class="w-full py-2.5 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                        <option value="">Todas las Secciones (36)</option>
                        @foreach($seccionesDisponibles as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtro por Estado de Carga --}}
                <div>
                    <select wire:model.live="filtroEstado"
                        class="w-full py-2.5 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200 shadow-sm">
                        <option value="">Todos los Estados</option>
                        <option value="subidos">Subidos (Con archivo disponible)</option>
                        <option value="pendientes">Pendientes (Sin archivo)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- SKELETON LOADING --}}
        <div wire:loading wire:target="search, filtroSeccion, filtroEstado, gotoPage, previousPage, nextPage">
            <x-skeleton.list :count="5" />
        </div>

        {{-- LISTA DE DOCUMENTOS --}}
        <div wire:loading.remove wire:target="search, filtroSeccion, filtroEstado, gotoPage, previousPage, nextPage" class="space-y-3">
            @forelse($documentos as $item)
                <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-4 sm:p-5 hover:shadow-md transition-all duration-300 relative group"
                     wire:key="doc-row-{{ $item->id }}">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        
                        {{-- DETALLES DEL DOCUMENTO --}}
                        <div class="flex items-start gap-3.5 flex-grow min-w-0">
                            {{-- Icono de formato --}}
                            <div class="size-11 rounded-xl flex items-center justify-center flex-shrink-0 {{ $item->tiene_archivo ? 'bg-red-50 dark:bg-red-950/30 text-red-600 dark:text-red-400' : 'bg-gray-100 dark:bg-neutral-800 text-gray-400' }}">
                                <i class="{{ $item->tiene_archivo ? $item->icono_formato : 'bx bx-file-blank' }} text-2xl"></i>
                            </div>

                            <div class="min-w-0 flex-grow">
                                {{-- Badges de Sección, Categoría y Estado --}}
                                <div class="flex flex-wrap items-center gap-2 mb-1.5">
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

                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-600 dark:bg-neutral-800 dark:text-neutral-300 border border-gray-200 dark:border-neutral-700">
                                        <i class="bx bx-tag-alt me-1 text-xs"></i> {{ $item->categoria }}
                                    </span>

                                    {{-- Estado Subido vs Pendiente --}}
                                    @if($item->tiene_archivo)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-300">
                                            <i class="bx bx-check-circle text-sm"></i> Subido: {{ strtoupper($item->formato) }} ({{ $item->tamano_formateado }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/40 dark:border-amber-800 dark:text-amber-300">
                                            <i class="bx bx-time-five text-sm"></i> No subido
                                        </span>
                                    @endif
                                </div>

                                {{-- Título del Documento --}}
                                <h4 class="font-bold text-gray-900 dark:text-white text-base leading-snug">
                                    {{ $item->titulo }}
                                </h4>

                                @if($item->descripcion)
                                    <p class="text-xs text-gray-500 dark:text-neutral-400 mt-0.5 line-clamp-1">
                                        {{ $item->descripcion }}
                                    </p>
                                @endif

                                {{-- Mensaje de Error de Validación --}}
                                @error("archivos.{$item->id}")
                                    <p class="text-xs text-red-500 font-semibold mt-1.5 flex items-center gap-1">
                                        <i class="bx bx-error-circle text-sm"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- BOTONES DE ACCIÓN (SUBIR / BAJAR / REEMPLAZAR) --}}
                        <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-center">
                            
                            {{-- Indicador de subida en curso --}}
                            <div wire:loading wire:target="archivos.{{ $item->id }}" class="flex items-center gap-2 px-3 py-2 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-300 text-xs font-bold border border-blue-200 dark:border-blue-800 animate-pulse">
                                <i class="bx bx-loader-alt bx-spin text-base"></i>
                                <span>Subiendo archivo...</span>
                            </div>

                            {{-- Botones normales cuando no se está subiendo --}}
                            <div wire:loading.remove wire:target="archivos.{{ $item->id }}" class="flex items-center gap-2">
                                @if($item->tiene_archivo)
                                    {{-- Botón Bajar / Descargar --}}
                                    <a href="{{ $item->url }}" target="_blank" download
                                       title="Descargar archivo"
                                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm shadow-emerald-600/20 transition-all hover:shadow-md">
                                        <i class="bx bx-download text-base"></i>
                                        <span>Bajar</span>
                                    </a>

                                    {{-- Botón Reemplazar --}}
                                    <label for="upload-doc-{{ $item->id }}"
                                           title="Seleccionar otro archivo para reemplazar"
                                           class="cursor-pointer inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200 border border-gray-200 dark:border-neutral-700 transition-all shadow-sm">
                                        <i class="bx bx-refresh text-base text-blue-500"></i>
                                        <span>Reemplazar</span>
                                        <input type="file" 
                                               wire:model="archivos.{{ $item->id }}" 
                                               id="upload-doc-{{ $item->id }}" 
                                               class="hidden" 
                                               accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                                    </label>

                                    {{-- Botón Quitar Archivo --}}
                                    <button type="button"
                                            wire:click="quitarArchivo({{ $item->id }})"
                                            wire:confirm="¿Está seguro de quitar el archivo adjunto a '{{ $item->titulo }}'?"
                                            title="Quitar archivo adjunto"
                                            class="size-8 rounded-xl flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-950/40 dark:hover:bg-red-900/50 dark:text-red-400 transition-colors shadow-sm">
                                        <i class="bx bx-trash text-base"></i>
                                    </button>
                                @else
                                    {{-- Botón Subir Archivo --}}
                                    <label for="upload-doc-{{ $item->id }}"
                                           title="Subir archivo para este documento"
                                           class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white shadow-md shadow-red-500/20 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                        <i class="bx bx-cloud-upload text-base"></i>
                                        <span>Subir Archivo</span>
                                        <input type="file" 
                                               wire:model="archivos.{{ $item->id }}" 
                                               id="upload-doc-{{ $item->id }}" 
                                               class="hidden" 
                                               accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                                    </label>
                                @endif
                            </div>

                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl">
                    <i class="bx bx-folder-open text-4xl text-gray-300 dark:text-neutral-600 mb-2 block"></i>
                    <h4 class="font-bold text-gray-700 dark:text-neutral-300">No se encontraron documentos</h4>
                    <p class="text-sm text-gray-400 dark:text-neutral-500 mt-1">Pruebe ajustando los términos de búsqueda o los filtros.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-4">
            {{ $documentos->links() }}
        </div>
    </x-section>
</div>
