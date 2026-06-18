@props(['data'])

@php

    switch ($data[0]) {
        case 'success':
            $bgColor = 'bg-teal-100 border border-teal-200 dark:bg-teal-800/20 dark:border-teal-700/30';
            $textColor = 'text-teal-800 dark:text-teal-500';
            break;

        case 'info':
            $bgColor = 'bg-blue-100 border border-blue-200 dark:bg-blue-800/20 dark:border-blue-700/30';
            $textColor = 'text-blue-800 dark:text-blue-500';
            break;

        case 'danger':
            $bgColor = 'bg-red-100 border border-red-200 dark:bg-red-800/20 dark:border-red-700/30';
            $textColor = 'text-red-800 dark:text-red-500';
            break;

        case 'warning':
            $bgColor = 'bg-yellow-100 border border-yellow-200 dark:bg-yellow-800/20 dark:border-yellow-700/30';
            $textColor = 'text-yellow-800 dark:text-yellow-500';
            break;

        default:
            $bgColor = 'bg-neutral-700 border border-neutral-700 dark:bg-white dark:border-gray-200';
            $textColor = 'text-white dark:text-gray-700';
            break;
    }

@endphp

<div id="hs-new-toast" class="max-w-sm relative rounded-xl shadow-lg" role="alert" tabindex="-1"
    aria-labelledby="hs-toast-avatar-label">
    <div class="flex p-4 rounded-xl {{ $bgColor }}" data-clases="{{ $bgColor }}">
        <div class="shrink-0">
            <x-toast.icono tipo="{{ $data[0] }}" />
            <button id="toast-alert-close" type="button"
                class="absolute top-3 end-3 inline-flex shrink-0 justify-center items-center size-5 rounded-lg opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 {{ $textColor }}"
                aria-label="Close">
                <i class="bx bx-x"></i>
            </button>
        </div>
        @if (is_array($data[1]))
            <div class="ms-4 me-5">
                <x-toast.mensaje mensaje="{{ $data[1]['mensaje'] }}" />
                @if (array_key_exists('ayuda', $data[1]))
                    <x-toast.ayuda texto="{{ $data[1]['ayuda'] }}" />
                @endif
                @if (array_key_exists('acciones', $data[1]))
                    <x-toast.acciones :acciones="$data[1]['acciones']" />
                @endif
            </div>
        @else
            <div class="ms-4 me-5 flex flex-column items-center">
                <x-toast.mensaje mensaje="{{ $data[1] }}" />
            </div>
        @endif
    </div>
</div>
