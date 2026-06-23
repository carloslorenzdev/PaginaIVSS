@extends('layouts/app')

@section('titulo', 'Editar Boletín Informativo')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Editar Boletín" />
        <x-breadcrumb>
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

        <x-card class="p-5 max-w-3xl mx-auto">
            <x-card.title class="mb-4 border-b pb-2"><i class="bx bx-edit"></i> Actualizar Detalles</x-card.title>

            <form action="{{ route('admin.boletines.actualizar', $boletin->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="form-boletin">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <x-input.label for="titulo" required>Título del Boletín</x-input.label>
                    <x-input.input type="text" id="titulo" name="titulo" value="{{ old('titulo', $boletin->titulo) }}" required />
                    @error('titulo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-input.label for="fecha_publicacion" required>Fecha de Publicación</x-input.label>
                    <x-input.input type="date" id="fecha_publicacion" name="fecha_publicacion" value="{{ old('fecha_publicacion', $boletin->fecha_publicacion->format('Y-m-d')) }}" required />
                    @error('fecha_publicacion') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- UI de progreso de extracción -->
                <div id="extraction_ui" class="hidden bg-blue-50 p-4 rounded-lg border border-blue-100 mt-4">
                    <h4 class="text-sm font-semibold text-blue-800 mb-2"><i class="bx bx-cog bx-spin mr-1"></i> Extracción Automática en progreso...</h4>
                    <p class="text-xs text-blue-600" id="extraction_status">Leyendo documento PDF...</p>
                    <div class="mt-3 flex gap-4 hidden" id="extraction_result">
                        <div class="w-1/3">
                            <p class="text-xs font-semibold text-gray-600 mb-1">Nueva Portada:</p>
                            <img id="preview_img" src="" alt="Portada extraída" class="w-full border rounded shadow-sm object-cover">
                        </div>
                        <div class="w-2/3">
                            <p class="text-xs font-semibold text-gray-600 mb-1">Nueva Descripción extraída:</p>
                            <p class="text-xs text-gray-700 bg-white p-2 rounded border border-gray-200" id="preview_text"></p>
                        </div>
                    </div>
                </div>
                <!-- Hidden input para la imagen -->
                <input type="hidden" id="imagen_base64" name="imagen_base64" value="">

                <div class="pt-4 border-t flex justify-between">
                    <div>
                        <!-- Botón fantasma para espacio si es necesario -->
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.boletines.index') }}" class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium rounded-lg border border-transparent bg-gray-200 text-gray-800 hover:bg-gray-300 focus:outline-none focus:bg-gray-300">
                            Cancelar
                        </a>
                        <button type="submit" id="btn_guardar" class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                            <i class="bx bx-save mr-1"></i> <span id="btn_text">Actualizar</span>
                        </button>
                    </div>
                </div>
            </form>
        </x-card>
    </x-section>

    <script type="module" src="{{ asset('js/pdf-extractor.js') }}"></script>
@endsection
