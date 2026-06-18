@extends('layouts/app')

@section('titulo', 'Nueva Actividad Anual')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Nueva Actividad Anual" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.item ruta="{{ route('admin.actividades.index') }}" icono="bx bx-calendar-event">
                Actividades Anuales
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Nueva Actividad
            </x-breadcrumb.current>
        </x-breadcrumb>

        <x-card class="p-5 max-w-4xl">
            <x-card.title>
                <i class="bx bx-calendar-plus"></i> Formulario de Actividad
            </x-card.title>

            <form action="{{ route('admin.actividades.guardar') }}" method="POST" enctype="multipart/form-data" class="mt-5 space-y-6">
                @csrf
                
                {{-- TÍTULO --}}
                <div>
                    <x-input.label for="titulo" value="Título de la Actividad *" />
                    <x-input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required placeholder="Ej. Jornada de Salud Integral" error />
                </div>

                {{-- DESCRIPCIÓN --}}
                <div>
                    <x-input.label for="descripcion" value="Descripción (Opcional)" />
                    <x-input type="hidden" id="descripcion" name="descripcion" />
                    {{-- Editor Tiptap incluido en Tiuna --}}
                    <x-editor id="hs-editor-tiptap">
                        {!! old('descripcion') !!}
                    </x-editor>
                    <p class="text-xs text-gray-500 dark:text-neutral-500 mt-1">Puedes incluir enlaces y detalles extensos de la actividad.</p>
                    <x-input.error campo="descripcion" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- IMAGEN/VIDEO PRINCIPAL --}}
                    <div>
                        <x-input.label for="archivo" value="Imagen/Video Principal (Opcional)" />
                        <input type="file" id="archivo" name="archivo" accept=".jpg,.jpeg,.png,.webp,.gif,.mp4,.avi" 
                            class="block w-full text-sm text-gray-500 dark:text-neutral-400
                            file:me-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-red-600 file:text-white
                            hover:file:bg-red-700
                            file:disabled:opacity-50 file:disabled:pointer-events-none
                            dark:file:bg-red-500
                            dark:hover:file:bg-red-400">
                        <p class="text-xs text-gray-500 dark:text-neutral-500 mt-1">Esta será la imagen o video que se mostrará en el carrusel. Max 50MB.</p>
                        <x-input.error campo="archivo" />
                    </div>

                    {{-- DOCUMENTO ADJUNTO --}}
                    <div>
                        <x-input.label for="documento_adjunto" value="Documento Adjunto (Opcional)" />
                        <input type="file" id="documento_adjunto" name="documento_adjunto" accept=".pdf,.doc,.docx" 
                            class="block w-full text-sm text-gray-500 dark:text-neutral-400
                            file:me-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700
                            file:disabled:opacity-50 file:disabled:pointer-events-none
                            dark:file:bg-blue-500
                            dark:hover:file:bg-blue-400">
                        <p class="text-xs text-gray-500 dark:text-neutral-500 mt-1">Sube un documento (PDF, Word) para agregar un botón de descarga. Max 50MB.</p>
                        <x-input.error campo="documento_adjunto" />
                    </div>
                </div>

                {{-- VISIBILIDAD --}}
                <div class="bg-gray-50 dark:bg-neutral-800 p-4 rounded-lg border border-gray-200 dark:border-neutral-700">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="activa" value="1" class="shrink-0 mt-0.5 border-gray-300 rounded text-red-600 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-red-500 dark:checked:border-red-500">
                        <div>
                            <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">Activar Visualización</span>
                            <span class="block text-xs text-gray-500 dark:text-neutral-400">Si está marcado, esta actividad aparecerá inmediatamente en la página principal.</span>
                        </div>
                    </label>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-button.link href="{{ route('admin.actividades.index') }}" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancelar
                    </x-button.link>
                    <x-input.button id="btn-guardar" class="bg-red-600 hover:bg-red-700 focus:bg-red-700">
                        <i class="bx bx-save mr-1"></i>
                        Guardar Actividad
                    </x-input.button>
                </div>
            </form>
        </x-card>
    </x-section>
@endsection

@push('page-scripts')
    @vite(['resources/js/editor-config.js'])
@endpush
