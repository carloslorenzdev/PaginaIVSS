<a
    {{ $attributes->merge([
        'class' =>
            'flex items-center gap-x-2 px-2.5 py-2 text-sm focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none',
        'href' => '#',
    ]) }}>
    {{ $slot }}
</a>
