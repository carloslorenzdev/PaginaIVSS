@props(['titulo' => null])

<h2 {{ $attributes->merge(['class' => 'text-xl text-gray-800 dark:text-white']) }}>
    {{ $titulo ?? $slot }}
</h2>
