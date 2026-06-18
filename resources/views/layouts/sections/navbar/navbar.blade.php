<header
    class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-48 w-full bg-white border border-gray-200 text-sm py-2.5 lg:ps-[260px] dark:bg-neutral-800 dark:border-neutral-700">
    <nav class="px-4 sm:px-6 flex basis-full items-center w-full mx-auto">
        <div class="flex items-center me-5 lg:me-0 lg:hidden">
            <x-toggle-navigation />
            <x-logo />
        </div>

        <div class="w-full flex items-center justify-end ms-auto md:justify-between gap-x-1 md:gap-x-3">
            <div class="hidden md:block">
                @include('layouts/sections/navbar/search')
            </div>

            <div class="flex flex-row items-center justify-end gap-1">
                <x-button
                    class="md:hidden size-[38px] relative justify-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <span class="sr-only">Search</span>
                </x-button>
                <div class="hidden sm:block">
                    @include('layouts/sections/navbar/mode-theme')
                </div>
                @auth
                    @include('layouts/sections/navbar/userAuth')
                @endauth
            </div>
        </div>
    </nav>
</header>
