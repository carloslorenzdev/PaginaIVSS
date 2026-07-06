@extends('layouts.app')

@section('titulo', 'Banners y Alertas Promocionales')

@section('content')
<div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
                Banners y Alertas Promocionales
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
                Gestiona directamente las imágenes que se muestran en la página principal.
            </p>
        </div>
    </div>


    @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert">
            <span class="font-bold">Error:</span> {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Slot: Alerta Emergente -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800 rounded-t-xl">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    Alerta Emergente (Popup)
                </h3>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">
                    Se muestra siempre al abrir la página web.
                </p>
            </div>

            <div class="p-4 md:p-5 flex-grow">
                @if($alertaImg)
                    <div class="mb-4">
                        <p class="text-sm font-semibold mb-2 text-gray-800 dark:text-neutral-200">Imagen Actual:</p>
                        <div class="relative rounded-lg overflow-hidden border border-gray-200 shadow-sm bg-gray-100 flex justify-center items-center h-48">
                            <img src="{{ asset('storage/' . $alertaImg) }}" alt="Alerta" class="max-h-full max-w-full object-contain">
                        </div>
                        <div class="mt-3">
                            <p class="text-sm"><span class="font-semibold text-gray-800 dark:text-neutral-200">Título:</span> <span class="text-gray-600 dark:text-neutral-400">{{ $alertaTitulo ?? 'N/A' }}</span></p>
                            @if($alertaEnlace)
                                <p class="text-sm truncate"><span class="font-semibold text-gray-800 dark:text-neutral-200">Enlace:</span> <a href="{{ $alertaEnlace }}" target="_blank" class="text-red-600 hover:underline">{{ $alertaEnlace }}</a></p>
                            @endif
                        </div>
                    </div>

                    <button type="button" class="btn-confirmar-accion w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-none focus:bg-red-200 disabled:opacity-50 disabled:pointer-events-none" data-action="{{ route('admin.banners.clearAlerta') }}" data-method="POST" data-mensaje="¿Remover esta imagen? Dejará de mostrarse al público.">
                        <i class="bx bx-trash"></i> Remover Imagen Actual
                    </button>

                    <div class="my-4 flex items-center before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-neutral-500">
                        <span class="text-sm text-gray-500 font-medium">Reemplazar</span>
                    </div>
                @else
                    <div class="mb-4 text-center py-6 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
                        <i class="bx bx-image-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-500">Ninguna alerta configurada.</p>
                    </div>
                @endif

                <form action="{{ route('admin.banners.updateAlerta') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-white">Nombre / Referencia</label>
                        <input type="text" name="titulo" required class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-white">Enlace (Opcional)</label>
                        <input type="url" name="enlace" placeholder="https://" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-white">Subir Imagen</label>
                        <input type="file" name="archivo" accept="image/*" required class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
                        file:bg-gray-50 file:border-0 file:me-4 file:py-2 file:px-4">
                    </div>
                    <button type="submit" class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700">
                        <i class="bx bx-upload"></i> {{ $alertaImg ? 'Subir y Reemplazar' : 'Subir Alerta' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Galería de Carrusel -->
        <div class="lg:col-span-2 flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800 rounded-t-xl">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    Carrusel de Promociones
                </h3>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">
                    Sube las imágenes que rotarán en la sección principal de la página web.
                </p>
            </div>

            <div class="p-4 md:p-5">
                
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6 dark:bg-neutral-800 dark:border-neutral-700">
                    @csrf
                    <h4 class="text-md font-semibold mb-4 dark:text-white"><i class="bx bx-plus-circle"></i> Añadir Nueva Imagen al Carrusel</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-white">Nombre</label>
                            <input type="text" name="titulo" required class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-white">Enlace (Opcional)</label>
                            <input type="url" name="enlace" placeholder="https://" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 dark:text-white">Subir Imagen</label>
                            <input type="file" name="archivo" accept="image/*" required class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700
                            file:bg-gray-100 file:border-0 file:me-4 file:py-2 file:px-4">
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700">
                            Añadir al Carrusel
                        </button>
                    </div>
                </form>

                @if($banners->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($banners as $banner)
                            <div class="group relative bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700">
                                <div class="aspect-w-16 aspect-h-9 bg-gray-100 h-32 relative">
                                    <img src="{{ asset('storage/' . $banner->ruta_imagen) }}" alt="{{ $banner->titulo }}" class="w-full h-full object-cover">
                                    
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <button type="button" class="btn-confirmar-accion btn btn-sm btn-danger py-1 px-2 inline-flex items-center gap-1 text-xs bg-red-600 text-white rounded hover:bg-red-700" data-action="{{ route('admin.banners.destroy', $banner->id) }}" data-method="DELETE" data-mensaje="¿Seguro que deseas eliminar esta imagen del carrusel?">
                                            <i class="bx bx-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h5 class="text-sm font-bold text-gray-800 dark:text-neutral-200 truncate" title="{{ $banner->titulo }}">
                                        {{ $banner->titulo }}
                                    </h5>
                                    @if($banner->enlace)
                                        <p class="text-xs text-gray-500 truncate mt-1">
                                            <i class="bx bx-link"></i> <a href="{{ $banner->enlace }}" target="_blank" class="hover:underline">{{ $banner->enlace }}</a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <i class="bx bx-images text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No hay imágenes en el carrusel de promociones.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<x-modal-confirmar />
@endsection
