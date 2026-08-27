@extends('layouts/app')

@section('titulo', 'Base de Conocimiento del Chatbot')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Base de Conocimiento del Chatbot" class="text-gradient font-extrabold text-3xl" />
            
            <button id="btn-nuevo-registro"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all transform hover:-translate-y-0.5">
                <i class="bx bx-plus text-lg"></i> Nuevo Registro
            </button>
        </div>



        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 dark:bg-red-900/20 dark:border-red-900/50 shadow-sm" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bx bx-x-circle text-red-500 text-xl mt-0.5"></i>
                    </div>
                    <div class="ms-3">
                        <ul class="list-disc list-inside text-sm font-medium text-red-800 dark:text-red-400 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- LISTADO EN TARJETAS --}}
        <div class="space-y-4">
            @forelse($conocimientos as $item)
                <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 relative group {{ $item->activo ? '' : 'opacity-60 grayscale-[30%]' }}">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pr-16">
                        
                        <div class="col-span-1">
                            <div class="flex flex-col items-start gap-2.5">
                                @if($item->activo)
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-teal-50 text-teal-700 dark:bg-teal-900/20 dark:text-teal-400 border border-teal-100 dark:border-teal-900/50">
                                        <i class="bx bx-check-circle text-sm"></i> Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-bold bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 border border-red-100 dark:border-red-900/50">
                                        <i class="bx bx-x-circle text-sm"></i> Inactivo
                                    </span>
                                @endif
                                <p class="block font-bold text-gray-900 dark:text-white text-lg">
                                    {{ $item->pregunta }}
                                </p>
                            </div>
                            <div class="mt-4">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1">Palabras Clave</p>
                                <p class="text-sm font-medium text-gray-700 dark:text-neutral-300 bg-gray-50 dark:bg-neutral-800/50 px-3 py-2 rounded-lg border border-gray-100 dark:border-neutral-700/50 inline-block">{{ $item->palabras_clave }}</p>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1">Respuesta</p>
                            <div class="text-sm font-medium text-gray-600 dark:text-neutral-300 bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/30 p-3 rounded-lg max-h-32 overflow-y-auto leading-relaxed custom-scrollbar">
                                {!! nl2br($item->respuesta) !!}
                            </div>
                        </div>

                    </div>

                    {{-- ACCIONES --}}
                    <div class="absolute top-5 right-5 flex flex-col sm:flex-row gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-300">
                        <button type="button" 
                            class="btn-edit text-gray-500 hover:text-teal-600 transition-all bg-gray-50 hover:bg-teal-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-teal-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-teal-900/30 dark:hover:border-teal-800/50 shadow-sm"
                            data-id="{{ $item->id }}"
                            data-update-url="{{ route('admin.chatbot.conocimiento.update', $item->id) }}"
                            data-pregunta="{{ $item->pregunta }}"
                            data-palabras_clave="{{ $item->palabras_clave }}"
                            data-respuesta="{{ $item->respuesta }}"
                            data-activo="{{ $item->activo ? '1' : '0' }}"
                            title="Editar Registro">
                            <i class="bx bx-edit text-xl"></i>
                        </button>
                        
                        <button type="button" 
                            class="btn-delete text-gray-500 hover:text-red-600 transition-all bg-gray-50 hover:bg-red-50 size-10 flex items-center justify-center rounded-xl border border-gray-100 hover:border-red-200 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 dark:hover:border-red-800/50 shadow-sm"
                            data-delete-url="{{ route('admin.chatbot.conocimiento.destroy', $item->id) }}"
                            title="Eliminar Registro">
                            <i class="bx bx-trash text-xl"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-16 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 rounded-2xl">
                    <div class="size-20 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-5 shadow-sm border border-gray-100 dark:border-neutral-700">
                        <i class="bx bx-bot text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No hay conocimientos</h3>
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">No hay conocimientos registrados en la base de datos.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $conocimientos->links() }}
        </div>
    </x-section>

    {{-- MODAL CREAR/EDITAR --}}
    <div id="modal-registro" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm transition-opacity">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700 sm:my-8 animate-modal">
                
                <form id="form-registro" method="POST" action="{{ route('admin.chatbot.conocimiento.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0 text-teal-600 dark:text-teal-400">
                                <i class="bx bx-brain text-xl"></i>
                            </div>
                            <h3 id="modal-title" class="text-xl font-bold text-gray-900 dark:text-white">
                                Nuevo Conocimiento
                            </h3>
                        </div>
                        <button type="button" id="btn-cerrar-modal" class="inline-flex size-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-600 transition-colors">
                            <i class="bx bx-x text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">Pregunta / Título</label>
                            <input type="text" name="pregunta" id="input-pregunta" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" required placeholder="Ej: Requisitos Pensión Vejez">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">Palabras Clave <span class="text-xs font-normal text-gray-500 ml-1">(separadas por comas)</span></label>
                            <input type="text" name="palabras_clave" id="input-palabras" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm" required placeholder="Ej: pension, vejez, requisitos">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">Respuesta</label>
                            <textarea name="respuesta" id="input-respuesta" rows="5" class="py-2.5 px-3 block w-full border-gray-200 rounded-xl text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 shadow-sm custom-scrollbar" required placeholder="El mensaje que enviará el bot..."></textarea>
                        </div>

                        <div class="flex items-center pt-2">
                            <label class="flex items-center cursor-pointer relative bg-gray-50 dark:bg-neutral-800/50 border border-gray-100 dark:border-neutral-700 px-4 py-2.5 rounded-xl w-full">
                                <input type="checkbox" name="activo" id="input-activo" value="1" checked class="peer sr-only">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-teal-300/50 dark:peer-focus:ring-teal-800/50 dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[12px] after:left-[18px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-teal-500"></div>
                                <span class="ml-3 text-sm font-bold text-gray-700 dark:text-neutral-300">Activar este conocimiento</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-x-3 border-t px-6 py-4 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800/50">
                        <button type="button" id="btn-cancelar-modal" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:bg-neutral-900 transition-all">
                            Cancelar
                        </button>
                        <button type="submit" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2">
                            <i class="bx bx-save text-lg"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- FORMULARIO OCULTO PARA ELIMINAR --}}
    <form id="form-delete" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- MODAL ELIMINAR --}}
    <div id="modal-eliminar" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" id="modal-eliminar-backdrop"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 animate-modal">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="size-14 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0 border border-red-200 dark:border-red-800/50">
                        <i class="bx bx-trash text-3xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Eliminar Conocimiento</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl p-4 border border-gray-100 dark:border-neutral-700/50">
                    <p class="text-sm font-medium text-gray-700 dark:text-neutral-300">¿Confirmas que deseas eliminar este registro del chatbot?</p>
                </div>
            </div>
            
            <div class="flex gap-3 justify-end bg-gray-50/50 dark:bg-neutral-800/50 border-t border-gray-100 dark:border-neutral-700 px-6 py-4">
                <button type="button" id="btn-cerrar-eliminar"
                    class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                    Cancelar
                </button>
                <button type="button" id="btn-confirmar-eliminar"
                    class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2">
                    <i class="bx bx-trash text-lg"></i> Eliminar
                </button>
            </div>
        </div>
    </div>

    @vite('resources/js/chatbot-conocimiento.js')
    <script nonce="{{ app('csp-nonce') ?? '' }}">
        // FIX: Manual cleanup for modals because of Turbo lifecycle
        document.addEventListener('turbo:before-cache', () => {
            const modalRegistro = document.getElementById('modal-registro');
            const modalEliminar = document.getElementById('modal-eliminar');
            if (modalRegistro) {
                modalRegistro.classList.add('hidden');
                modalRegistro.classList.remove('flex');
            }
            if (modalEliminar) {
                modalEliminar.classList.add('hidden');
                modalEliminar.classList.remove('flex');
            }
        });
    </script>
    
    <style nonce="{{ app('csp-nonce') ?? '' }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
@endsection

