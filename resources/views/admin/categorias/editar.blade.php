@extends('layouts/app')

@section('titulo', 'Editar Categoría')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Editar Categoría" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.item ruta="{{ route('admin.categorias.index') }}" icono="bx bx-list-ul">
                Categorías
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Editar
            </x-breadcrumb.current>
        </x-breadcrumb>

        <x-card class="p-5 max-w-3xl mx-auto">
            <x-card.title class="mb-5 border-b border-gray-200 dark:border-neutral-700 pb-3">
                <i class="bx bx-edit"></i> Editando: {{ $categoria->nombre }}
            </x-card.title>

            <form action="{{ route('admin.categorias.actualizar', $categoria->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                
                <div>
                    <x-input.label for="nombre" value="Nombre de la Categoría *" />
                    <x-input type="text" id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required maxlength="255" error />
                </div>
                
                <div>
                    <x-input.label for="descripcion" value="Descripción (Opcional)" />
                    <textarea name="descripcion" id="descripcion" rows="3"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    <x-input.error campo="descripcion" />
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input.label for="orden" value="Orden" />
                        <x-input type="number" id="orden" name="orden" value="{{ old('orden', $categoria->orden) }}" min="0" error />
                    </div>
                    <div class="flex items-center pt-8">
                        <label class="flex items-center cursor-pointer relative">
                            <input type="checkbox" name="activa" value="1" {{ old('activa', $categoria->activa) ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Activa</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3 pt-3 border-t border-gray-200 dark:border-neutral-700">
                    <x-button.link href="{{ route('admin.categorias.index') }}" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                        Cancelar
                    </x-button.link>
                    <x-input.button class="bg-red-600 hover:bg-red-700">
                        <i class="bx bx-save mr-1"></i> Actualizar
                    </x-input.button>
                </div>
            </form>
        </x-card>
    </x-section>
@endsection