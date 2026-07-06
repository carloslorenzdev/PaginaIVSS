@props(['ruta' => '#', 'boton' => 'Verificar', 'size' => 'size-11'])

<form action="{{ $ruta }}" method="POST" class="mt-5">
    @csrf
    <div {{ $attributes->class(['flex items-center gap-x-3 font-semibold mb-3']) }} data-hs-pin-input="">
        <input type="text" name="otp[0]" required
            class="block {{ $size }} text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            placeholder="⚬" data-hs-pin-input-item="">
        <input type="text" name="otp[1]" required
            class="block {{ $size }} text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            placeholder="⚬" data-hs-pin-input-item="">
        <input type="text" name="otp[2]" required
            class="block {{ $size }} text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            placeholder="⚬" data-hs-pin-input-item="">
        <div class="{{ $size }} flex items-center justify-center dark:text-neutral-400">-</div>
        <input type="text" name="otp[3]" required
            class="block {{ $size }} text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            placeholder="⚬" data-hs-pin-input-item="">
        <input type="text" name="otp[4]" required
            class="block {{ $size }} text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            placeholder="⚬" data-hs-pin-input-item="">
        <input type="text" name="otp[5]" required
            class="block {{ $size }} text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            placeholder="⚬" data-hs-pin-input-item="">
    </div>
    <x-input.error campo="otp" />
    {{ $slot }}
    <x-input.button class="mt-3">{{ $boton }}</x-input.button>
</form>
