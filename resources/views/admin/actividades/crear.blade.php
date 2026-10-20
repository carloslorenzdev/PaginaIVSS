@extends('layouts/app')

@section('titulo', 'Nueva Actividad Anual')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div>
            <x-titulo titulo="Nueva Actividad Anual" class="text-gradient font-extrabold text-3xl" />
            <x-breadcrumb class="mt-2">
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
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-700 overflow-hidden max-w-4xl">
            <div class="border-b border-gray-100 dark:border-neutral-700 px-6 py-4 bg-gray-50/50 dark:bg-neutral-800/50">
                <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center">
                        <i class="bx bx-calendar-plus text-lg"></i>
                    </div>
                    Formulario de Actividad
                </h3>
            </div>

            <form action="{{ route('admin.actividades.guardar') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                @csrf
                
                {{-- TÍTULO --}}
                <div>
                    <x-input.label for="titulo" value="Título de la Actividad *" class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block" />
                    <x-input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required placeholder="Ej. Jornada de Salud Integral" class="rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500" error />
                </div>

                {{-- DESCRIPCIÓN --}}
                <div>
                    <x-input.label for="descripcion" value="Descripción (Opcional)" class="font-semibold text-gray-700 dark:text-neutral-300 mb-1 block" />
                    <x-input type="hidden" id="descripcion" name="descripcion" />
                    <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-neutral-700">
                        <x-editor id="hs-editor-tiptap">
                            {!! clean(old('descripcion')) !!}
                        </x-editor>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-neutral-500 mt-2"><i class="bx bx-info-circle"></i> Puedes incluir enlaces y detalles extensos de la actividad.</p>
                    <x-input.error campo="descripcion" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- IMAGEN/VIDEO PRINCIPAL --}}
                    <div class="bg-gray-50/50 dark:bg-neutral-900/20 p-4 rounded-xl border border-gray-100 dark:border-neutral-700/50">
                        <x-input.label for="archivo" value="Imagen/Video Principal (Opcional)" class="font-semibold text-gray-700 dark:text-neutral-300 mb-2 block" />
                        <input type="file" id="archivo" name="archivo" accept=".jpg,.jpeg,.png,.webp,.gif,.mp4,.avi" 
                            class="block w-full text-sm text-gray-500 dark:text-neutral-400
                            file:mr-4 file:py-2.5 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-red-50 file:text-red-700
                            hover:file:bg-red-100
                            file:disabled:opacity-50 file:disabled:pointer-events-none
                            dark:file:bg-red-900/30
                            dark:hover:file:bg-red-900/50 dark:file:text-red-400 file:transition-colors">
                        <p class="text-xs text-gray-500 dark:text-neutral-500 mt-2"><i class="bx bx-image"></i> Esta será la imagen o video que se mostrará en el carrusel. Max 50MB.</p>
                        <x-input.error campo="archivo" />
                    </div>

                    {{-- DOCUMENTO ADJUNTO --}}
                    <div class="bg-gray-50/50 dark:bg-neutral-900/20 p-4 rounded-xl border border-gray-100 dark:border-neutral-700/50">
                        <x-input.label for="documento_adjunto" value="Documento Adjunto (Opcional)" class="font-semibold text-gray-700 dark:text-neutral-300 mb-2 block" />
                        <input type="file" id="documento_adjunto" name="documento_adjunto" accept=".pdf,.doc,.docx" 
                            class="block w-full text-sm text-gray-500 dark:text-neutral-400
                            file:mr-4 file:py-2.5 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                            file:disabled:opacity-50 file:disabled:pointer-events-none
                            dark:file:bg-blue-900/30
                            dark:hover:file:bg-blue-900/50 dark:file:text-blue-400 file:transition-colors">
                        <p class="text-xs text-gray-500 dark:text-neutral-500 mt-2"><i class="bx bx-file"></i> Sube un documento (PDF, Word) para agregar un botón de descarga. Max 50MB.</p>
                        <x-input.error campo="documento_adjunto" />
                    </div>
                </div>

                {{-- VISIBILIDAD --}}
                <div class="bg-red-50/30 dark:bg-red-900/10 p-5 rounded-xl border border-red-100 dark:border-red-900/30">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="activa" value="1" class="shrink-0 mt-1 size-5 border-gray-300 rounded text-red-600 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-red-500 dark:checked:border-red-500 transition-all">
                        <div>
                            <span class="block text-sm font-bold text-gray-900 dark:text-white">Activar Visualización Pública</span>
                            <span class="block text-sm text-gray-500 dark:text-neutral-400 mt-0.5">Si está marcado, esta actividad aparecerá inmediatamente en la página principal.</span>
                        </div>
                    </label>
                </div>

                <div class="pt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-neutral-700">
                    <x-button.link href="{{ route('admin.actividades.index') }}" 
                        class="rounded-xl py-2.5 px-5 font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                        Cancelar
                    </x-button.link>
                    <button type="submit" 
                        class="rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white hover:from-red-700 hover:to-red-600 shadow-md hover:shadow-lg shadow-red-500/30 hover:-translate-y-0.5 transition-all duration-300 font-semibold px-5 py-2.5 flex items-center gap-2">
                        <i class="bx bx-save text-lg"></i>
                        Guardar Actividad
                    </button>
                </div>
            </form>
        </div>
    </x-section>
@endsection

@push('page-scripts')
    @vite(['resources/js/editor-config.js'])
@endpush
