@props(['id', 'titulo' => null])

<div {{ $attributes->merge(['class' => 'flex justify-between items-center py-3 px-4 dark:border-neutral-700']) }}>
    <h3 id='{{ $id }}-label' class="font-bold text-gray-800 dark:text-white">
        {{ $titulo }}
    </h3>
    <x-button
        class="justify-center size-8 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
        aria-label="Close" data-hs-overlay="#{{ $id }}">
        <span class="sr-only">Close</span>
        <i class="bx bx-x"></i>
    </x-button>
</div>
