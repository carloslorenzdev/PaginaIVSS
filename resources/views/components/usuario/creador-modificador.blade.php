@props(['modelo', 'classPopover' => '[--placement:left]', 'trigger' => 'hover'])

<x-avatar.group {{ $attributes->class(['justify-end']) }}>
    <x-usuario.popover class="{{ $classPopover }}" trigger="{{ $trigger }}" :usuario="$modelo->creador">
        <div class="space-y-1 py-3 px-4 text-sm">
            <p class="text-gray-500 dark:text-neutral-400">Fecha registro</p>
            <p class="text-gray-800 dark:text-white">
                {{ $modelo->formatoISO('created_at') }}
            </p>
        </div>
    </x-usuario.popover>
    <x-usuario.popover class="{{ $classPopover }}" trigger="{{ $trigger }}" :usuario="$modelo->modificador">
        <div class="space-y-1 py-3 px-4 text-sm">
            <p class="text-gray-500 dark:text-neutral-400">Fecha actualización</p>
            <p class="text-gray-800 dark:text-white">
                {{ $modelo->formatoISO('updated_at') }}
            </p>
        </div>
    </x-usuario.popover>
</x-avatar.group>
