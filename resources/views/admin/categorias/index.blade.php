@extends('layouts/app')

@section('titulo', 'Categorías')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Categorías" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Categorías
            </x-breadcrumb.current>
        </x-breadcrumb>

        <x-card class="p-5">
            <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-neutral-700 pb-3">
                <x-card.title>
                    <i class="bx bx-list-ul"></i> Listado de Categorías
                </x-card.title>
                <x-button.link href="{{ route('admin.categorias.crear') }}" class="bg-red-600 hover:bg-red-700 text-white text-sm">
                    <i class="bx bx-plus mr-1"></i> Nueva Categoría
                </x-button.link>
            </div>

            <x-table.table>
                <x-slot name="head">
                    <x-table.th>#</x-table.th>
                    <x-table.th>Nombre</x-table.th>
                    <x-table.th>Descripción</x-table.th>
                    <x-table.th>Estado</x-table.th>
                    <x-table.th>Noticias</x-table.th>
                    <x-table.th>Acciones</x-table.th>
                </x-slot>
                <x-slot name="body">
                    @forelse($categorias as $cat)
                        <x-table.tr>
                            <x-table.td class="text-center font-medium">{{ $loop->iteration }}</x-table.td>
                            <x-table.td class="font-semibold text-gray-800 dark:text-neutral-200">
                                {{ $cat->nombre }}
                            </x-table.td>
                            <x-table.td class="text-gray-500 max-w-xs truncate">
                                {{ $cat->descripcion ?: 'Sin descripción' }}
                            </x-table.td>
                            <x-table.td>
                                @if ($cat->activa)
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-500">
                                        <span class="w-1.5 h-1.5 inline-block bg-emerald-500 rounded-full"></span>
                                        Activa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-500">
                                        <span class="w-1.5 h-1.5 inline-block bg-red-500 rounded-full"></span>
                                        Inactiva
                                    </span>
                                @endif
                            </x-table.td>
                            <x-table.td class="text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-500 font-semibold text-sm">
                                    {{ $cat->noticias_count ?? 0 }}
                                </span>
                            </x-table.td>
                            <x-table.td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.categorias.editar', $cat->id) }}" class="p-2 inline-flex items-center gap-2 rounded-lg border border-transparent font-semibold text-gray-500 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all dark:text-neutral-400 dark:hover:text-blue-500" title="Editar">
                                        <i class="bx bx-edit text-lg"></i>
                                    </a>
                                    <form action="{{ route('admin.categorias.eliminar', $cat->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 inline-flex items-center gap-2 rounded-lg border border-transparent font-semibold text-gray-500 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all dark:text-neutral-400 dark:hover:text-red-500" title="Eliminar">
                                            <i class="bx bx-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="6" class="text-center py-6">No hay categorías registradas.</x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-slot>
            </x-table.table>
        </x-card>
    </x-section>
@endsection