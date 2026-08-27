@extends('layouts.app')

@section('titulo', 'Banners y Alertas Promocionales')

@section('content')
<x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-2">
        <div>
            <x-titulo titulo="Banners y Alertas" class="text-gradient font-extrabold text-3xl" />
            <p class="text-sm text-gray-500 dark:text-neutral-400 mt-2 font-medium">
                Gestiona directamente las imágenes que se muestran en la página principal.
            </p>
        </div>
        
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Banners y Alertas
            </x-breadcrumb.current>
        </x-breadcrumb>
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
        <div class="flex flex-col bg-white border border-gray-100 shadow-sm rounded-2xl dark:bg-neutral-800 dark:border-neutral-700 overflow-hidden">
            <div class="p-5 border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50">
                <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2 text-lg">
                    <div class="size-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center">
                        <i class="bx bx-bell text-lg"></i>
                    </div>
                    Alerta Emergente (Popup)
                </h3>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mt-2 ml-10">
                    Se muestra siempre al abrir la página web.
                </p>
            </div>

            <div class="p-6 flex-grow flex flex-col justify-between">
                <div>
                    @if($alertaImg)
                        <div class="mb-5">
                            <p class="text-sm font-semibold mb-3 text-gray-800 dark:text-neutral-200 uppercase tracking-wider text-[11px]">Imagen Actual</p>
                            <div class="relative rounded-xl overflow-hidden border border-gray-100 dark:border-neutral-700 shadow-inner bg-gray-50 dark:bg-neutral-900/50 flex justify-center items-center h-56 p-2">
                                <img src="{{ asset('storage/' . $alertaImg) }}" alt="Alerta" class="max-h-full max-w-full object-contain drop-shadow-md rounded">
                            </div>
                            <div class="mt-4 bg-gray-50 dark:bg-neutral-900/30 rounded-xl p-4 border border-gray-100 dark:border-neutral-700/50">
                                <p class="text-sm mb-1"><span class="font-bold text-gray-800 dark:text-neutral-200">Título:</span> <span class="text-gray-600 dark:text-neutral-400 font-medium">{{ $alertaTitulo ?? 'N/A' }}</span></p>
                                @if($alertaEnlace)
                                    <p class="text-sm truncate"><span class="font-bold text-gray-800 dark:text-neutral-200">Enlace:</span> <a href="{{ $alertaEnlace }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 hover:underline font-medium ml-1"><i class="bx bx-link-external"></i> {{ $alertaEnlace }}</a></p>
                                @endif
                            </div>
                        </div>

                        <button type="button" class="btn-confirmar-accion w-full py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40 transition-colors" data-action="{{ route('admin.banners.clearAlerta') }}" data-method="POST" data-mensaje="¿Remover esta imagen? Dejará de mostrarse al público.">
                            <i class="bx bx-trash text-lg"></i> Remover Imagen Actual
                        </button>

                        <div class="my-6 flex items-center before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:before:border-neutral-700 dark:after:border-neutral-700">
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500">Reemplazar</span>
                        </div>
                    @else
                        <div class="mb-6 text-center py-10 bg-gray-50/50 dark:bg-neutral-900/20 border-2 border-dashed border-gray-200 dark:border-neutral-700 rounded-2xl">
                            <div class="size-16 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4 shadow-sm">
                                <i class="bx bx-image-add text-3xl text-gray-400 dark:text-neutral-500"></i>
                            </div>
                            <h4 class="text-gray-800 dark:text-neutral-200 font-bold mb-1">Sin alerta activa</h4>
                            <p class="text-sm text-gray-500 dark:text-neutral-400">Configura una alerta para mostrar en el inicio.</p>
                        </div>
                    @endif
                </div>

                <form action="{{ route('admin.banners.updateAlerta') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-gray-50/50 dark:bg-neutral-900/20 p-5 rounded-xl border border-gray-100 dark:border-neutral-700/50">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Título / Referencia</label>
                        <input type="text" name="titulo" required class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Enlace (Opcional)</label>
                        <input type="url" name="enlace" placeholder="https://" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Subir Imagen</label>
                        <input type="file" name="archivo" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 file:transition-colors dark:file:bg-red-900/30 dark:file:text-red-400 dark:hover:file:bg-red-900/50">
                    </div>
                    <button type="submit" class="w-full mt-4 py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white hover:from-red-700 hover:to-red-600 shadow-md hover:shadow-lg shadow-red-500/30 transition-all">
                        <i class="bx bx-upload text-lg"></i> {{ $alertaImg ? 'Subir y Reemplazar' : 'Subir Alerta' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Galería de Carrusel -->
        <div class="lg:col-span-2 flex flex-col bg-white border border-gray-100 shadow-sm rounded-2xl dark:bg-neutral-800 dark:border-neutral-700 overflow-hidden">
            <div class="p-5 border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50">
                <h3 class="font-bold text-gray-800 dark:text-neutral-200 flex items-center gap-2 text-lg">
                    <div class="size-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 flex items-center justify-center">
                        <i class="bx bx-carousel text-lg"></i>
                    </div>
                    Carrusel de Promociones
                </h3>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mt-2 ml-10">
                    Sube las imágenes que rotarán en la sección principal de la página web.
                </p>
            </div>

            <div class="p-6">
                
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50/50 dark:bg-neutral-900/20 p-5 rounded-xl border border-gray-100 dark:border-neutral-700/50 mb-8">
                    @csrf
                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-700 dark:text-neutral-300 mb-4 flex items-center gap-2">
                        <i class="bx bx-plus-circle text-indigo-500 text-lg"></i> Añadir Nueva Imagen al Carrusel
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Nombre</label>
                            <input type="text" name="titulo" required class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Enlace (Opcional)</label>
                            <input type="url" name="enlace" placeholder="https://" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 text-gray-700 dark:text-neutral-300">Subir Imagen</label>
                            <input type="file" name="archivo" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 file:transition-colors dark:file:bg-indigo-900/30 dark:file:text-indigo-400 dark:hover:file:bg-indigo-900/50">
                        </div>
                    </div>
                    <div class="mt-5 flex justify-end">
                        <button type="submit" class="py-2.5 px-5 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-500 text-white hover:from-indigo-700 hover:to-indigo-600 shadow-md hover:shadow-lg shadow-indigo-500/30 transition-all">
                            <i class="bx bx-plus"></i> Añadir al Carrusel
                        </button>
                    </div>
                </form>

                @if($banners->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($banners as $banner)
                            <div class="group relative bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 dark:bg-neutral-900 dark:border-neutral-700">
                                <div class="aspect-video bg-gray-50 dark:bg-neutral-900/50 relative overflow-hidden">
                                    <img src="{{ asset('storage/' . $banner->ruta_imagen) }}" alt="{{ $banner->titulo }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-4">
                                        <button type="button" class="btn-confirmar-accion py-2 px-4 inline-flex items-center gap-2 text-sm font-bold bg-red-600 text-white rounded-xl shadow-lg shadow-red-600/30 hover:bg-red-700 hover:scale-105 transition-all transform translate-y-4 group-hover:translate-y-0" data-action="{{ route('admin.banners.destroy', $banner->id) }}" data-method="DELETE" data-mensaje="¿Seguro que deseas eliminar esta imagen del carrusel?">
                                            <i class="bx bx-trash text-lg"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                                <div class="p-4 bg-white dark:bg-neutral-800">
                                    <h5 class="text-sm font-bold text-gray-900 dark:text-white truncate" title="{{ $banner->titulo }}">
                                        {{ $banner->titulo }}
                                    </h5>
                                    @if($banner->enlace)
                                        <div class="mt-2 text-xs font-medium bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 p-2 rounded-lg truncate flex items-center gap-1.5">
                                            <i class="bx bx-link-external"></i> <a href="{{ $banner->enlace }}" target="_blank" class="hover:underline truncate">{{ $banner->enlace }}</a>
                                        </div>
                                    @else
                                        <div class="mt-2 text-xs font-medium text-gray-400 dark:text-neutral-500 p-2 truncate flex items-center gap-1.5">
                                            <i class="bx bx-unlink"></i> Sin enlace
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 bg-gray-50/50 dark:bg-neutral-900/20 border-2 border-dashed border-gray-200 dark:border-neutral-700 rounded-2xl">
                        <div class="size-20 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4 shadow-sm">
                            <i class="bx bx-carousel text-4xl text-gray-400 dark:text-neutral-500"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No hay imágenes</h4>
                        <p class="text-sm text-gray-500 dark:text-neutral-400">El carrusel de promociones está vacío.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-section>

<x-modal-confirmar />
@endsection
