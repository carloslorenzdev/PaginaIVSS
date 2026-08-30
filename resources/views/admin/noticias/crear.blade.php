@extends('layouts/app')

@section('titulo', 'Nueva Noticia')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Nueva Noticia" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel Administrativo
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Nueva Noticia
            </x-breadcrumb.current>
        </x-breadcrumb>

        <x-card class="p-5">
            <x-card.title>
                <i class="bx bx-news"></i>
                Formulario de Noticia
            </x-card.title>

            <form action="{{ route('admin.noticias.guardar') }}" method="POST" enctype="multipart/form-data" class="mt-5 space-y-6">
                @csrf

                {{-- IMAGEN DE PORTADA --}}
                <div>
                    <x-input.label for="archivo" value="Imagen de Portada * (Máx 1 imagen)" />
                    <div class="relative w-full h-48 border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-red-50 hover:border-red-300 transition-all duration-300 overflow-hidden group" id="upload-container">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-full cursor-pointer z-10 relative" id="upload-label">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="bx bx-cloud-upload text-4xl text-gray-400 group-hover:text-red-500 mb-3 transition-colors"></i>
                                <p class="mb-2 text-sm text-gray-500 dark:text-neutral-400">
                                    <span class="font-semibold text-gray-700 dark:text-neutral-200">Haz clic para subir</span> o arrastra y suelta aquí
                                </p>
                                <p class="text-xs text-gray-400 dark:text-neutral-500">JPG, PNG, GIF o WEBP (Recomendado: 800x600 px)</p>
                            </div>
                            <input id="dropzone-file" type="file" name="archivo" accept="image/*" required class="hidden" />
                        </label>
                        
                        <!-- Image Preview Container -->
                        <div id="preview-container" class="absolute inset-0 w-full h-full hidden z-20">
                            <img id="image-preview" src="#" alt="Vista previa" class="w-full h-full object-cover cursor-pointer" />
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                                <button type="button" id="remove-image-btn" class="bg-red-600 text-white rounded-full p-3 hover:bg-red-700 focus:outline-none transition-colors shadow-lg pointer-events-auto">
                                    <i class="bx bx-trash text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <x-input.error campo="archivo" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- TÍTULO --}}
                    <div class="md:col-span-2">
                        <x-input.label for="titulo" value="Título *" />
                        <x-input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required maxlength="255" placeholder="Escribe el título de la noticia..." error />
                    </div>

                    {{-- LEYENDA --}}
                    <div>
                        <x-input.label for="leyenda" value="Créditos/Leyenda de la Imagen" />
                        <x-input type="text" id="leyenda" name="leyenda" value="{{ old('leyenda') }}" maxlength="500" placeholder="Ej. Foto: Archivo IVSS" error />
                    </div>

                    {{-- AUTOR --}}
                    <div>
                        <x-input.label for="creditos_autor" value="Créditos del Autor/Redactor *" />
                        <x-input type="text" id="creditos_autor" name="creditos_autor" value="{{ old('creditos_autor') }}" required maxlength="255" placeholder="Ej. Equipo de Prensa IVSS" error />
                    </div>
                </div>

                {{-- RESUMEN --}}
                <div>
                    <x-input.label for="resumen" value="Resumen corto (Para portadas y tarjetas) *" />
                    <textarea name="resumen" id="resumen" rows="3" required
                        class="w-full py-3 px-4 block border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Escribe un breve resumen de la noticia aquí...">{{ old('resumen') }}</textarea>
                    <x-input.error campo="resumen" />
                </div>

                {{-- CONTENIDO --}}
                <div>
                    <x-input.label for="contenido" value="Cuerpo de la Noticia" />
                    <x-input type="hidden" id="contenido" name="contenido" />
                    {{-- Usando el editor Tiptap incluido en Tiuna --}}
                    <x-editor id="hs-editor-tiptap">
                        {!! old('contenido') !!}
                    </x-editor>
                    <x-input.error campo="contenido" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- ETIQUETAS --}}
                    <div>
                        <x-input.label for="etiquetas" value="Etiquetas (SEO)" />
                        <x-input type="text" id="etiquetas" name="etiquetas" value="{{ old('etiquetas') }}" maxlength="500" placeholder="Ej. salud, pensiones, caracas" error />
                        <p class="text-xs text-gray-500 dark:text-neutral-500 mt-1">Separa las etiquetas con comas.</p>
                    </div>

                    {{-- ENLACE EXTERNO --}}
                    <div>
                        <x-input.label for="enlace_externo" value="Enlace Externo (Opcional)" />
                        <x-input type="url" id="enlace_externo" name="enlace_externo" value="{{ old('enlace_externo') }}" maxlength="500" placeholder="https://ejemplo.com/noticia" error />
                        <p class="text-xs text-gray-500 dark:text-neutral-500 mt-1">Útil si la noticia proviene de otro portal web y quieres que redireccione allí.</p>
                    </div>
                </div>

                {{-- CATEGORÍAS --}}
                <div>
                    <x-input.label for="categorias" value="Categorías *" />
                    <select data-hs-select='{
                            "placeholder": "Seleccione opciones...",
                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400",
                            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-neutral-900 dark:border-neutral-700",
                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-red-600 dark:text-red-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }' name="categorias[]" id="categorias" required multiple class="hidden">
                        <option value="">Seleccionar...</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input.error campo="categorias" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-button.link href="{{ route('admin.panel') }}" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancelar
                    </x-button.link>
                    <x-input.button id="btn-guardar" class="bg-red-600 hover:bg-red-700 focus:bg-red-700">
                        <i class="bx bx-save mr-1"></i>
                        Guardar Noticia
                    </x-input.button>
                </div>
            </form>
        </x-card>
    </x-section>

@endsection

@push('page-scripts')
    @vite(['resources/js/editor-config.js', 'resources/js/upload-preview.js'])
@endpush
