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

        <x-card class="p-5 sm:p-8 max-w-3xl mx-auto bg-white/50 dark:bg-neutral-900/30 backdrop-blur-sm border-0 shadow-lg ring-1 ring-gray-100 dark:ring-neutral-800 rounded-3xl">
            <x-card.title class="mb-6 border-b border-gray-100 dark:border-neutral-800 pb-4 flex items-center gap-3">
                <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400">
                    <i class="bx bx-edit text-xl"></i>
                </div>
                <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400">Editando: {{ $categoria->nombre }}</span>
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
                
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <x-input.label for="orden" value="Orden" class="font-bold text-gray-700 dark:text-neutral-300" />
                        <x-input type="number" id="orden" name="orden" value="{{ old('orden', $categoria->orden) }}" min="0" class="py-2.5 shadow-sm rounded-xl" error />
                    </div>
                    <div class="flex items-center pt-8">
                        <label class="flex items-center cursor-pointer relative bg-gray-50 dark:bg-neutral-800/50 border border-gray-100 dark:border-neutral-700 px-4 py-2.5 rounded-xl w-full">
                            <input type="checkbox" name="activa" value="1" {{ old('activa', $categoria->activa) ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-teal-300/50 dark:peer-focus:ring-teal-800/50 dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[12px] after:left-[18px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-teal-500"></div>
                            <span class="ml-3 text-sm font-bold text-gray-700 dark:text-neutral-300">Activa</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100 dark:border-neutral-800">
                    <x-button.link href="{{ route('admin.categorias.index') }}" class="py-2.5 px-5 rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 font-bold dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                        Cancelar
                    </x-button.link>
                    <button type="submit" class="py-2.5 px-5 rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2 font-bold">
                        <i class="bx bx-save text-lg"></i> Actualizar
                    </button>
                </div>
            </form>
        </x-card>
    </x-section>
@endsection