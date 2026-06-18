@props(['tipo' => 1])

@php

    switch ($tipo) {
        case 'success':
            $bgColor = 'bg-teal-200 dark:bg-teal-800/70';
            $textColor = 'text-teal-800 dark:text-teal-500';
            $icono = 'bx-check';
            break;

        case 'info':
            $bgColor = 'bg-blue-200 dark:bg-blue-800/70';
            $textColor = 'text-blue-800 dark:text-blue-500';
            $icono = 'bx-info-circle';
            break;

        case 'danger':
            $bgColor = 'bg-red-200 dark:bg-red-800/70';
            $textColor = 'text-red-800 dark:text-red-500';
            $icono = 'bx-error-circle';
            break;

        case 'warning':
            $bgColor = 'bg-yellow-200 dark:bg-yellow-800/70';
            $textColor = 'text-yellow-800 dark:text-yellow-500';
            $icono = 'bx-error';
            break;

        default:
            $bgColor = 'bg-white/15 dark:bg-gray-100';
            $textColor = 'text-white dark:text-gray-800';
            $icono = 'bx-user';
            break;
    }

@endphp

@if ($icono)
    <div class="inline-block size-8 rounded-full {{ $bgColor }}">
        <div class="h-full flex justify-center items-center text-xl {{ $textColor }}">
            <i class="bx {{ $icono }}"></i>
        </div>
    </div>
@endif
