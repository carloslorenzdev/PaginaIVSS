@props(['color' => null])

@php
    $color = match ($color) {
        'emerald' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-800/30 dark:text-emerald-500',
        'gray' => 'bg-gray-50 text-gray-500 dark:bg-white/10 dark:text-white',
        'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-800/30 dark:text-orange-500',
        'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-800/30 dark:text-purple-500',
        'red' => 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500',
        'sky' => 'bg-sky-100 text-sky-800 dark:bg-sky-800/30 dark:text-sky-500',
        'teal' => 'bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500',
        'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500',
        'violet' => 'bg-violet-100 text-violet-800 dark:bg-violet-800/30 dark:text-violet-500',
        default => 'bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500',
    };
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-x-1 py-1 px-3 rounded-full text-xs font-medium', $color]) }}>
    {{ $slot }}
</span>
