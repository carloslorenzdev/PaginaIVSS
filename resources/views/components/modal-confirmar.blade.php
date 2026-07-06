    {{-- MODAL CONFIRMAR ACCION --}}
    <div id="modal-confirmar" class="fixed inset-0 z-[80] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modal-confirmar-backdrop"></div>
        <div class="relative w-full max-w-md bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl p-6 animate-modal">
            <div class="flex items-center gap-3 mb-4">
                <div class="size-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-trash text-2xl text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white" id="modal-confirmar-titulo">Confirmar Acción</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-neutral-300 mb-5" id="modal-confirmar-mensaje">¿Estás seguro?</p>
            
            <form id="form-confirmar" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" id="modal-confirmar-method" value="POST">
                <div class="flex gap-3 justify-end border-t pt-4 dark:border-neutral-700">
                    <button type="button" id="btn-cerrar-confirmar"
                        class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" id="btn-submit-confirmar"
                        class="py-2 px-4 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-check"></i> Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalConfirmar = document.getElementById('modal-confirmar');
            const btnCerrar = document.getElementById('btn-cerrar-confirmar');
            const backdrop = document.getElementById('modal-confirmar-backdrop');
            
            function closeModal() {
                modalConfirmar.classList.add('hidden');
                modalConfirmar.classList.remove('flex');
            }
            
            if(btnCerrar) btnCerrar.addEventListener('click', closeModal);
            if(backdrop) backdrop.addEventListener('click', closeModal);
            
            document.querySelectorAll('.btn-confirmar-accion').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const action = this.dataset.action;
                    const mensaje = this.dataset.mensaje;
                    const method = this.dataset.method || 'POST';
                    
                    document.getElementById('form-confirmar').action = action;
                    document.getElementById('modal-confirmar-mensaje').textContent = mensaje;
                    document.getElementById('modal-confirmar-method').value = method;
                    
                    modalConfirmar.classList.remove('hidden');
                    modalConfirmar.classList.add('flex');
                });
            });
        });
    </script>
    <style nonce="{{ app('csp-nonce') }}">
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1)   translateY(0);     }
        }
        .animate-modal { animation: modalIn 0.2s ease-out forwards; }
    </style>
