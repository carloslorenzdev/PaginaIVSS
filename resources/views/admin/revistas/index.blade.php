@extends('layouts/app')

@section('titulo', 'Revistas Digitales')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Revistas Digitales" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Revistas Digitales
            </x-breadcrumb.current>
        </x-breadcrumb>

        <x-card class="p-5">
            <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-neutral-700 pb-3">
                <x-card.title>
                    <i class="bx bx-book-open"></i> Listado de Revistas
                </x-card.title>
                <x-button.link href="{{ route('admin.revistas.crear') }}" class="bg-red-600 hover:bg-red-700 text-white text-sm">
                    <i class="bx bx-plus mr-1"></i> Subir Revista
                </x-button.link>
            </div>

            <x-table.table>
                <x-slot name="head">
                    <x-table.th>#</x-table.th>
                    <x-table.th>Título</x-table.th>
                    <x-table.th>Edición</x-table.th>
                    <x-table.th>Fecha de Publicación</x-table.th>
                    <x-table.th>Archivo</x-table.th>
                    <x-table.th>Estado</x-table.th>
                    <x-table.th>Acciones</x-table.th>
                </x-slot>
                <x-slot name="body">
                    @forelse($revistas as $revista)
                        <x-table.tr>
                            <x-table.td class="text-center font-medium">{{ $loop->iteration }}</x-table.td>
                            <x-table.td class="font-semibold text-gray-800 dark:text-neutral-200">
                                {{ $revista->titulo }}
                            </x-table.td>
                            <x-table.td class="text-gray-500">
                                {{ $revista->edicion ?? 'N/A' }}
                            </x-table.td>
                            <x-table.td class="text-gray-500">
                                {{ $revista->fecha_publicacion->format('d/m/Y') }}
                            </x-table.td>
                            <x-table.td class="text-gray-500">
                                <a href="{{ asset('storage/' . $revista->archivo_pdf) }}" target="_blank" class="text-blue-600 hover:underline">
                                    <i class="bx bxs-file-pdf"></i> Ver PDF
                                </a>
                            </x-table.td>
                            <x-table.td>
                                @if ($revista->publicado)
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-500">
                                        <span class="w-1.5 h-1.5 inline-block bg-emerald-500 rounded-full"></span>
                                        Publicado
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">
                                        <span class="w-1.5 h-1.5 inline-block bg-gray-500 rounded-full"></span>
                                        Borrador
                                    </span>
                                @endif
                            </x-table.td>
                            <x-table.td>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.revistas.publicar', $revista->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 inline-flex items-center gap-2 rounded-lg border border-transparent font-semibold text-gray-500 hover:text-{{ $revista->publicado ? 'orange' : 'emerald' }}-600 focus:outline-none transition-all" title="{{ $revista->publicado ? 'Ocultar' : 'Publicar' }}">
                                            <i class="bx {{ $revista->publicado ? 'bx-hide' : 'bx-show' }} text-lg"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.revistas.ver', $revista->id) }}" class="p-2 inline-flex items-center gap-2 rounded-lg border border-transparent font-semibold text-gray-500 hover:text-blue-600 transition-all" title="Editar">
                                        <i class="bx bx-edit text-lg"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.revistas.eliminar', $revista->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta revista?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 inline-flex items-center gap-2 rounded-lg border border-transparent font-semibold text-gray-500 hover:text-red-600 transition-all" title="Eliminar">
                                            <i class="bx bx-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="7" class="text-center py-6">No hay revistas registradas.</x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-slot>
            </x-table.table>

            <div class="mt-4">
                {{ $revistas->links() }}
            </div>
        </x-card>
    </x-section>
@endsection
