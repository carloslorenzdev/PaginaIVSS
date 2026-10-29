<div class="space-y-6">
    {{-- CABECERA Y BREADCRUMB --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="size-10 rounded-xl bg-gradient-to-tr from-red-600 to-rose-500 flex items-center justify-center text-white shadow-md shadow-red-500/20">
                    <i class="bx bx-shield-quarter text-2xl"></i>
                </div>
                <div>
                    <x-titulo titulo="Auditoría de Sesiones y Actividades" class="text-2xl font-black text-gray-900 dark:text-white" />
                    <p class="text-xs text-gray-500 dark:text-neutral-400 mt-0.5">
                        Trazabilidad exhaustiva de accesos, operaciones y ubicaciones de los usuarios
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button wire:click="exportarCsv" wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-semibold text-gray-700 dark:text-neutral-200 hover:bg-gray-50 dark:hover:bg-neutral-700 shadow-sm transition-all">
                <i class="bx bx-download text-base text-red-600"></i>
                <span>Exportar CSV</span>
            </button>
            <a href="/log-errors" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white dark:bg-neutral-700 hover:bg-gray-800 text-sm font-semibold shadow-sm transition-all">
                <i class="bx bx-code-alt text-base text-yellow-400"></i>
                <span>Log Viewer</span>
            </a>
        </div>
    </div>

    {{-- STATS KPIS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total actividades --}}
        <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider">Total Eventos</span>
                <div class="size-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <i class="bx bx-list-check text-xl"></i>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-2">{{ number_format($totalActividades) }}</p>
            <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Registros en el historial</p>
        </div>

        {{-- Sesiones iniciadas hoy --}}
        <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider">Inicios de Sesión Hoy</span>
                <div class="size-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <i class="bx bx-log-in-circle text-xl"></i>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-2">{{ number_format($iniciosHoy) }}</p>
            <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Autenticaciones hoy</p>
        </div>

        {{-- Usuarios únicos hoy --}}
        <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider">Usuarios Activos Hoy</span>
                <div class="size-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                    <i class="bx bx-user-check text-xl"></i>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-2">{{ number_format($usuariosActivosHoy) }}</p>
            <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Operando en el panel</p>
        </div>

        {{-- Acciones críticas --}}
        <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider">Seguridad y Críticos</span>
                <div class="size-10 rounded-xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-600 dark:text-rose-400">
                    <i class="bx bx-shield-x text-xl"></i>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-2">{{ number_format($seguridadHoy) }}</p>
            <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">Eliminaciones y bloqueos hoy</p>
        </div>
    </div>

    {{-- BARRA DE BÚSQUEDA Y FILTROS --}}
    <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-2xl p-4 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            {{-- Buscador --}}
            <div class="lg:col-span-5 relative">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por descripción, usuario, IP..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200">
                <i class="bx bx-search absolute left-3.5 top-3 text-lg text-gray-400"></i>
            </div>

            {{-- Filtro de Evento --}}
            <div class="lg:col-span-3">
                <select wire:model.live="filtroEvento"
                    class="w-full py-2.5 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200">
                    <option value="todos">Todos los Eventos</option>
                    <option value="login">Inicios de Sesión (Login)</option>
                    <option value="logout">Cierres de Sesión (Logout)</option>
                    <option value="login_fallido">Intentos Fallidos</option>
                    <option value="creacion">Creaciones de Contenido</option>
                    <option value="edicion">Modificaciones / Ediciones</option>
                    <option value="cambio_estado">Cambios de Publicación</option>
                    <option value="seguridad">Seguridad y Permisos</option>
                    <option value="eliminacion">Eliminaciones</option>
                </select>
            </div>

            {{-- Filtro de Usuario --}}
            <div class="lg:col-span-2">
                <select wire:model.live="filtroUsuario"
                    class="w-full py-2.5 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200">
                    <option value="todos">Todos los Usuarios</option>
                    @foreach($usuariosFiltro as $u)
                        <option value="{{ $u->id }}">{{ $u->usuario }} ({{ $u->nombre }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro de Fecha --}}
            <div class="lg:col-span-2">
                <select wire:model.live="filtroFecha"
                    class="w-full py-2.5 px-3 rounded-xl border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm focus:border-red-500 focus:ring-red-500 dark:text-neutral-200">
                    <option value="hoy">Hoy</option>
                    <option value="7dias">Últimos 7 días</option>
                    <option value="30dias">Últimos 30 días</option>
                    <option value="todos">Todo el historial</option>
                </select>
            </div>
        </div>
    </div>

    {{-- TABLA DE AUDITORÍA --}}
    <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/60 rounded-2xl shadow-sm overflow-hidden">
        {{-- SKELETON PLACEHOLDER DURANTE CARGA --}}
        <div wire:loading wire:target="search, filtroEvento, filtroUsuario, filtroFecha, gotoPage, previousPage, nextPage" class="p-6">
            <x-skeleton.table rows="8" cols="6" />
        </div>

        {{-- CONTENIDO REAL DE AUDITORÍA --}}
        <div wire:loading.remove wire:target="search, filtroEvento, filtroUsuario, filtroFecha, gotoPage, previousPage, nextPage" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-neutral-700/60">
                <thead class="bg-gray-50/75 dark:bg-neutral-800/80 text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5 text-left">Fecha y Hora</th>
                        <th class="px-5 py-3.5 text-left">Usuario Responsable</th>
                        <th class="px-5 py-3.5 text-left">Tipo de Acción</th>
                        <th class="px-5 py-3.5 text-left">Descripción de la Actividad</th>
                        <th class="px-5 py-3.5 text-left">Desde Dónde (Ubicación / Equipo)</th>
                        <th class="px-5 py-3.5 text-right">Detalle</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-neutral-700/60 text-sm">
                    @forelse($actividades as $act)
                        @php
                            $props = $act->properties ?? [];
                            $ip = $props['ip'] ?? '127.0.0.1';
                            $dispositivo = $props['dispositivo'] ?? 'Desktop';
                            $navegador = $props['navegador'] ?? 'N/A';
                            $so = $props['sistema_operativo'] ?? 'N/A';
                            
                            // Badge de colores por evento
                            $badgeClass = match($act->event) {
                                'login' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800',
                                'logout' => 'bg-gray-100 text-gray-700 dark:bg-neutral-700 dark:text-neutral-300 border-gray-200 dark:border-neutral-600',
                                'login_fallido' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300 border-rose-300 dark:border-rose-700 font-bold',
                                'creacion' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 border-blue-200 dark:border-blue-800',
                                'edicion' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 border-amber-200 dark:border-amber-800',
                                'cambio_estado' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-400 border-indigo-200 dark:border-indigo-800',
                                'seguridad' => 'bg-purple-50 text-purple-700 dark:bg-purple-900/20 dark:text-purple-400 border-purple-200 dark:border-purple-800',
                                'eliminacion' => 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 border-red-200 dark:border-red-800 font-bold',
                                default => 'bg-gray-50 text-gray-600 dark:bg-neutral-700/40 dark:text-neutral-400 border-gray-200 dark:border-neutral-600',
                            };

                            $iconoEvento = match($act->event) {
                                'login' => 'bx-log-in-circle',
                                'logout' => 'bx-log-out-circle',
                                'login_fallido' => 'bx-error-circle',
                                'creacion' => 'bx-plus-circle',
                                'edicion' => 'bx-edit',
                                'cambio_estado' => 'bx-toggle-left',
                                'seguridad' => 'bx-shield',
                                'eliminacion' => 'bx-trash',
                                default => 'bx-check-circle',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-neutral-700/40 transition-colors" wire:key="act-{{ $act->id }}">
                            {{-- Fecha y Hora --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="font-medium text-gray-900 dark:text-white text-xs">
                                    {{ $act->created_at->format('d/m/Y') }}
                                </div>
                                <div class="text-[11px] text-gray-500 dark:text-neutral-400 flex items-center gap-1 mt-0.5">
                                    <i class="bx bx-time text-xs"></i>
                                    <span>{{ $act->created_at->format('h:i:s A') }}</span>
                                    <span class="text-gray-400">({{ $act->created_at->diffForHumans() }})</span>
                                </div>
                            </td>

                            {{-- Usuario Responsable --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="size-8 rounded-full bg-gradient-to-tr from-gray-200 to-gray-300 dark:from-neutral-700 dark:to-neutral-600 flex items-center justify-center font-bold text-xs text-gray-700 dark:text-neutral-200 uppercase">
                                        {{ substr($act->causer->nombre ?? $act->causer->usuario ?? 'S', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white text-xs">
                                            {{ $act->causer->nombre ?? ($act->causer->usuario ?? 'Sistema / Cron') }}
                                        </div>
                                        <div class="text-[11px] text-gray-500 dark:text-neutral-400">
                                            {{ $act->causer ? '@' . $act->causer->usuario : 'Automático' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipo de Acción --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                    <i class="bx {{ $iconoEvento }} text-sm"></i>
                                    <span>{{ ucfirst(str_replace('_', ' ', $act->event ?? 'Acción')) }}</span>
                                </span>
                            </td>

                            {{-- Descripción --}}
                            <td class="px-5 py-3.5">
                                <div class="text-xs font-medium text-gray-900 dark:text-neutral-200 max-w-md line-clamp-2">
                                    {{ $act->description }}
                                </div>
                                @if($act->subject_type)
                                    <div class="text-[11px] text-gray-400 dark:text-neutral-500 mt-0.5">
                                        Módulo: <span class="font-semibold">{{ class_basename($act->subject_type) }}</span> (ID: #{{ $act->subject_id }})
                                    </div>
                                @endif
                            </td>

                            {{-- Desde Dónde (Ubicación / Equipo) --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="size-7 rounded-lg bg-gray-100 dark:bg-neutral-700 flex items-center justify-center text-gray-600 dark:text-neutral-300 text-sm" title="{{ $dispositivo }}">
                                        @if($dispositivo === 'Móvil')
                                            <i class="bx bx-mobile"></i>
                                        @elseif($dispositivo === 'Tablet')
                                            <i class="bx bx-tablet"></i>
                                        @else
                                            <i class="bx bx-laptop"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-gray-800 dark:text-neutral-200 font-mono">
                                            {{ $ip }}
                                        </div>
                                        <div class="text-[11px] text-gray-500 dark:text-neutral-400">
                                            {{ $navegador }} · {{ $so }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Acciones / Detalle --}}
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <button wire:click="verDetalle({{ $act->id }})"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-gray-200 dark:border-neutral-700 text-xs font-semibold text-gray-700 dark:text-neutral-300 hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors">
                                    <i class="bx bx-info-circle text-sm text-red-600"></i>
                                    <span>Ver Info</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-neutral-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="size-16 rounded-full bg-gray-100 dark:bg-neutral-700/50 flex items-center justify-center text-gray-400 text-3xl mb-3">
                                        <i class="bx bx-shield-quarter"></i>
                                    </div>
                                    <p class="font-bold text-gray-700 dark:text-neutral-300">No se encontraron actividades registradas</p>
                                    <p class="text-xs text-gray-400 mt-1">Prueba cambiando los filtros de fecha o búsqueda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        @if($actividades->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-neutral-700/60">
                {{ $actividades->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL DETALLE DE ACTIVIDAD (JSON / METADATOS) --}}
    @if($modalDetalleOpen && $selectedDetail)
        <div class="fixed inset-0 z-[80] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="cerrarModal"></div>
            <div class="relative w-full max-w-2xl bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-neutral-700 overflow-hidden z-10 animate-modal">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-neutral-700 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                            <i class="bx bx-receipt text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Detalle de Registro #{{ $selectedDetail['id'] }}</h3>
                    </div>
                    <button wire:click="cerrarModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-neutral-200">
                        <i class="bx bx-x text-2xl"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                    {{-- Información General --}}
                    <div class="grid grid-cols-2 gap-3 text-xs bg-gray-50 dark:bg-neutral-900/60 p-4 rounded-xl border border-gray-100 dark:border-neutral-700/50">
                        <div>
                            <span class="text-gray-400 block font-semibold uppercase text-[10px]">Evento</span>
                            <span class="font-bold text-gray-800 dark:text-white">{{ strtoupper($selectedDetail['evento'] ?? 'N/A') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block font-semibold uppercase text-[10px]">Fecha y Hora</span>
                            <span class="font-bold text-gray-800 dark:text-white">{{ $selectedDetail['fecha'] }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block font-semibold uppercase text-[10px]">Usuario Responsable</span>
                            <span class="font-bold text-gray-800 dark:text-white">{{ $selectedDetail['usuario'] }} ({{ $selectedDetail['usuario_login'] }})</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block font-semibold uppercase text-[10px]">Módulo Afectado</span>
                            <span class="font-bold text-gray-800 dark:text-white">{{ $selectedDetail['subject_type'] ?: 'Ninguno' }} (ID: {{ $selectedDetail['subject_id'] ?? 'N/A' }})</span>
                        </div>
                        <div class="col-span-2 pt-1 border-t border-gray-200/50 dark:border-neutral-700/50">
                            <span class="text-gray-400 block font-semibold uppercase text-[10px]">Descripción Completa</span>
                            <p class="font-semibold text-gray-900 dark:text-neutral-100 mt-0.5">{{ $selectedDetail['descripcion'] }}</p>
                        </div>
                    </div>

                    {{-- Propiedades y Trazabilidad (Desde Dónde) --}}
                    <div>
                        <h4 class="text-xs font-bold text-gray-700 dark:text-neutral-300 uppercase tracking-wider mb-2">Trazabilidad Técnica (Ubicación y Entorno)</h4>
                        <div class="bg-neutral-900 text-neutral-200 rounded-xl p-4 font-mono text-xs overflow-x-auto shadow-inner">
                            <pre class="whitespace-pre-wrap">{{ json_encode($selectedDetail['properties'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-3.5 bg-gray-50 dark:bg-neutral-900/40 border-t border-gray-100 dark:border-neutral-700 flex justify-end">
                    <button wire:click="cerrarModal" class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-neutral-700 text-xs font-bold text-gray-800 dark:text-neutral-200 hover:bg-gray-300">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

