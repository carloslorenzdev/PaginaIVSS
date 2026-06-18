<x-button type="submit"
    {{ $attributes->merge([
        'class' =>
            'justify-center font-semibold rounded-lg border border-transparent shadow bg-red-600 text-white hover:bg-red-700 focus:outline-2 focus:bg-red-700',
    ]) }}>
    {{ $slot }}
</x-button>
