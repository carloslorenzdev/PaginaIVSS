@props(['color' => null])

@php
    $color = match ($color) {
        'emerald' => 'bg-emerald-50 text-emerald-500 dark:bg-emerald-800/30 dark:text-emerald-500',
        'gray' => 'bg-gray-50 text-gray-500 dark:bg-white/10 dark:text-white',
        'orange' => 'bg-orange-50 text-orange-500 dark:bg-orange-800/30 dark:text-orange-500',
        'purple' => 'bg-purple-50 text-purple-500 dark:bg-purple-800/30 dark:text-purple-500',
        'red' => 'bg-red-50 text-red-500 dark:bg-red-800/30 dark:text-red-500',
        'sky' => 'bg-sky-50 text-sky-500 dark:bg-sky-800/30 dark:text-sky-500',
        'teal' => 'bg-teal-50 text-teal-500 dark:bg-teal-800/30 dark:text-teal-500',
        'yellow' => 'bg-yellow-50 text-yellow-500 dark:bg-yellow-800/30 dark:text-yellow-500',
        'violet' => 'bg-violet-50 text-violet-500 dark:bg-violet-800/30 dark:text-violet-500',
        default => 'bg-blue-60 text-blue-600 dark:bg-blue-800/30 dark:text-blue-500',
    };
@endphp

<span {{ $attributes->class(['size-5 flex justify-center items-center rounded-full', $color]) }}>
    {{ $slot }}
</span>
