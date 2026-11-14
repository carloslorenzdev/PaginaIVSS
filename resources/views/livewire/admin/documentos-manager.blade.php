<div x-data
     x-init="
        const dispararToast = () => {
            const el = document.querySelector('#hs-new-toast');
            if (el && typeof window.ToastAlert === 'function') {
                const html = el.innerHTML;
                el.remove();
                window.ToastAlert(html);
            }
        };
        dispararToast();
        if (window.Livewire && typeof window.Livewire.hook === 'function') {
            window.Livewire.hook('morph.updated', () => {
                setTimeout(dispararToast, 50);
            });
        }
     ">
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        {{-- ENCABEZADO --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Documentos Institucionales" class="text-gradient font-extrabold text-3xl" />
        </div>

        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Documentos Institucionales
            </x-breadcrumb.current>
        </x-breadcrumb>

        {{-- NOTIFICACIONES TOAST (ESTILO OFICIAL DEL SISTEMA) --}}
        @if (session()->has('success'))
            <x-toast :data="['success', session('success')]" />
        @endif

        @if (session()->has('error'))
            <x-toast :data="['danger', session('error')]" />
        @endif

        {{-- RESUMEN / ESTADÍSTICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-gray-100 dark:bg-neutral-700 flex items-center justify-center text-gray-700 dark:text-gray-200 flex-shrink-0">
                    <i class="bx bx-folder text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Total Documentos</span>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totales['total'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
                    <i class="bx bx-check-circle text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Archivos Subidos</span>
                    <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">{{ $totales['subidos'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="size-11 rounded-xl bg-amber-50 dark:bg-amber-950/40 flex items-center justify-center text-amber-600 dark:text-amber-400 flex-shrink-0">
                    <i class="bx bx-time-five text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs text-gray-500 dark:text-neutral-400 font-medium">Pendientes</span>
                    <p class="text-xl font-bold text-amber-600 dark:text-amber-400">{{ $totales['pendientes'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl p-4 shadow-sm flex items-center gap-3">
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
        <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl p-4 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                {{-- Búsqueda por nombre --}}
                <div class="relative">
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Buscar documento por título..."
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 text-gray-900 dark:text-neutral-200 shadow-sm">
                    <i class="bx bx-search absolute left-3.5 top-2.5 text-lg text-gray-400"></i>
                </div>

                {{-- Filtro por Sección --}}
                <div>
                    <select wire:model.live="filtroSeccion"
                        class="w-full py-2 px-3 rounded-lg border border-gray-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 text-gray-900 dark:text-neutral-200 shadow-sm">
                        <option value="">Todas las Secciones (36)</option>
                        @foreach($seccionesDisponibles as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtro por Estado de Carga --}}
                <div>
                    <select wire:model.live="filtroEstado"
                        class="w-full py-2 px-3 rounded-lg border border-gray-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 text-gray-900 dark:text-neutral-200 shadow-sm">
                        <option value="">Todos los Estados</option>
                        <option value="subidos">Subidos (Con archivo)</option>
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
                <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl p-4 sm:p-5 hover:border-gray-300 dark:hover:border-neutral-600 transition-colors shadow-sm"
                     wire:key="doc-row-{{ $item->id }}">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        
                        {{-- DETALLES DEL DOCUMENTO --}}
                        <div class="flex items-start gap-3.5 flex-grow min-w-0">
                            {{-- Icono de formato --}}
                            <div class="size-11 rounded-xl flex items-center justify-center flex-shrink-0 {{ $item->tiene_archivo ? 'bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400' : 'bg-gray-100 dark:bg-neutral-700 text-gray-400 dark:text-neutral-400' }}">
                                <i class="{{ $item->tiene_archivo ? $item->icono_formato : 'bx bx-file-blank' }} text-2xl"></i>
                            </div>

                            <div class="min-w-0 flex-grow">
                                {{-- Badges de Sección, Categoría y Estado --}}
                                <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                    @php
                                        $badgeColor = match($item->seccion) {
                                            'marco_normativo' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300 border-red-200 dark:border-red-800/60',
                                            'contrataciones_publicas' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300 border-amber-200 dark:border-amber-800/60',
                                            'biblioteca_formas' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border-blue-200 dark:border-blue-800/60',
                                            default => 'bg-gray-100 text-gray-700 dark:bg-neutral-700 dark:text-neutral-300 border-gray-200',
                                        };
                                        $nombreSeccion = $seccionesDisponibles[$item->seccion] ?? ucfirst(str_replace('_', ' ', $item->seccion));
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold border {{ $badgeColor }}">
                                        {{ $nombreSeccion }}
                                    </span>

                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-700 dark:bg-neutral-700 dark:text-neutral-300 border border-gray-200 dark:border-neutral-600">
                                        <i class="bx bx-tag-alt me-1 text-xs"></i> {{ $item->categoria }}
                                    </span>

                                    {{-- Estado Subido vs Pendiente --}}
                                    @if($item->tiene_archivo)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:border-emerald-800/60 dark:text-emerald-300">
                                            <i class="bx bx-check-circle text-sm"></i> Subido: {{ strtoupper($item->formato) }} ({{ $item->tamano_formateado }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-900/30 dark:border-amber-800/60 dark:text-amber-300">
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
                                    <p class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1.5 flex items-center gap-1">
                                        <i class="bx bx-error-circle text-sm"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- BOTONES DE ACCIÓN (NORMALES, SIN DEGRADADOS, VISIBLES EN AMBOS MODOS) --}}
                        <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-center">
                            
                            {{-- Indicador de subida en curso --}}
                            <div wire:loading wire:target="archivos.{{ $item->id }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-neutral-700 text-blue-700 dark:text-blue-300 text-xs font-semibold border border-blue-200 dark:border-blue-600">
                                <i class="bx bx-loader-alt bx-spin text-base"></i>
                                <span>Subiendo archivo...</span>
                            </div>

                            {{-- Botones normales cuando no se está subiendo --}}
                            <div wire:loading.remove wire:target="archivos.{{ $item->id }}" class="flex items-center gap-2">
                                @if($item->tiene_archivo)
                                    {{-- Botón Bajar / Descargar --}}
                                    <a href="{{ $item->url }}" target="_blank" download
                                       title="Descargar archivo"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-600 text-gray-800 dark:text-white shadow-sm transition-colors">
                                        <i class="bx bx-download text-base text-emerald-600 dark:text-emerald-400"></i>
                                        <span>Bajar</span>
                                    </a>

                                    {{-- Botón Reemplazar --}}
                                    <label for="upload-doc-{{ $item->id }}"
                                           title="Seleccionar otro archivo para reemplazar"
                                           class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-600 text-gray-800 dark:text-white shadow-sm transition-colors">
                                        <i class="bx bx-refresh text-base text-blue-600 dark:text-blue-400"></i>
                                        <span>Reemplazar</span>
                                        <input type="file" 
                                               wire:model="archivos.{{ $item->id }}" 
                                               id="upload-doc-{{ $item->id }}" 
                                               class="hidden" 
                                               accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                                    </label>

                                    {{-- Botón Quitar Archivo (Sin modal de confirmación) --}}
                                    <button type="button"
                                            wire:click="quitarArchivo({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                            title="Quitar archivo adjunto (volver a No Subido)"
                                            class="size-8 rounded-lg flex items-center justify-center border border-gray-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 hover:bg-red-50 dark:hover:bg-red-900/30 text-gray-600 hover:text-red-600 dark:text-neutral-300 dark:hover:text-red-400 shadow-sm transition-colors disabled:opacity-50">
                                        <i class="bx bx-trash text-base" wire:loading.remove wire:target="quitarArchivo({{ $item->id }})"></i>
                                        <i class="bx bx-loader-alt bx-spin text-base text-red-600" wire:loading wire:target="quitarArchivo({{ $item->id }})"></i>
                                    </button>
                                @else
                                    {{-- Botón Subir Archivo (Sólido normal, sin degradado) --}}
                                    <label for="upload-doc-{{ $item->id }}"
                                           title="Subir archivo para este documento"
                                           class="cursor-pointer inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-red-600 hover:bg-red-700 text-white shadow-sm transition-colors">
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
                <div class="text-center py-12 bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl">
                    <i class="bx bx-folder-open text-4xl text-gray-300 dark:text-neutral-500 mb-2 block"></i>
                    <h4 class="font-bold text-gray-700 dark:text-neutral-200">No se encontraron documentos</h4>
                    <p class="text-sm text-gray-400 dark:text-neutral-400 mt-1">Pruebe ajustando los términos de búsqueda o los filtros.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-4">
            {{ $documentos->links() }}
        </div>
    </x-section>
</div>
