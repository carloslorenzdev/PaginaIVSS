<button
    {{ $attributes->merge([
        'class' =>
            'inline-flex items-center gap-x-2 px-2.5 py-2 text-sm focus:outline-none disabled:opacity-50 disabled:pointer-events-none',
        'type' => 'button',
    ]) }}>
    {{ $slot }}
</button>
