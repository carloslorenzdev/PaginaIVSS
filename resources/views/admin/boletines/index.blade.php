@extends('layouts/app')

@section('titulo', 'Boletines Informativos')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Boletines Informativos" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Boletines Informativos
            </x-breadcrumb.current>
        </x-breadcrumb>

        <x-card class="p-5">
            <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-neutral-700 pb-3">
                <x-card.title>
                    <i class="bx bx-news"></i> Listado de Boletines
                </x-card.title>
                <x-button.link href="{{ route('admin.boletines.crear') }}" class="bg-red-600 hover:bg-red-700 text-white text-sm">
                    <i class="bx bx-plus mr-1"></i> Subir Boletín
                </x-button.link>
            </div>

            <x-table.table>
                <x-slot name="head">
                    <x-table.th>#</x-table.th>
                    <x-table.th>Título</x-table.th>
                    <x-table.th>Fecha de Publicación</x-table.th>
                    <x-table.th>Archivo</x-table.th>
                    <x-table.th>Estado</x-table.th>
                    <x-table.th>Acciones</x-table.th>
                </x-slot>
                <x-slot name="body">
                    @forelse($boletines as $boletin)
                        <x-table.tr>
                            <x-table.td class="text-center font-medium">{{ $loop->iteration }}</x-table.td>
                            <x-table.td class="font-semibold text-gray-800 dark:text-neutral-200">
                                {{ $boletin->titulo }}
                            </x-table.td>
                            <x-table.td class="text-gray-500">
                                {{ $boletin->fecha_publicacion->format('d/m/Y') }}
                            </x-table.td>
                            <x-table.td class="text-gray-500">
                                <a href="{{ asset('storage/' . $boletin->archivo_pdf) }}" target="_blank" class="text-blue-600 hover:underline">
                                    <i class="bx bxs-file-pdf"></i> Ver PDF
                                </a>
                            </x-table.td>
                            <x-table.td>
                                @if ($boletin->publicado)
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
                                    <form action="{{ route('admin.boletines.publicar', $boletin->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 inline-flex items-center gap-2 rounded-lg border border-transparent font-semibold text-gray-500 hover:text-{{ $boletin->publicado ? 'orange' : 'emerald' }}-600 focus:outline-none transition-all" title="{{ $boletin->publicado ? 'Ocultar' : 'Publicar' }}">
                                            <i class="bx {{ $boletin->publicado ? 'bx-hide' : 'bx-show' }} text-lg"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.boletines.ver', $boletin->id) }}" class="p-2 inline-flex items-center gap-2 rounded-lg border border-transparent font-semibold text-gray-500 hover:text-blue-600 transition-all" title="Editar">
                                        <i class="bx bx-edit text-lg"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.boletines.eliminar', $boletin->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este boletín?');">
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
                            <x-table.td colspan="6" class="text-center py-6">No hay boletines registrados.</x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-slot>
            </x-table.table>

            <div class="mt-4">
                {{ $boletines->links() }}
            </div>
        </x-card>
    </x-section>
@endsection
