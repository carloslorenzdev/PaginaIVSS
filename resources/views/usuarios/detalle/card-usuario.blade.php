{{-- <div class="p-8 rounded-lg bg-gradient-to-r from-[#CB356B] via-[#dc1960] to-[#BD3F32]"> --}}
<div class="p-8 rounded-lg relative overflow-hidden shadow-xs animate-fade-in-up animate-duration-300">
    <div class="w-full h-full absolute top-0 left-0 z-0 bg-gradient-to-r from-red-600 via-[#dc1960] to-[#CB356B]">
    </div>
    <div class="w-full h-full absolute top-0 left-0 z-0 overflow-hidden">
        <x-svg.laberinto class="stroke-gray-400/30" />
    </div>
    <div class="flex flex-col md:flex-row justify-start items-center gap-5 relative">
        <div class="flex justify-center animate-slide-up-fade animate-duration-200 animate-delay-100">
            <div
                class="size-32 flex items-center justify-center border-6 border-white bg-white rounded-full shadow-[0_0_25px_white] shadow-white">
                <p
                    class="text-[3rem] text-center font-bold text-shadow-xs bg-linear-to-r from-gray-800 to-gray-700 dark:from-red-500 dark:via-rose-500 dark:to-pink-500 bg-clip-text text-transparent select-none">
                    {{ $user->iniciales }}
                </p>
            </div>
        </div>
        <div class="text-center md:text-start">
            <h1
                class="text-2xl md:text-4xl font-bold text-shadow-sm text-neutral-100 animate-slide-in-left animate-duration-200 animate-delay-100">
                {{ $user->nombre }}
            </h1>
            <p
                class="text-base md:text-lg text-neutral-200 text-shadow-xs animate-slide-in-left animate-duration-200 animate-delay-150">
                {{ $user->usuario }}
            </p>
        </div>
    </div>
</div>
