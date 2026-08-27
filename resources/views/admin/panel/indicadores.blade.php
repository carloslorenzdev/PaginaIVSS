<div class="grid grid-cols-12 gap-3">
    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
        <x-card
            class="relative p-6 space-y-1.5 overflow-hidden hover-elevate glass-card before:bg-linear-to-r before:absolute before:size-full before:top-0 before:end-0 before:blur-xl before:from-red-100/50 before:via-transparent dark:before:from-red-800/20 dark:before:via-transparent">
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-2">
                    <span
                        class="flex justify-center items-center rounded-xl shadow-sm size-12 text-red-500 bg-red-50 dark:shadow-neutral-700/70 dark:bg-red-900/20">
                        <i class="bx bx-news text-2xl"></i>
                    </span>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-400">Noticias</h3>
                </div>
                <h1 data-numero="{{ $noticias->total() }}"
                    class="countup text-right text-4xl text-gray-800 dark:text-white font-black tracking-tight">
                    0
                </h1>
            </div>
        </x-card>
    </div>
    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
        <x-card
            class="relative p-6 space-y-1.5 overflow-hidden hover-elevate glass-card before:bg-linear-to-r before:absolute before:size-full before:top-0 before:end-0 before:blur-xl before:from-teal-100/50 before:via-transparent dark:before:from-teal-800/20 dark:before:via-transparent">
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-2">
                    <span
                        class="flex justify-center items-center rounded-xl shadow-sm size-12 text-teal-500 bg-teal-50 dark:shadow-neutral-700/70 dark:bg-teal-900/20">
                        <i class="bx bx-check-circle text-2xl"></i>
                    </span>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-400">Publicadas</h3>
                </div>
                <h1 data-numero="{{ $publicadas }}"
                    class="countup text-right text-4xl text-gray-800 dark:text-white font-black tracking-tight">
                    0
                </h1>
            </div>
        </x-card>
    </div>
    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
        <x-card
            class="relative p-6 space-y-1.5 overflow-hidden hover-elevate glass-card before:bg-linear-to-r before:absolute before:size-full before:top-0 before:end-0 before:blur-xl before:from-yellow-100/50 before:via-transparent dark:before:from-yellow-800/20 dark:before:via-transparent">
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-2">
                    <span
                        class="flex justify-center items-center rounded-xl shadow-sm size-12 text-yellow-500 bg-yellow-50 dark:shadow-neutral-700/70 dark:bg-yellow-900/20">
                        <i class="bx bx-time-five text-2xl"></i>
                    </span>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-400">Borradores</h3>
                </div>
                <h1 data-numero="{{ $noticias->total() - $publicadas }}"
                    class="countup text-right text-4xl text-gray-800 dark:text-white font-black tracking-tight">
                    0
                </h1>
            </div>
        </x-card>
    </div>
    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
        <x-card
            class="relative p-6 space-y-1.5 overflow-hidden hover-elevate glass-card before:bg-linear-to-r before:absolute before:size-full before:top-0 before:end-0 before:blur-xl before:from-sky-100/50 before:via-transparent dark:before:from-sky-800/20 dark:before:via-transparent">
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-2">
                    <span
                        class="flex justify-center items-center rounded-xl shadow-sm size-12 text-sky-500 bg-sky-50 dark:shadow-neutral-700/70 dark:bg-sky-900/20">
                        <i class="bx bx-show text-2xl"></i>
                    </span>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-400">Visitas Hoy</h3>
                </div>
                <h1 data-numero="{{ $visitasHoy }}"
                    class="countup text-right text-4xl text-gray-800 dark:text-white font-black tracking-tight">
                    0
                </h1>
            </div>
        </x-card>
    </div>
</div>
