<div class="space-y-1">
    <div class="flex justify-between items-center">
        <x-card.title>
            <i class="bx bx-chat"></i>
            Observaciones
        </x-card.title>
        <x-button.link
            class="!inline-flex justify-center items-center font-semibold text-red-600 rounded hover:text-red-700 focus:text-red-600 dark:text-neutral-200 dark:hover:text-red-500 dark:focus:text-red-500"
            href="{{ route('usuarios.observaciones', $user) }}">
            ver más
            <i class="bx bx-right-arrow-alt"></i>
        </x-button.link>
    </div>
    <div class="space-y-1 w-full tiptap !break-words mt-4">
        @forelse ($observaciones as $item)
            <div class="flex gap-x-3">
                <div
                    class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-red-200 dark:after:bg-red-700">
                    <x-avatar.item class="relative z-10" descripcion="{{ $item->creador->iniciales }}" />
                </div>
                <div class="grow pt-0.5 pb-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-800 dark:text-white m-0">
                            {{ $item->creador->nombre }}
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-neutral-400">
                            {{ $item->fechaHumanos('created_at') }}
                        </p>
                    </div>
                    <div class="mt-2 space-y-2 text-sm max-h-40 overflow-y-auto text-gray-800 dark:text-neutral-200">
                        {!! $item->observacion !!}
                    </div>
                </div>
            </div>
        @empty
            <div class="p-5 text-center text-gray-500 dark:text-neutral-400">
                <i class="bx bx-message-minus" style="font-size: 2rem;"></i>
                <p>Aún sin Observaciones</p>
            </div>
        @endforelse
    </div>
</div>
