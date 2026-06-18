<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200 dark:divide-neutral-700']) }}>
        <thead class="bg-gray-50 dark:bg-neutral-800">
            <tr>
                {{ $head ?? '' }}
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
            {{ $body ?? $slot }}
        </tbody>
    </table>
</div>
