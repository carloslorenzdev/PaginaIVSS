@extends('layouts/app')

@section('titulo', 'Subir Revista Digital')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div>
            <x-titulo titulo="Subir Revista" class="text-gradient font-extrabold text-3xl" />
            <x-breadcrumb class="mt-2">
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
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden max-w-3xl mx-auto">
            <div class="border-b border-gray-100 dark:border-neutral-700 px-6 py-4 bg-gray-50/50 dark:bg-neutral-800/50">
                <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-teal-100 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center">
                        <i class="bx bx-upload text-lg"></i>
                    </div>
                    Detalles de la Revista
                </h3>
            </div>

            <form action="{{ route('admin.revistas.guardar') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6" id="form-revista">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900/50 text-red-600 dark:text-red-400 p-4 rounded-xl mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-input.label for="titulo" required class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block">Título de la Revista</x-input.label>
                        <x-input.input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required placeholder="Ej. Revista Institucional" class="rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500" />
                        @error('titulo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input.label for="edicion" class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block">Edición (Opcional)</x-input.label>
                        <x-input.input type="text" id="edicion" name="edicion" value="{{ old('edicion') }}" placeholder="Ej. Edición N° 15" class="rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500" />
                        @error('edicion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <x-input.label for="fecha_publicacion" required class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block">Fecha de Publicación</x-input.label>
                    <x-input.input type="date" id="fecha_publicacion" name="fecha_publicacion" value="{{ old('fecha_publicacion', date('Y-m-d')) }}" required class="rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500" />
                    @error('fecha_publicacion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="bg-gray-50/50 dark:bg-neutral-900/20 p-4 rounded-xl border border-gray-100 dark:border-neutral-700/50">
                    <x-input.label for="archivo_pdf" required class="font-semibold text-gray-700 dark:text-neutral-300 mb-2 block">Archivo PDF</x-input.label>
                    <input type="file" id="archivo_pdf" name="archivo_pdf" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 file:transition-colors dark:file:bg-teal-900/30 dark:file:text-teal-400 dark:hover:file:bg-teal-900/50" required>
                    <p class="text-xs text-gray-500 mt-2"><i class="bx bx-info-circle"></i> Solo formato PDF. Tamaño máximo 20MB.</p>
                    @error('archivo_pdf') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Hidden input para la imagen extraída por JS -->
                <input type="hidden" id="imagen_base64" name="imagen_base64" value="">

                <div class="pt-6 border-t border-gray-100 dark:border-neutral-700 flex justify-end gap-3">
                    <a href="{{ route('admin.revistas.index') }}" class="rounded-xl py-2.5 px-5 font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                        Cancelar
                    </a>
                    <button type="submit" id="btn_guardar" class="rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white hover:from-teal-700 hover:to-teal-600 shadow-md hover:shadow-lg shadow-teal-500/30 hover:-translate-y-0.5 transition-all duration-300 font-semibold px-5 py-2.5 flex items-center gap-2">
                        <i class="bx bx-save text-lg"></i> <span id="btn_text">Guardar Revista</span>
                    </button>
                </div>
            </form>
        </div>
    </x-section>

    <!-- Usamos el mismo script que extrae las portadas de los PDF limpiamente -->
    <script type="module" src="{{ asset('js/pdf-extractor.js') }}?v={{ filemtime(public_path('js/pdf-extractor.js')) }}"></script>
@endsection
