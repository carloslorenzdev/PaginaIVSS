@props([
    'rows' => 5,
    'cols' => 5,
])

<div {{ $attributes->merge(['class' => 'animate-pulse space-y-4']) }}>
    @for($i = 0; $i < $rows; $i++)
        <div class="flex items-center space-x-4 py-3 px-6 border-b border-gray-100 dark:border-neutral-700/60">
            @for($j = 0; $j < $cols; $j++)
                <div class="flex-1 space-y-2">
                    <div class="h-4 bg-gray-200 dark:bg-neutral-700 rounded-md {{ $j === 0 ? 'w-3/4' : ($j === 1 ? 'w-1/2' : 'w-2/3') }}"></div>
                    @if($j === 0)
                        <div class="h-3 bg-gray-100 dark:bg-neutral-800 rounded-md w-1/2"></div>
                    @endif
                </div>
            @endfor
        </div>
    @endfor
</div>

