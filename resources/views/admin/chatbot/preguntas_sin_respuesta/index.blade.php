@extends('layouts/app')

@section('titulo', 'Preguntas sin Respuesta')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Preguntas sin Respuesta (Chatbot)" class="text-gradient font-extrabold text-3xl" />
        </div>



        <div class="bg-blue-50/50 border border-blue-200 rounded-xl p-5 mb-4 dark:bg-blue-900/20 dark:border-blue-800/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="bx bx-message-alt-error text-6xl text-blue-600"></i>
            </div>
            <div class="flex items-start gap-4 relative z-10">
                <div class="flex-shrink-0 size-10 rounded-full bg-blue-100 dark:bg-blue-800/50 flex items-center justify-center">
                    <i class="bx bx-info-circle text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="flex-1 mt-2">
                    <p class="text-sm font-medium text-blue-800 dark:text-blue-300 leading-relaxed">
                        Aquí aparecen los mensajes que los usuarios han enviado al Chatbot y el sistema no ha podido interpretar. Puedes agregarlos a la Base de Conocimiento para entrenar al bot.
                    </p>
                </div>
            </div>
        </div>

        {{-- LISTADO EN TARJETAS --}}
        <div class="space-y-4">
            @forelse($preguntas as $item)
                <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 relative group">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pr-16">
                        <div class="col-span-full md:col-span-2">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1.5 flex items-center gap-1.5">
                                <i class="bx bx-time-five text-sm"></i> Recibida: {{ $item->created_at->format('d/m/Y h:i A') }}
                            </p>
                            <p class="block font-medium text-gray-900 dark:text-white text-lg italic bg-gray-50 p-4 rounded-xl dark:bg-neutral-800 border-l-4 border-teal-500 dark:border-teal-600 shadow-sm">
                                "{{ $item->pregunta }}"
                            </p>
                        </div>
                    </div>

                    {{-- ACCIONES --}}
                    <div class="absolute top-5 right-5 flex flex-col sm:flex-row gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-300">
                        <!-- Convertir a Base de Conocimiento -->
                        <a href="{{ route('admin.chatbot.conocimiento.index', ['pregunta' => $item->pregunta]) }}" 
                           class="btn-convertir text-white hover:text-white transition-all bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 px-4 py-2.5 flex items-center justify-center rounded-xl shadow-md shadow-teal-500/30 hover:shadow-lg transform hover:-translate-y-0.5"
                           title="Agregar a Base de Conocimiento"
                           onclick="event.preventDefault(); document.getElementById('form-delete-{{ $item->id }}').submit(); window.location.href = this.href;">
                            <i class="bx bx-plus-circle text-xl mr-1.5"></i> <span class="text-sm font-bold">Entrenar Bot</span>
                        </a>
                        
                        <!-- Eliminar/Ignorar -->
                        <button type="button" 
                            class="btn-delete-pregunta text-gray-500 hover:text-red-600 transition-all bg-gray-50 hover:bg-red-50 size-11 flex items-center justify-center rounded-xl border border-gray-100 hover:border-red-200 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-red-900/30 dark:hover:border-red-800/50"
                            title="Ignorar y Eliminar"
                            data-form-id="form-delete-{{ $item->id }}">
                            <i class="bx bx-trash text-xl"></i>
                        </button>
                    </div>

                    <form id="form-delete-{{ $item->id }}" action="{{ route('admin.chatbot.preguntas-sin-respuesta.destroy', $item->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @empty
                <div class="p-16 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 rounded-2xl">
                    <div class="size-20 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-5 shadow-sm border border-gray-100 dark:border-neutral-700">
                        <i class="bx bx-check-shield text-4xl text-teal-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">¡Bandeja Limpia!</h3>
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">El Chatbot ha podido responder a todas las consultas recientes.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $preguntas->links() }}
        </div>
    </x-section>

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
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Ignorar y Eliminar</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl p-4 border border-gray-100 dark:border-neutral-700/50">
                    <p class="text-sm font-medium text-gray-700 dark:text-neutral-300">¿Confirmas que deseas eliminar permanentemente este registro?</p>
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

    @vite('resources/js/chatbot-preguntas-sr.js')
    <script nonce="{{ app('csp-nonce') ?? '' }}">
        // FIX: Manual cleanup for modals because of Turbo lifecycle
        document.addEventListener('turbo:before-cache', () => {
            const modalEliminar = document.getElementById('modal-eliminar');
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

