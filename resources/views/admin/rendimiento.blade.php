@extends('layouts/app')

@section('titulo', 'Rendimiento del Sistema')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Rendimiento y Optimización" />
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="bx bx-server text-blue-600 text-xl mr-2"></i> Información del Servidor
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-600 font-medium">Sistema Operativo</span>
                        <span class="text-gray-900 bg-gray-100 px-3 py-1 rounded-full text-sm">{{ $serverInfo['os'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-600 font-medium">Software Web</span>
                        <span class="text-gray-900 bg-gray-100 px-3 py-1 rounded-full text-sm">{{ $serverInfo['server_software'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-600 font-medium">Versión PHP</span>
                        <span class="text-gray-900 bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $serverInfo['php_version'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 font-medium">Versión Laravel</span>
                        <span class="text-gray-900 bg-red-50 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $serverInfo['laravel_version'] }}</span>
                    </div>
                </div>
            </div>

            {{-- USO DE ALMACENAMIENTO --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="bx bx-hdd text-purple-600 text-xl mr-2"></i> Uso de Almacenamiento
                </h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Base de Datos</span>
                            <span class="text-sm font-bold text-gray-900">{{ $dbSize }} MB</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ min(100, $dbSize / 10) }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Archivos de Caché</span>
                            <span class="text-sm font-bold text-gray-900">{{ $cacheSize }} MB</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: {{ min(100, $cacheSize * 2) }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Logs del Sistema</span>
                            <span class="text-sm font-bold text-gray-900">{{ $logsSize }} MB</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ min(100, $logsSize / 2) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- HERRAMIENTAS DE OPTIMIZACIÓN --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="bx bx-rocket text-green-600 text-xl mr-2"></i> Herramientas de Optimización
                </h3>
                <p class="text-gray-500 text-sm mb-6">Utiliza estas herramientas para limpiar archivos temporales, vaciar la caché y optimizar el rendimiento general de la plataforma. Recomendado después de actualizaciones o subidas masivas de datos.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <button class="btn-optimizar flex flex-col items-center justify-center p-4 rounded-xl border border-green-200 bg-green-50 hover:bg-green-100 transition-colors cursor-pointer group" data-type="all" data-url="{{ route('admin.rendimiento.optimizar') }}">
                        <div class="h-12 w-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i class="bx bx-bolt-circle text-2xl"></i>
                        </div>
                        <span class="font-bold text-green-800 text-center">Optimización Total</span>
                        <span class="text-xs text-green-600 mt-1 text-center">Limpiar todo</span>
                    </button>

                    <button class="btn-optimizar flex flex-col items-center justify-center p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors cursor-pointer group" data-type="cache" data-url="{{ route('admin.rendimiento.optimizar') }}">
                        <div class="h-12 w-12 rounded-full bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-600 flex items-center justify-center mb-3 transition-colors">
                            <i class="bx bx-data text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-800 group-hover:text-blue-800 text-center">Caché de App</span>
                        <span class="text-xs text-gray-500 mt-1 text-center">Limpiar caché de consultas</span>
                    </button>

                    <button class="btn-optimizar flex flex-col items-center justify-center p-4 rounded-xl border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-colors cursor-pointer group" data-type="views" data-url="{{ route('admin.rendimiento.optimizar') }}">
                        <div class="h-12 w-12 rounded-full bg-gray-100 text-gray-600 group-hover:bg-purple-100 group-hover:text-purple-600 flex items-center justify-center mb-3 transition-colors">
                            <i class="bx bx-layout text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-800 group-hover:text-purple-800 text-center">Caché de Vistas</span>
                        <span class="text-xs text-gray-500 mt-1 text-center">Limpiar vistas compiladas</span>
                    </button>

                    <button class="btn-optimizar flex flex-col items-center justify-center p-4 rounded-xl border border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition-colors cursor-pointer group" data-type="routes" data-url="{{ route('admin.rendimiento.optimizar') }}">
                        <div class="h-12 w-12 rounded-full bg-gray-100 text-gray-600 group-hover:bg-orange-100 group-hover:text-orange-600 flex items-center justify-center mb-3 transition-colors">
                            <i class="bx bx-directions text-2xl"></i>
                        </div>
                        <span class="font-bold text-gray-800 group-hover:text-orange-800 text-center">Caché de Rutas</span>
                        <span class="text-xs text-gray-500 mt-1 text-center">Reconstruir rutas</span>
                    </button>
                </div>
            </div>
        </div>
    </x-section>
@endsection

@push('page-scripts')
    <script src="{{ asset('js/admin/rendimiento.js') }}" nonce="{{ app('csp-nonce') ?? '' }}"></script>
@endpush
