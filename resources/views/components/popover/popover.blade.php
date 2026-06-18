@props(['header' => null, 'content', 'trigger' => 'hover', 'footer' => null])

<div {{ $attributes->class(['hs-tooltip inline-block', '[--trigger:' . $trigger . ']']) }}>
    <div
        class="hs-tooltip-toggle max-w-xs flex items-center gap-x-3 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
        {{ $slot }}

        <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible hidden opacity-0 transition-opacity absolute invisible z-10 max-w-xs w-full bg-white border border-gray-100 text-start rounded-xl shadow-md after:absolute after:top-0 after:-start-4 after:w-4 after:h-full dark:bg-neutral-800 dark:border-neutral-700"
            role="tooltip">
            <div {{ $header->attributes->class(['py-3 px-4 border-b border-gray-200 dark:border-neutral-700']) }}>
                <div class="flex items-center gap-x-3">
                    {{ $header }}
                </div>
            </div>

            {{ $content }}

            @if ($footer)
                <div class="py-2 px-4 flex justify-between items-center bg-gray-100 dark:bg-neutral-800">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
