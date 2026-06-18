<div class="grid grid-cols-12 gap-3">
    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
        <x-card
            class="relative p-5 space-y-1.5 overflow-hidden before:bg-linear-to-r before:absolute before:size-full before:top-0 before:end-0 before:blur-xl before:from-purple-100 before:via-transparent dark:before:from-purple-800/30 dark:before:via-transparent">
            <div class="relative">
                <div class="flex justify-between items-center">
                    <span
                        class="flex justify-center items-center rounded-lg shadow size-10 text-purple-500 bg-white dark:shadow-neutral-700/70 dark:bg-neutral-800">
                        <x-iconos.users />
                    </span>
                    <h3 class="text-gray-800 dark:text-neutral-200">Usuarios</h3>
                </div>
                <h1 data-numero="{{ $usuarios->total() }}"
                    class="countup text-right text-3xl text-gray-800 dark:text-neutral-200 font-semibold">
                    0
                </h1>
            </div>
        </x-card>
    </div>
    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
        <x-card
            class="relative p-5 space-y-1.5 overflow-hidden before:bg-linear-to-r before:absolute before:size-full before:top-0 before:end-0 before:blur-xl before:from-teal-100 before:via-transparent dark:before:from-teal-800/30 dark:before:via-transparent">
            <div class="relative">
                <div class="flex justify-between items-center">
                    <span
                        class="flex justify-center items-center rounded-lg shadow size-10 text-teal-500 bg-white dark:shadow-neutral-700/70 dark:bg-neutral-800">
                        <i class="bx bx-user-check"></i>
                    </span>
                    <h3 class="text-gray-800 dark:text-neutral-200">Activos</h3>
                </div>
                <h1 data-numero="{{ $activos }}"
                    class="countup text-right text-3xl text-gray-800 dark:text-neutral-200 font-semibold">
                    0
                </h1>
            </div>
        </x-card>
    </div>
    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
        <x-card
            class="relative p-5 space-y-1.5 overflow-hidden before:bg-linear-to-r before:absolute before:size-full before:top-0 before:end-0 before:blur-xl before:from-red-100 before:via-transparent dark:before:from-red-800/30 dark:before:via-transparent">
            <div class="relative">
                <div class="flex justify-between items-center">
                    <span
                        class="flex justify-center items-center rounded-lg shadow size-10 text-red-500 bg-white dark:shadow-neutral-700/70 dark:bg-neutral-800">
                        <i class="bx bx-user-x"></i>
                    </span>
                    <h3 class="text-gray-800 dark:text-neutral-200">Bloqueados</h3>
                </div>
                <h1 data-numero="{{ $usuarios->total() - $activos }}"
                    class="countup text-right text-3xl text-gray-800 dark:text-neutral-200 font-semibold">
                    0
                </h1>
            </div>
        </x-card>
    </div>
    <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
        <x-card
            class="relative p-5 space-y-1.5 overflow-hidden before:bg-linear-to-r before:absolute before:size-full before:top-0 before:end-0 before:blur-xl before:from-sky-100 before:via-transparent dark:before:from-sky-800/30 dark:before:via-transparent">
            <div class="relative">
                <div class="flex justify-between items-center">
                    <span
                        class="flex justify-center items-center rounded-lg shadow size-10 text-sky-500 bg-white dark:shadow-neutral-700/70 dark:bg-neutral-800">
                        <i class="bx bxs-user-badge"></i>
                    </span>
                    <h3 class="text-gray-800 dark:text-neutral-200">Sesiones Activas</h3>
                </div>
                <h1 data-numero="{{ $sesionesActivas }}"
                    class="countup text-right text-3xl text-gray-800 dark:text-neutral-200 font-semibold">
                    0
                </h1>
            </div>
        </x-card>
    </div>
</div>
