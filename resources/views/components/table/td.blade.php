<td
    {{ $attributes->merge([
        'class' => 'px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200',
    ]) }}>
    {{ $slot }}
</td>
