@extends('layouts/app')

@section('titulo', 'Rendimiento del Sistema')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Rendimiento y Optimización" class="text-gradient font-extrabold text-3xl" />
        </div>
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Rendimiento
            </x-breadcrumb.current>
        </x-breadcrumb>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-5">
            {{-- INFORMACIÓN DEL SERVIDOR --}}
            <div class="bg-white dark:bg-neutral-900/50 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700/50 p-6 md:p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-6">
                    <div class="size-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <i class="bx bx-server text-xl"></i>
                    </div>
                    Información del Servidor
                </h3>
                <div class="space-y-1 bg-gray-50/50 dark:bg-neutral-800/30 rounded-xl border border-gray-100 dark:border-neutral-700/50 p-2">
                    <div class="flex justify-between items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                        <span class="text-sm font-bold text-gray-600 dark:text-neutral-400">Sistema Operativo</span>
                        <span class="text-gray-900 dark:text-white bg-white dark:bg-neutral-700 px-3 py-1 rounded-lg border border-gray-200 dark:border-neutral-600 shadow-sm text-sm font-bold">{{ $serverInfo['os'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                        <span class="text-sm font-bold text-gray-600 dark:text-neutral-400">Software Web</span>
                        <span class="text-gray-900 dark:text-white bg-white dark:bg-neutral-700 px-3 py-1 rounded-lg border border-gray-200 dark:border-neutral-600 shadow-sm text-sm font-bold">{{ $serverInfo['server_software'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                        <span class="text-sm font-bold text-gray-600 dark:text-neutral-400">Versión PHP</span>
                        <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 px-3 py-1 rounded-lg border border-blue-100 dark:border-blue-800/50 shadow-sm text-sm font-extrabold">{{ $serverInfo['php_version'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 px-4 hover:bg-gray-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                        <span class="text-sm font-bold text-gray-600 dark:text-neutral-400">Versión Laravel</span>
                        <span class="bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 px-3 py-1 rounded-lg border border-red-100 dark:border-red-800/50 shadow-sm text-sm font-extrabold">{{ $serverInfo['laravel_version'] }}</span>
                    </div>
                </div>
            </div>

            {{-- USO DE ALMACENAMIENTO --}}
            <div class="bg-white dark:bg-neutral-900/50 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700/50 p-6 md:p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-6">
                    <div class="size-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                        <i class="bx bx-hdd text-xl"></i>
                    </div>
                    Uso de Almacenamiento
                </h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-bold text-gray-700 dark:text-neutral-300">Base de Datos</span>
                            <span class="text-sm font-extrabold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded border border-indigo-100 dark:border-indigo-800/50">{{ $dbSize }} MB</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-neutral-800 rounded-full h-2.5 overflow-hidden border border-gray-200 dark:border-neutral-700">
                            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-2.5 rounded-full" style="width: {{ min(100, $dbSize / 10) }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-bold text-gray-700 dark:text-neutral-300">Archivos de Caché</span>
                            <span class="text-sm font-extrabold text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/30 px-2 py-0.5 rounded border border-orange-100 dark:border-orange-800/50">{{ $cacheSize }} MB</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-neutral-800 rounded-full h-2.5 overflow-hidden border border-gray-200 dark:border-neutral-700">
                            <div class="bg-gradient-to-r from-orange-400 to-orange-500 h-2.5 rounded-full" style="width: {{ min(100, $cacheSize * 2) }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-bold text-gray-700 dark:text-neutral-300">Logs del Sistema</span>
                            <span class="text-sm font-extrabold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 px-2 py-0.5 rounded border border-red-100 dark:border-red-800/50">{{ $logsSize }} MB</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-neutral-800 rounded-full h-2.5 overflow-hidden border border-gray-200 dark:border-neutral-700">
                            <div class="bg-gradient-to-r from-red-500 to-red-600 h-2.5 rounded-full" style="width: {{ min(100, $logsSize / 2) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- HERRAMIENTAS DE OPTIMIZACIÓN --}}
            <div class="lg:col-span-2 bg-white dark:bg-neutral-900/50 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700/50 p-6 md:p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                    <div class="size-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                        <i class="bx bx-rocket text-xl"></i>
                    </div>
                    Herramientas de Optimización
                </h3>
                <p class="text-gray-500 dark:text-neutral-400 text-sm font-medium mb-8 leading-relaxed max-w-4xl">Utiliza estas herramientas para limpiar archivos temporales, vaciar la caché y optimizar el rendimiento general de la plataforma. Recomendado después de actualizaciones o subidas masivas de datos.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                    <button class="btn-optimizar flex flex-col items-center justify-center p-6 rounded-2xl border border-green-200 dark:border-green-800/50 bg-green-50/50 dark:bg-green-900/10 hover:bg-green-100 dark:hover:bg-green-900/20 transition-all cursor-pointer group shadow-sm hover:shadow-md transform hover:-translate-y-1" data-type="all" data-url="{{ route('admin.rendimiento.optimizar') }}">
                        <div class="size-16 rounded-2xl bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm border border-green-200 dark:border-green-800/50">
                            <i class="bx bx-bolt-circle text-3xl"></i>
                        </div>
                        <span class="font-bold text-green-800 dark:text-green-300 text-center text-lg">Optimización Total</span>
                        <span class="text-xs font-semibold text-green-600 dark:text-green-400/80 mt-1.5 text-center uppercase tracking-wider">Limpiar todo</span>
                    </button>

                    <button class="btn-optimizar flex flex-col items-center justify-center p-6 rounded-2xl border border-gray-100 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 hover:border-blue-200 dark:hover:border-blue-800/50 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all cursor-pointer group shadow-sm hover:shadow-md transform hover:-translate-y-1" data-type="cache" data-url="{{ route('admin.rendimiento.optimizar') }}">
                        <div class="size-16 rounded-2xl bg-white dark:bg-neutral-800 text-gray-500 dark:text-neutral-400 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 group-hover:text-blue-600 dark:group-hover:text-blue-400 flex items-center justify-center mb-4 transition-all shadow-sm border border-gray-100 dark:border-neutral-700 group-hover:border-blue-200 dark:group-hover:border-blue-800/50">
                            <i class="bx bx-data text-3xl"></i>
                        </div>
                        <span class="font-bold text-gray-700 dark:text-neutral-300 group-hover:text-blue-800 dark:group-hover:text-blue-300 text-center text-lg transition-colors">Caché de App</span>
                        <span class="text-xs font-semibold text-gray-500 dark:text-neutral-500 mt-1.5 text-center uppercase tracking-wider group-hover:text-blue-600/80 dark:group-hover:text-blue-400/80 transition-colors">Limpiar consultas</span>
                    </button>

                    <button class="btn-optimizar flex flex-col items-center justify-center p-6 rounded-2xl border border-gray-100 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 hover:border-purple-200 dark:hover:border-purple-800/50 hover:bg-purple-50/50 dark:hover:bg-purple-900/10 transition-all cursor-pointer group shadow-sm hover:shadow-md transform hover:-translate-y-1" data-type="views" data-url="{{ route('admin.rendimiento.optimizar') }}">
                        <div class="size-16 rounded-2xl bg-white dark:bg-neutral-800 text-gray-500 dark:text-neutral-400 group-hover:bg-purple-100 dark:group-hover:bg-purple-900/40 group-hover:text-purple-600 dark:group-hover:text-purple-400 flex items-center justify-center mb-4 transition-all shadow-sm border border-gray-100 dark:border-neutral-700 group-hover:border-purple-200 dark:group-hover:border-purple-800/50">
                            <i class="bx bx-layout text-3xl"></i>
                        </div>
                        <span class="font-bold text-gray-700 dark:text-neutral-300 group-hover:text-purple-800 dark:group-hover:text-purple-300 text-center text-lg transition-colors">Caché de Vistas</span>
                        <span class="text-xs font-semibold text-gray-500 dark:text-neutral-500 mt-1.5 text-center uppercase tracking-wider group-hover:text-purple-600/80 dark:group-hover:text-purple-400/80 transition-colors">Limpiar compiladas</span>
                    </button>

                    <button class="btn-optimizar flex flex-col items-center justify-center p-6 rounded-2xl border border-gray-100 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 hover:border-orange-200 dark:hover:border-orange-800/50 hover:bg-orange-50/50 dark:hover:bg-orange-900/10 transition-all cursor-pointer group shadow-sm hover:shadow-md transform hover:-translate-y-1" data-type="routes" data-url="{{ route('admin.rendimiento.optimizar') }}">
                        <div class="size-16 rounded-2xl bg-white dark:bg-neutral-800 text-gray-500 dark:text-neutral-400 group-hover:bg-orange-100 dark:group-hover:bg-orange-900/40 group-hover:text-orange-600 dark:group-hover:text-orange-400 flex items-center justify-center mb-4 transition-all shadow-sm border border-gray-100 dark:border-neutral-700 group-hover:border-orange-200 dark:group-hover:border-orange-800/50">
                            <i class="bx bx-directions text-3xl"></i>
                        </div>
                        <span class="font-bold text-gray-700 dark:text-neutral-300 group-hover:text-orange-800 dark:group-hover:text-orange-300 text-center text-lg transition-colors">Caché de Rutas</span>
                        <span class="text-xs font-semibold text-gray-500 dark:text-neutral-500 mt-1.5 text-center uppercase tracking-wider group-hover:text-orange-600/80 dark:group-hover:text-orange-400/80 transition-colors">Reconstruir rutas</span>
                    </button>
                </div>
            </div>
        </div>
    </x-section>
@endsection

@push('page-scripts')
    <script src="{{ asset('js/admin/rendimiento.js') }}?v={{ filemtime(public_path('js/admin/rendimiento.js')) }}" nonce="{{ app('csp-nonce') ?? '' }}"></script>
@endpush
