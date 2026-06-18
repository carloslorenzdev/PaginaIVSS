@props(['size' => '5xl', 'textSize' => '2xl'])

<div class="flex flex-col justify-center gap-3 p-6 text-center text-gray-800 dark:text-neutral-200">
    <div>
        <p>
            <i class="bx bx-search !text-{{ $size }}"></i>
        </p>
    </div>
    <div>
        <p class="text-{{ $textSize }}">Sin resultados</p>
    </div>
</div>
