@props(['campo', 'bag' => 'default'])

@error($campo, $bag)
    <p id="{{ $campo }}-helper" {{ $attributes->merge(['class' => 'text-sm text-red-600 mt-2']) }}>
        {{ $message }}
    </p>
@enderror
