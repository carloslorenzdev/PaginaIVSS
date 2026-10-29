@props([
    'count' => 6,
])

<div {{ $attributes->merge(['class' => 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 animate-pulse']) }}>
    @for($i = 0; $i < $count; $i++)
        <div class="bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700 rounded-2xl p-5 space-y-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-gray-200 dark:bg-neutral-700"></div>
                    <div class="space-y-1.5">
                        <div class="h-4 bg-gray-200 dark:bg-neutral-700 rounded w-28"></div>
                        <div class="h-3 bg-gray-100 dark:bg-neutral-800 rounded w-16"></div>
                    </div>
                </div>
                <div class="size-3 rounded-full bg-gray-200 dark:bg-neutral-700"></div>
            </div>
            <div class="space-y-2 pt-2">
                <div class="h-3 bg-gray-100 dark:bg-neutral-750 rounded w-full"></div>
                <div class="h-3 bg-gray-100 dark:bg-neutral-750 rounded w-4/5"></div>
            </div>
            <div class="pt-4 border-t border-gray-100 dark:border-neutral-700 flex justify-between items-center">
                <div class="h-4 bg-gray-200 dark:bg-neutral-700 rounded w-16"></div>
                <div class="flex gap-2">
                    <div class="size-8 rounded-lg bg-gray-100 dark:bg-neutral-700"></div>
                    <div class="size-8 rounded-lg bg-gray-100 dark:bg-neutral-700"></div>
                </div>
            </div>
        </div>
    @endfor
</div>

