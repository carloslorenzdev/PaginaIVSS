@props(['classNav' => ''])

<div {{ $attributes->class(['border-b border-gray-200 dark:border-neutral-700']) }}>
    <nav class="-mb-0.5 flex justify-center gap-x-6 {{ $classNav }}">
        {{ $slot }}
    </nav>
</div>
