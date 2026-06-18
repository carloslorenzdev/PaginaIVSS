@props(['id', 'btnClose' => false])

<div {{ $attributes->merge(['class' => 'flex items-center gap-x-2 py-3 px-4']) }}>
    @if ($btnClose)
        <x-button aria-label='Close'
            class="rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-100 focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            data-hs-overlay="#{{ $id }}">
            {{ $btnClose }}
        </x-button>
    @endif
    {{ $slot }}
</div>
