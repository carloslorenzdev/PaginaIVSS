@props(['id' => 'modal-example'])

<x-button type="button"
    {{ $attributes->merge([
        'class' => 'font-medium rounded-lg border border-transparent',
        'aria-controls' => $id,
        'data-hs-overlay' => '#' . $id,
        'id' => $id,
        'aria-haspopup' => 'dialog',
        'aria-expanded' => 'false',
    ]) }}>
    {{ $slot }}
</x-button>
