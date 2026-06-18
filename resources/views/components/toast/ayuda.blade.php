@props(['texto'])

@if ($texto)
    <div class="mt-3 text-sm text-gray-700 dark:text-neutral-400">
        {{ $texto }}
    </div>
@endif
