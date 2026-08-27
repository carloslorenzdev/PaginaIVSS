@extends('layouts.app')

@section('titulo', 'Respaldos de Seguridad')

@section('content')
<x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <x-titulo titulo="Respaldos de Seguridad (Backups)" class="text-gradient font-extrabold text-3xl" />
        
        <form action="{{ route('admin.backups.run') }}" method="POST">
            @csrf
            <button type="submit" 
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all transform hover:-translate-y-0.5">
                <i class="bx bx-save text-lg"></i> Generar Respaldo Ahora
            </button>
        </form>
    </div>


    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">Error!</span> {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($backups as $backup)
            <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 relative group">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                    
                    {{-- INFO --}}
                    <div class="flex items-center gap-4">
                        <div class="size-14 rounded-2xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center flex-shrink-0 border border-red-100 dark:border-red-900/50">
                            <i class="bx bxs-file-archive text-3xl text-red-600 dark:text-red-400"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white text-lg">
                                {{ $backup['file_name'] }}
                            </p>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mt-1.5 flex items-center gap-2">
                                <span><i class="bx bx-hdd mr-0.5"></i> {{ $backup['file_size'] }}</span>
                                <span>&bull;</span>
                                <span><i class="bx bx-calendar mr-0.5"></i> {{ $backup['last_modified'] }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- ACCIONES --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.backups.download', $backup['file_name']) }}" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors">
                            <i class="bx bx-download text-lg"></i> Descargar
                        </a>
                        <button type="button" class="btn-confirmar-accion py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition-colors" data-action="{{ route('admin.backups.delete', $backup['file_name']) }}" data-method="DELETE" data-mensaje="¿Estás seguro de eliminar este respaldo?" title="Eliminar">
                            <i class="bx bx-trash text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-16 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 rounded-2xl">
                <div class="size-20 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-5 shadow-sm border border-gray-100 dark:border-neutral-700">
                    <i class="bx bx-folder-open text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No hay respaldos</h3>
                <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Puedes generar uno haciendo clic en "Generar Respaldo Ahora".</p>
            </div>
        @endforelse
    </div>
</x-section>
<x-modal-confirmar />
@endsection
