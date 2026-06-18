@props(['id' => 'hs-editor-tiptap'])
<div class="space-y-1">
    <x-card id="{{ $id }}" {{ $attributes->class(['border-gray-200 overflow-hidden w-full']) }}>
        <div
            class="sticky top-0 bg-white flex flex-wrap items-center gap-1 border-b border-gray-200 p-2 dark:bg-neutral-900 dark:border-neutral-700">
            
            <!-- Font Family -->
            <select data-hs-editor-font-family="" class="py-1 px-2 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                <option value="">Fuente</option>
                <option value="Inter">Inter</option>
                <option value="Arial">Arial</option>
                <option value="'Times New Roman', serif">Times New Roman</option>
                <option value="'Courier New', monospace">Courier New</option>
            </select>

            <!-- Font Size -->
            <select data-hs-editor-font-size="" class="py-1 px-2 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                <option value="">Tamaño</option>
                <option value="12px">12px</option>
                <option value="14px">14px</option>
                <option value="16px">16px</option>
                <option value="18px">18px</option>
                <option value="20px">20px</option>
                <option value="24px">24px</option>
                <option value="30px">30px</option>
            </select>

            <!-- Line Height -->
            <select data-hs-editor-line-height="" class="py-1 px-2 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                <option value="">Interlineado</option>
                <option value="1">1.0 (Sencillo)</option>
                <option value="1.15">1.15</option>
                <option value="1.5">1.5</option>
                <option value="2">2.0 (Doble)</option>
            </select>

            <div class="h-6 w-px bg-gray-200 mx-1 dark:bg-neutral-700"></div>
            <x-tooltip titulo="Negrita">
                <x-button data-hs-editor-bold=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-bold"></i>
                </x-button>
            </x-tooltip>
            <x-tooltip titulo="Cursiva">
                <x-button data-hs-editor-italic=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-italic"></i>
                </x-button>
            </x-tooltip>
            <x-tooltip titulo="Subrayado">
                <x-button data-hs-editor-underline=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-underline"></i>
                </x-button>
            </x-tooltip>
            <x-tooltip titulo="Tachado">
                <x-button data-hs-editor-strike=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-strikethrough"></i>
                </x-button>
            </x-tooltip>
            <x-tooltip titulo="Enlace">
                <x-button data-hs-editor-link=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-link"></i>
                </x-button>
            </x-tooltip>
            <x-tooltip titulo="Lista Enumerada">
                <x-button data-hs-editor-ol=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-list-ol"></i>
                </x-button>
            </x-tooltip>
            <x-tooltip titulo="Lista Viñetas">
                <x-button data-hs-editor-ul=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-list-ul"></i>
                </x-button>
            </x-tooltip>
            
            <div class="h-6 w-px bg-gray-200 mx-1 dark:bg-neutral-700"></div>

            <x-tooltip titulo="Alinear a la Izquierda">
                <x-button data-hs-editor-align-left=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-align-left"></i>
                </x-button>
            </x-tooltip>
            <x-tooltip titulo="Centrar">
                <x-button data-hs-editor-align-center=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-align-middle"></i>
                </x-button>
            </x-tooltip>
            <x-tooltip titulo="Alinear a la Derecha">
                <x-button data-hs-editor-align-right=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-align-right"></i>
                </x-button>
            </x-tooltip>
            <x-tooltip titulo="Justificar">
                <x-button data-hs-editor-align-justify=""
                    class="size-8 justify-center rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <i class="bx bx-align-justify"></i>
                </x-button>
            </x-tooltip>
        </div>
        <div class="h-40 overflow-auto" data-hs-editor-field="">{{ $slot }}</div>
    </x-card>
    <div class="text-xs text-right text-gray-500 dark:text-neutral-400" data-hs-editor-limit=""></div>
</div>
