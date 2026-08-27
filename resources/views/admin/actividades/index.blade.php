@extends('layouts/app')

@section('titulo', 'Actividades Anuales')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
            <div>
                <x-titulo titulo="Actividades Anuales" class="text-gradient font-extrabold text-3xl" />
                <x-breadcrumb class="mt-2">
                    <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                        Panel
                    </x-breadcrumb.item>
                    <x-breadcrumb.current>
                        Actividades Anuales
                    </x-breadcrumb.current>
                </x-breadcrumb>
            </div>
            <x-button.link href="{{ route('admin.actividades.crear') }}"
                class="rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white hover:from-red-700 hover:to-red-600 shadow-md hover:shadow-lg shadow-red-500/30 hover:-translate-y-0.5 transition-all duration-300 font-semibold px-5 py-2.5 flex items-center gap-2">
                <i class="bx bx-plus-circle text-lg"></i>
                <span>Nueva Actividad</span>
            </x-button.link>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden">
            @if($actividades->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50/50 dark:bg-neutral-800/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">Título</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha Reg.</th>
                                <th scope="col" class="px-6 py-4 text-end text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-neutral-700/50">
                            @foreach($actividades as $actividad)
                                <tr class="searchable-item hover:bg-gray-50/80 dark:hover:bg-neutral-700/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                        #{{ $actividad->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200 font-medium max-w-xs truncate" title="{{ $actividad->titulo }}">
                                        {{ $actividad->titulo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($actividad->activa)
                                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400">
                                                <i class="bx bx-check-circle text-sm"></i> Activa
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-neutral-700 dark:text-neutral-300">
                                                <i class="bx bx-block text-sm"></i> Inactiva
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400 text-center">
                                        {{ $actividad->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.actividades.ver', $actividad->id) }}" 
                                               class="size-8 inline-flex justify-center items-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-colors dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/40" title="Ver / Editar">
                                                <i class="bx bx-edit text-lg"></i>
                                            </a>
                                            <button type="button" class="btn-confirmar-accion size-8 inline-flex justify-center items-center rounded-xl bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40" 
                                                    data-action="{{ route('admin.actividades.eliminar', $actividad->id) }}" 
                                                    data-method="DELETE" 
                                                    data-mensaje="¿Estás seguro de eliminar esta actividad y todo su contenido multimedia?" title="Eliminar">
                                                <i class="bx bx-trash text-lg"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($actividades->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-neutral-700 bg-gray-50/30 dark:bg-neutral-800/50">
                        {{ $actividades->links() }}
                    </div>
                @endif
                
            @else
                <div class="text-center py-16 px-4">
                    <div class="bg-gray-50 dark:bg-neutral-800/50 size-24 rounded-full flex items-center justify-center mx-auto mb-5 border border-gray-100 dark:border-neutral-700 shadow-sm">
                        <i class="bx bx-calendar-x text-5xl text-gray-400 dark:text-neutral-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No hay actividades registradas</h3>
                    <p class="text-gray-500 dark:text-neutral-400 text-sm mb-6 max-w-md mx-auto">Crea una nueva actividad para destacarla en la página principal del IVSS.</p>
                    <x-button.link href="{{ route('admin.actividades.crear') }}" class="rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white hover:from-red-700 hover:to-red-600 shadow-md transition-all duration-300 font-semibold px-5 py-2.5 inline-flex items-center gap-2">
                        <i class="bx bx-plus-circle text-lg"></i>
                        <span>Crear Actividad</span>
                    </x-button.link>
                </div>
            @endif
        </div>
    </x-section>

    <x-modal-confirmar />
@endsection

