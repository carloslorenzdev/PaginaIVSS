@extends('layouts/app')

@section('titulo', 'Editar Boletín Informativo')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div>
            <x-titulo titulo="Editar Boletín" class="text-gradient font-extrabold text-3xl" />
            <x-breadcrumb class="mt-2">
                <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                    Panel
                </x-breadcrumb.item>
                <x-breadcrumb.item ruta="{{ route('admin.boletines.index') }}" icono="bx bx-news">
                    Boletines
                </x-breadcrumb.item>
                <x-breadcrumb.current>
                    Editar
                </x-breadcrumb.current>
            </x-breadcrumb>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden max-w-3xl mx-auto">
            <div class="border-b border-gray-100 dark:border-neutral-700 px-6 py-4 bg-gray-50/50 dark:bg-neutral-800/50">
                <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center">
                        <i class="bx bx-edit text-lg"></i>
                    </div>
                    Actualizar Detalles
                </h3>
            </div>

            <form action="{{ route('admin.boletines.actualizar', $boletin->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6" id="form-boletin">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900/50 text-red-600 dark:text-red-400 p-4 rounded-xl mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <x-input.label for="titulo" required class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block">Título del Boletín</x-input.label>
                    <x-input.input type="text" id="titulo" name="titulo" value="{{ old('titulo', $boletin->titulo) }}" required class="rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" />
                    @error('titulo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-input.label for="fecha_publicacion" required class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block">Fecha de Publicación</x-input.label>
                    <x-input.input type="date" id="fecha_publicacion" name="fecha_publicacion" value="{{ old('fecha_publicacion', $boletin->fecha_publicacion->format('Y-m-d')) }}" required class="rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" />
                    @error('fecha_publicacion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- UI de progreso de extracción -->
                <div id="extraction_ui" class="hidden bg-blue-50/50 dark:bg-blue-900/20 p-5 rounded-xl border border-blue-100 dark:border-blue-900/30 mt-4 transition-all">
                    <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-400 mb-3 flex items-center"><i class="bx bx-loader-alt bx-spin mr-2 text-lg"></i> Extracción Automática en progreso...</h4>
                    <p class="text-xs text-blue-600 dark:text-blue-500" id="extraction_status">Leyendo documento PDF...</p>
                    <div class="mt-4 flex flex-col sm:flex-row gap-5 hidden" id="extraction_result">
                        <div class="w-full sm:w-1/3">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-2">Nueva Portada</p>
                            <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-neutral-700 shadow-sm">
                                <img id="preview_img" src="" alt="Portada extraída" class="w-full object-cover">
                            </div>
                        </div>
                        <div class="w-full sm:w-2/3">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-2">Texto Extraído</p>
                            <p class="text-xs text-gray-700 dark:text-neutral-300 bg-white dark:bg-neutral-900 p-3 rounded-lg border border-gray-200 dark:border-neutral-700 max-h-40 overflow-y-auto" id="preview_text"></p>
                        </div>
                    </div>
                </div>
                <!-- Hidden input para la imagen -->
                <input type="hidden" id="imagen_base64" name="imagen_base64" value="">

                <div class="pt-6 border-t border-gray-100 dark:border-neutral-700 flex justify-end gap-3">
                    <a href="{{ route('admin.boletines.index') }}" class="rounded-xl py-2.5 px-5 font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                        Cancelar
                    </a>
                    <button type="submit" id="btn_guardar" class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white hover:from-blue-700 hover:to-blue-600 shadow-md hover:shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 transition-all duration-300 font-semibold px-5 py-2.5 flex items-center gap-2">
                        <i class="bx bx-sync text-lg"></i> <span id="btn_text">Actualizar</span>
                    </button>
                </div>
            </form>
        </div>
    </x-section>

    <script type="module" src="{{ asset('js/pdf-extractor.js') }}?v={{ filemtime(public_path('js/pdf-extractor.js')) }}"></script>
@endsection
