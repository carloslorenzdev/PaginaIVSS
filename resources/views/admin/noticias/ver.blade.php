@extends('layouts/app')

@section('titulo', $noticia->titulo)

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Detalle de Noticia" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                {{ str()->limit($noticia->titulo, 30) }}
            </x-breadcrumb.current>
        </x-breadcrumb>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-5">
            {{-- INFORMACIÓN DE LA NOTICIA (EDICIÓN) --}}
            <div class="lg:col-span-3 space-y-6">
                <form action="{{ route('admin.noticias.actualizar', $noticia->id) }}" method="POST" id="form-actualizar-noticia" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <x-card class="p-5 overflow-hidden relative">
                        <div class="flex items-center justify-between mb-4 flex-wrap gap-2 pb-4 border-b border-gray-200 dark:border-neutral-700">
                            <div class="flex items-center gap-2 flex-wrap">
                                {{-- Badge de estado --}}
                                @if($noticia->publicado)
                                    <x-badge color="teal">
                                        <i class="bx bx-check-circle mr-1"></i> Publicada
                                    </x-badge>
                                @else
                                    <x-badge color="yellow">
                                        <i class="bx bx-time mr-1"></i> Borrador
                                    </x-badge>
                                @endif

                                {{-- Botones de acción para aprobadores --}}
                                @hasanyrole('admin|aprobador')
                                    @if($noticia->publicado)
                                        <button type="button"
                                            data-ver-accion="despublicar"
                                            class="py-1.5 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-yellow-500 text-white hover:bg-yellow-600 transition-all">
                                            <i class="bx bx-hide"></i> Despublicar
                                        </button>
                                    @else
                                        <button type="button"
                                            data-ver-accion="aprobar"
                                            class="py-1.5 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 transition-all">
                                            <i class="bx bx-check-shield"></i> Aprobar y publicar
                                        </button>
                                    @endif
                                @endhasanyrole

                                {{-- Botón eliminar (solo Admin) --}}
                                @hasanyrole('admin')
                                    <button type="button"
                                        data-ver-accion="eliminar"
                                        class="py-1.5 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400 transition-all">
                                        <i class="bx bx-trash"></i> Eliminar
                                    </button>
                                @endhasanyrole
                            </div>
                            
                            {{-- Botón Guardar Cambios --}}
                            @hasanyrole('admin|redactor')
                            <div>
                                <x-input.button type="submit" class="bg-red-600 hover:bg-red-700 focus:bg-red-700">
                                    <i class="bx bx-save mr-1"></i> Guardar Cambios
                                </x-input.button>
                            </div>
                            @endhasanyrole
                        </div>

                        @php
                            $imagenPrincipal = $noticia->medios->where('pivot.tipo_relacion', 'principal')->first() ?? $noticia->medios->first();
                        @endphp

                        <div class="mb-6">
                            <x-input.label for="archivo" value="Imagen de Portada (Haz clic o arrastra para reemplazar la actual)" />
                            <div class="relative w-full h-80 lg:h-[400px] border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-red-50 hover:border-red-300 transition-all duration-300 overflow-hidden group" id="upload-container">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-full cursor-pointer z-10 relative" id="upload-label" style="{{ $imagenPrincipal ? 'display: none;' : '' }}">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="bx bx-cloud-upload text-4xl text-gray-400 group-hover:text-red-500 mb-3 transition-colors"></i>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-neutral-400">
                                            <span class="font-semibold text-gray-700 dark:text-neutral-200">Haz clic para subir una nueva imagen</span>
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-neutral-500">Si dejas esto vacío, se mantendrá la imagen actual.</p>
                                    </div>
                                    <input type="hidden" name="eliminar_imagen" id="eliminar_imagen_input" value="0">
                                    <input id="dropzone-file" type="file" name="archivo" accept="image/*" class="hidden" />
                                </label>
                                
                                <!-- Image Preview Container -->
                                <div id="preview-container" class="absolute inset-0 w-full h-full z-20" style="{{ !$imagenPrincipal ? 'display: none;' : '' }}">
                                    <img id="image-preview" src="{{ $imagenPrincipal ? asset('storage/' . $imagenPrincipal->ruta) : '#' }}" alt="Vista previa" class="w-full h-full object-cover cursor-pointer" />
                                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                                        <button type="button" id="remove-image-btn" class="bg-red-600 text-white rounded-full p-3 hover:bg-red-700 focus:outline-none transition-colors shadow-lg pointer-events-auto">
                                            <i class="bx bx-trash text-xl"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <x-input.error campo="archivo" />

                            <div class="mt-3">
                                <x-input.label for="leyenda" value="Créditos/Leyenda de la Imagen" />
                                <x-input type="text" id="leyenda" name="leyenda" value="{{ old('leyenda', $imagenPrincipal ? $imagenPrincipal->leyenda : '') }}" maxlength="500" placeholder="Ej. Foto: Archivo IVSS" error />
                            </div>
                        </div>

                        <div class="space-y-5">
                            {{-- TÍTULO --}}
                            <div>
                                <x-input.label for="titulo" value="Título *" />
                                <x-input type="text" id="titulo" name="titulo" value="{{ old('titulo', $noticia->titulo) }}" required maxlength="255" placeholder="Escribe el título de la noticia..." error />
                            </div>

                            {{-- AUTOR Y FECHAS --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input.label for="creditos_autor" value="Créditos del Autor/Redactor *" />
                                    <x-input type="text" id="creditos_autor" name="creditos_autor" value="{{ old('creditos_autor', $noticia->creditos_autor) }}" required maxlength="255" error />
                                </div>
                                <div>
                                    <x-input.label value="Fecha de Creación" />
                                    <x-input type="text" disabled value="{{ $noticia->created_at->format('d/m/Y H:i') }}" class="bg-gray-100" />
                                </div>
                            </div>

                            {{-- RESUMEN --}}
                            <div>
                                <x-input.label for="resumen" value="Resumen corto *" />
                                <textarea name="resumen" id="resumen" rows="3" required
                                    class="w-full py-3 px-4 block border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Escribe un breve resumen...">{{ old('resumen', $noticia->resumen) }}</textarea>
                                <x-input.error campo="resumen" />
                            </div>

                            {{-- CONTENIDO --}}
                            <div>
                                <x-input.label for="contenido" value="Cuerpo de la Noticia" />
                                <x-input type="hidden" id="contenido" name="contenido" value="{{ old('contenido', $noticia->contenido) }}" />
                                <x-editor id="hs-editor-tiptap">
                                    {!! old('contenido', $noticia->contenido) !!}
                                </x-editor>
                                <x-input.error campo="contenido" />
                            </div>

                            {{-- ETIQUETAS Y ENLACES --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input.label for="etiquetas" value="Etiquetas (SEO)" />
                                    <x-input type="text" id="etiquetas" name="etiquetas" value="{{ old('etiquetas', $noticia->etiquetas) }}" maxlength="500" placeholder="Ej. salud, pensiones" error />
                                </div>
                                <div>
                                    <x-input.label for="enlace_externo" value="Enlace Externo (Opcional)" />
                                    <x-input type="url" id="enlace_externo" name="enlace_externo" value="{{ old('enlace_externo', $noticia->enlace_externo) }}" maxlength="500" placeholder="https://ejemplo.com" error />
                                </div>
                            </div>

                            {{-- CATEGORÍAS --}}
                            <div>
                                <x-input.label for="categorias" value="Categorías *" />
                                @php
                                    $noticiaCats = $noticia->categorias->pluck('id')->toArray();
                                @endphp
                                <select name="categorias[]" id="categorias" required multiple size="4"
                                    class="w-full py-3 px-4 block border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ in_array($categoria->id, old('categorias', $noticiaCats)) ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Presiona Ctrl (Windows) o Cmd (Mac) para seleccionar varias categorías.</p>
                                <x-input.error campo="categorias" />
                            </div>
                        </div>
                    </x-card>
                </form>
            </div>


        </div>
    </x-section>

    {{-- ================================================================ --}}
    {{-- MODAL: ELIMINAR NOTICIA (solo Admin)                             --}}
    {{-- ================================================================ --}}
    @hasanyrole('admin')
    <div id="modal-eliminar" style="display:none;position:fixed;inset:0;z-index:70;align-items:center;justify-content:center;padding:1rem;">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" data-ver-accion="cerrar-eliminar"></div>
        <div class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl w-full max-w-md p-6 animate-modal">
            <div class="flex items-center gap-3 mb-4">
                <div class="size-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-trash text-2xl text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Eliminar Noticia</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-2">¿Confirmas que deseas eliminar permanentemente la noticia:</p>
            <p class="font-semibold text-gray-900 dark:text-white mb-5 italic">"{{ $noticia->titulo }}"</p>
            <p class="text-xs text-red-600 dark:text-red-400 mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                <i class="bx bx-error-circle mr-1"></i>
                Se eliminarán también todos los archivos y medios asociados a esta noticia.
            </p>
            <form action="{{ route('admin.noticias.eliminar', $noticia->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3 justify-end">
                    <button type="button" data-ver-accion="cerrar-eliminar"
                        class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="py-2 px-4 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-trash"></i> Eliminar permanentemente
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endhasanyrole

    {{-- ================================================================ --}}
    {{-- MODAL: DESPUBLICAR (Admin y Aprobador)                           --}}
    {{-- ================================================================ --}}
    @if($noticia->publicado)
    @hasanyrole('admin|aprobador')
    <div id="modal-despublicar" style="display:none;position:fixed;inset:0;z-index:70;align-items:center;justify-content:center;padding:1rem;">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" data-ver-accion="cerrar-despublicar"></div>
        <div class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl w-full max-w-md p-6 animate-modal">
            <div class="flex items-center gap-3 mb-5">
                <div class="size-12 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-hide text-2xl text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Regresar a Borrador</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">La noticia dejará de ser visible al público</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-5">
                ¿Confirmas que deseas despublicar <span class="font-semibold">"{{ $noticia->titulo }}"</span>?
                Pasará a estado <span class="font-semibold text-yellow-600">Borrador</span> y ya no será visible en el sitio web.
            </p>
            <form action="{{ route('admin.noticias.publicar', $noticia->id) }}" method="POST">
                @csrf
                <div class="flex gap-3 justify-end">
                    <button type="button" data-ver-accion="cerrar-despublicar"
                        class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="py-2 px-4 text-sm font-semibold rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-hide"></i> Sí, despublicar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endhasanyrole
    @endif

    {{-- ================================================================ --}}
    {{-- MODAL: APROBACIÓN MULTI-PASO (Admin y Aprobador, solo borrador) --}}
    {{-- ================================================================ --}}
    @if(!$noticia->publicado)
    @hasanyrole('admin|aprobador')
    <div id="modal-aprobar" style="display:none;position:fixed;inset:0;z-index:70;align-items:center;justify-content:center;padding:1rem;">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl w-full max-w-lg animate-modal">

            {{-- Header del modal --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                <div class="flex items-center gap-3">
                    <div class="size-9 rounded-full bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                        <i class="bx bx-check-shield text-lg text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-base">Aprobar Publicación</h3>
                        <div class="flex gap-1 mt-0.5">
                            <span class="step-dot w-6 h-1.5 rounded-full bg-teal-500 transition-all duration-300"></span>
                            <span class="step-dot w-2 h-1.5 rounded-full bg-gray-300 dark:bg-neutral-600 transition-all duration-300"></span>
                            <span class="step-dot w-2 h-1.5 rounded-full bg-gray-300 dark:bg-neutral-600 transition-all duration-300"></span>
                        </div>
                    </div>
                </div>
                <button type="button" data-ver-accion="cerrar-aprobar" class="text-gray-400 hover:text-gray-600 dark:hover:text-neutral-200 transition-colors">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>

            <form action="{{ route('admin.noticias.publicar', $noticia->id) }}" method="POST">
                @csrf

                <div class="px-6 py-5 min-h-[280px]">

                    {{-- PASO 1: Confirmación de lectura --}}
                    <div id="aprobar-paso-1" class="aprobar-paso">
                        <div class="text-center mb-5">
                            <div class="size-16 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center mx-auto mb-3">
                                <i class="bx bx-book-reader text-3xl text-blue-500"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg">Paso 1 de 3 — Revisión de contenido</h4>
                            <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Antes de aprobar, confirma que revisaste el contenido completo</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-neutral-900/50 border border-gray-200 dark:border-neutral-700 rounded-xl p-4 mb-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-400 mb-1">Noticia a aprobar:</p>
                            <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $noticia->titulo }}</p>
                            @if($noticia->resumen)
                            <p class="text-xs text-gray-500 dark:text-neutral-500 mt-1 line-clamp-2">{{ $noticia->resumen }}</p>
                            @endif
                        </div>
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" id="confirm-lectura"
                                class="mt-0.5 shrink-0 border-gray-300 rounded text-teal-600 focus:ring-teal-500 dark:bg-neutral-800 dark:border-neutral-600">
                            <span class="text-sm text-gray-700 dark:text-neutral-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
                                Confirmo que he leído y revisado el contenido completo de esta noticia y está lista para su publicación.
                            </span>
                        </label>
                    </div>

                    {{-- PASO 2: Fecha de publicación --}}
                    <div id="aprobar-paso-2" class="aprobar-paso hidden">
                        <div class="text-center mb-5">
                            <div class="size-16 rounded-full bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center mx-auto mb-3">
                                <i class="bx bx-calendar-event text-3xl text-purple-500"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg">Paso 2 de 3 — Fecha de publicación</h4>
                            <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Elige cuándo será visible esta noticia</p>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all border-teal-500 bg-teal-50 dark:bg-teal-900/20" id="opcion-inmediata-label">
                                <input type="radio" name="tipo_fecha" value="inmediata" class="text-teal-600 focus:ring-teal-500" checked>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Publicar ahora mismo</p>
                                    <p class="text-xs text-gray-500 dark:text-neutral-400">La noticia será visible de inmediato</p>
                                </div>
                                <i class="bx bx-rocket text-xl text-teal-500 ml-auto"></i>
                            </label>
                            <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all border-gray-200 dark:border-neutral-600 hover:border-purple-300 dark:hover:border-purple-600" id="opcion-programada-label">
                                <input type="radio" name="tipo_fecha" value="programada" class="text-purple-600 focus:ring-purple-500">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Programar fecha</p>
                                    <p class="text-xs text-gray-500 dark:text-neutral-400">Se publicará automáticamente en la fecha elegida</p>
                                </div>
                                <i class="bx bx-time-five text-xl text-purple-500 ml-auto"></i>
                            </label>

                            <div id="campo-fecha-programada" class="hidden px-1 pt-1">
                                <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Fecha y hora de publicación</label>
                                <input type="datetime-local" name="fecha_programada" id="input-fecha-programada"
                                    class="py-2.5 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <p class="text-xs text-gray-400 mt-1"><i class="bx bx-info-circle"></i> La noticia no será visible hasta esa fecha y hora</p>
                            </div>
                        </div>
                    </div>

                    {{-- PASO 3: Carrusel --}}
                    <div id="aprobar-paso-3" class="aprobar-paso hidden">
                        <div class="text-center mb-5">
                            <div class="size-16 rounded-full bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center mx-auto mb-3">
                                <i class="bx bx-slideshow text-3xl text-orange-500"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg">Paso 3 de 3 — Carrusel principal</h4>
                            <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">¿Deseas que esta noticia aparezca en el carrusel de inicio?</p>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all border-gray-200 dark:border-neutral-600 hover:border-orange-300 dark:hover:border-orange-600" id="opcion-carrusel-label">
                                <input type="checkbox" name="montar_carrusel" value="1" id="check-carrusel"
                                    class="text-orange-500 focus:ring-orange-500 rounded dark:bg-neutral-800 dark:border-neutral-600">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Sí, agregar al carrusel</p>
                                    <p class="text-xs text-gray-500 dark:text-neutral-400">
                                        La imagen principal aparecerá en el carrusel
                                        <span id="texto-cuando-carrusel">de inmediato</span>
                                    </p>
                                </div>
                                <i class="bx bx-images text-xl text-orange-400 ml-auto"></i>
                            </label>
                            <div class="p-4 rounded-xl border border-gray-100 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-900/30 text-center">
                                <p class="text-xs text-gray-500 dark:text-neutral-400">
                                    <i class="bx bx-info-circle mr-1"></i>
                                    Si no marcas esta opción, la noticia se publica normalmente pero no aparece en el carrusel principal
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer de navegación --}}
                <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700 flex items-center justify-between">
                    <div>
                        <button type="button" id="btn-anterior" data-ver-accion="paso-anterior"
                            class="hidden py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all inline-flex items-center gap-2">
                            <i class="bx bx-arrow-back"></i> Anterior
                        </button>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" data-ver-accion="cerrar-aprobar"
                            class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
                            Cancelar
                        </button>
                        <button type="button" id="btn-siguiente" data-ver-accion="paso-siguiente"
                            disabled
                            class="py-2 px-4 text-sm font-semibold rounded-lg bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all inline-flex items-center gap-2">
                            Siguiente <i class="bx bx-right-arrow-alt"></i>
                        </button>
                        <button type="submit" id="btn-publicar"
                            class="hidden py-2 px-4 text-sm font-semibold rounded-lg bg-teal-600 text-white hover:bg-teal-700 transition-all inline-flex items-center gap-2">
                            <i class="bx bx-check-circle"></i> Confirmar publicación
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endhasanyrole
    @endif

@endsection

@push('page-scripts')
    @vite(['resources/js/editor-config.js', 'resources/js/ver-noticia.js', 'resources/js/upload-preview.js'])
<style @cspNonce>
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to   { opacity: 1; transform: scale(1)   translateY(0);     }
}
.animate-modal { animation: modalIn 0.2s ease-out forwards; }
</style>
@endpush

