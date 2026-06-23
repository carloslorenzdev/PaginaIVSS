@extends('layouts/app')

@section('titulo', 'Subir Revista Digital')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Subir Revista" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.item ruta="{{ route('admin.revistas.index') }}" icono="bx bx-book-open">
                Revistas
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Subir
            </x-breadcrumb.current>
        </x-breadcrumb>

        <x-card class="p-5 max-w-3xl mx-auto">
            <x-card.title class="mb-4 border-b pb-2"><i class="bx bx-upload"></i> Detalles de la Revista</x-card.title>

            <form action="{{ route('admin.revistas.guardar') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="form-revista">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input.label for="titulo" required>Título de la Revista</x-input.label>
                        <x-input.input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required placeholder="Ej. Revista Institucional" />
                        @error('titulo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input.label for="edicion">Edición (Opcional)</x-input.label>
                        <x-input.input type="text" id="edicion" name="edicion" value="{{ old('edicion') }}" placeholder="Ej. Edición N° 15" />
                        @error('edicion') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <x-input.label for="fecha_publicacion" required>Fecha de Publicación</x-input.label>
                    <x-input.input type="date" id="fecha_publicacion" name="fecha_publicacion" value="{{ old('fecha_publicacion', date('Y-m-d')) }}" required />
                    @error('fecha_publicacion') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-input.label for="archivo_pdf" required>Archivo PDF</x-input.label>
                    <input type="file" id="archivo_pdf" name="archivo_pdf" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                    <p class="text-xs text-gray-500 mt-1">Solo formato PDF. Tamaño máximo 20MB.</p>
                    @error('archivo_pdf') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Hidden input para la imagen extraída por JS -->
                <input type="hidden" id="imagen_base64" name="imagen_base64" value="">

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('admin.revistas.index') }}" class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium rounded-lg border border-transparent bg-gray-200 text-gray-800 hover:bg-gray-300 focus:outline-none focus:bg-gray-300">
                        Cancelar
                    </a>
                    <button type="submit" id="btn_guardar" class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                        <i class="bx bx-save mr-1"></i> <span id="btn_text">Guardar Revista</span>
                    </button>
                </div>
            </form>
        </x-card>
    </x-section>

    <!-- Usamos el mismo script que extrae las portadas de los PDF limpiamente -->
    <script type="module" src="{{ asset('js/pdf-extractor.js') }}?v={{ time() }}"></script>
@endsection
