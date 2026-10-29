@props([
    'rows' => 6,
    'cols' => 5,
])

@for($i = 0; $i < $rows; $i++)
    <tr class="animate-pulse">
        <td class="px-6 py-4">
            <div class="h-4 bg-gray-200 dark:bg-neutral-700 rounded w-3/4 mb-2"></div>
            <div class="h-3 bg-gray-100 dark:bg-neutral-800 rounded w-1/2"></div>
        </td>
        <td class="px-6 py-4">
            <div class="h-5 bg-gray-200 dark:bg-neutral-700 rounded-full w-20"></div>
        </td>
        <td class="px-6 py-4">
            <div class="h-4 bg-gray-200 dark:bg-neutral-700 rounded w-24"></div>
        </td>
        <td class="px-6 py-4">
            <div class="h-5 bg-gray-200 dark:bg-neutral-700 rounded-full w-16"></div>
        </td>
        <td class="px-6 py-4 text-right">
            <div class="inline-flex gap-2 justify-end">
                <div class="size-8 bg-gray-200 dark:bg-neutral-700 rounded-lg"></div>
                <div class="size-8 bg-gray-200 dark:bg-neutral-700 rounded-lg"></div>
            </div>
        </td>
    </tr>
@endfor

