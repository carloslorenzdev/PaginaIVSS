<section class="bg-white border-b border-gray-200 dark:border-neutral-700" id="cintillo">
    <div class="w-full">
        @php
            $membrete = \App\Models\Configuracion::where('clave', 'membrete_img')->first()->valor ?? null;
            $defaultCintillo = file_exists(public_path('imagenes/cintillo ivss_2026.webp')) ? asset('imagenes/cintillo ivss_2026.webp') : asset('imagenes/cintillo ivss_2026.png');
            $imgSrc = $membrete ? asset('storage/' . $membrete) : $defaultCintillo;
        @endphp
        <img src="{{ $imgSrc }}" alt="Cintillo IVSS" class="w-full h-auto object-contain" @cspNonce>
    </div>
</section>
