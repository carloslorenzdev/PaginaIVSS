?@extends('layouts/app')

@section('titulo', 'Actividades Anuales')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Actividades Anuales" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Actividades Anuales
            </x-breadcrumb.current>
        </x-breadcrumb>

        <x-card class="p-5">
            <div class="flex justify-between items-center mb-5 gap-3">
                <x-card.title>
                    <i class="bx bx-calendar-event"></i> Actividades Registradas
                </x-card.title>
                <x-button.link href="{{ route('admin.actividades.crear') }}" class="bg-red-600 hover:bg-red-700 text-white shrink-0">
                    <i class="bx bx-plus mr-1"></i> Nueva Actividad
                </x-button.link>
            </div>

            @if($actividades->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50 dark:bg-neutral-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Título</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Fecha Reg.</th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                            @foreach($actividades as $actividad)
                                <tr class="searchable-item hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                        {{ $actividad->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200 font-semibold max-w-xs truncate" title="{{ $actividad->titulo }}">
                                        {{ $actividad->titulo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($actividad->activa)
                                            <x-badge color="teal"><i class="bx bx-check mr-1"></i> Activa</x-badge>
                                        @else
                                            <x-badge color="gray"><i class="bx bx-block mr-1"></i> Inactiva</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400 text-center">
                                        {{ $actividad->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.actividades.ver', $actividad->id) }}" class="inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" title="Ver / Editar">
                                                <i class="bx bx-edit text-lg"></i>
                                            </a>
                                            
                                              <button type="button" class="btn-confirmar-accion inline-block inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-action="{{ route('admin.actividades.eliminar', $actividad->id) }}" data-method="DELETE" data-mensaje="¿Estás seguro de eliminar esta actividad y todo su contenido multimedia?" title="Eliminar">
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
                    <div class="mt-4 border-t border-gray-200 dark:border-neutral-700 pt-4">
                        {{ $actividades->links() }}
                    </div>
                @endif
                
            @else
                <div class="text-center py-10 px-4">
                    <div class="bg-gray-100 dark:bg-neutral-800 size-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bx bx-calendar-x text-4xl text-gray-400 dark:text-neutral-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-neutral-200">No hay actividades registradas</h3>
                    <p class="text-gray-500 dark:text-neutral-400 text-sm mt-1 mb-4">Crea una nueva actividad para destacarla en la página principal del IVSS.</p>
                    <x-button.link href="{{ route('admin.actividades.crear') }}" class="bg-red-600 hover:bg-red-700 text-white">
                        <i class="bx bx-plus mr-1"></i> Crear Actividad
                    </x-button.link>
                </div>
            @endif
        </x-card>
    </x-section>

    <x-modal-confirmar />
@endsection

