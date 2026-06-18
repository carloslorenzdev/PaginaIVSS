<th scope="col"
    {{ $attributes->merge([
        'class' => 'px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-neutral-400',
    ]) }}>
    {{ $slot }}
</th>
