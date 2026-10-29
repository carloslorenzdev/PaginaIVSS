@props([
    'count' => 5,
])

<div {{ $attributes->merge(['class' => 'space-y-4 animate-pulse']) }}>
    @for($i = 0; $i < $count; $i++)
        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 shadow-sm space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-gray-200 dark:bg-neutral-700 flex-shrink-0"></div>
                    <div class="space-y-2">
                        <div class="h-4 bg-gray-200 dark:bg-neutral-700 rounded w-44"></div>
                        <div class="h-3 bg-gray-100 dark:bg-neutral-800 rounded w-28"></div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-7 w-20 bg-gray-100 dark:bg-neutral-800 rounded-lg"></div>
                    <div class="size-8 bg-gray-200 dark:bg-neutral-700 rounded-lg"></div>
                    <div class="size-8 bg-gray-200 dark:bg-neutral-700 rounded-lg"></div>
                </div>
            </div>
            <div class="space-y-1.5 pt-2">
                <div class="h-3 bg-gray-100 dark:bg-neutral-800 rounded w-full"></div>
                <div class="h-3 bg-gray-100 dark:bg-neutral-800 rounded w-3/4"></div>
            </div>
        </div>
    @endfor
</div>

