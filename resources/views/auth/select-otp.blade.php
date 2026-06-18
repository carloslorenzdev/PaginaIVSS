@extends('layouts/blank')

@section('titulo', 'Método de Verificación 2FA')

@section('content')
    <div class="flex items-center justify-between px-6 py-4">
        <x-logo />
        <div>
            @include('layouts/sections/navbar/mode-theme')
        </div>
    </div>
    <main class="flex flex-wrap justify-center min-h-[calc(100vh-120px)] px-6 md:px-10 lg:px-20">
        <div class="hidden md:block w-1/3 lg:w-1/2">
            <div class="flex justify-center items-center h-full">
                <div class="size-50 md:size-60 lg:size-130 rounded-lg dark:bg-neutral-200">
                    <x-ilustraciones.security-male />
                </div>
            </div>
        </div>
        <div class="w-full md:w-2/3 lg:w-1/2">
            <div class="flex flex-col justify-center pt-5 h-full">
                <div class="grow px-0 md:px-4 animate-fade-in-up animate-duration-200">
                    <div class="flex flex-col justify-center items-center gap-4 animate-fade-in-left animate-delay-100">
                        <h2 class="text-red-600 dark:text-neutral-200">
                            <i class="bx bx-check-circle !text-5xl md:!text-6xl lg:!text-8xl"></i>
                        </h2>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-400">
                            Método de Verificación
                        </h3>
                    </div>
                    <div class="mt-3 md:mt-8">
                        <x-button.link
                            class="!inline-flex justify-center font-semibold text-red-600 rounded hover:text-red-700 focus:text-red-600 dark:text-neutral-200 dark:hover:text-red-500 dark:focus:text-red-500"
                            href="{{ $previous }}">
                            <i class="bx bx-left-arrow-alt m-0"></i>
                            Regresar
                        </x-button.link>
                        <div class="my-3 text-sm md:text-base text-gray-600 dark:text-neutral-200">
                            Elige una opción a donde se enviará el código de verificación y continuar en el sistema
                        </div>
                        <div class="max-w-sm mx-auto mt-4">
                            @if ($authenticatorEnabled && $usuario->google2faEnabled())
                                <x-button.link href="{{ $rutas['authenticator'] }}"
                                    class="font-medium border border-x-0 first:border-t-0 last:border-b-0 border-gray-200 hover:bg-gray-200 focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-red-600 dark:border-neutral-700 hover:dark:bg-neutral-700">
                                    <div class="flex items-center w-full gap-x-4">
                                        <div>
                                            <x-badge color="blue">
                                                <i class="bx bxs-shield !text-2xl"></i>
                                            </x-badge>
                                        </div>
                                        <div class="grow">
                                            <div class="flex flex-col justify-center">
                                                <p class="text-base font-semibold text-gray-800 dark:text-white">
                                                    Authenticator App
                                                </p>
                                                <p p class="text-xs text-gray-500 dark:text-neutral-400">
                                                    Recibe el código mediante esta aplicación
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-gray-800 dark:text-neutral-400">
                                            <i class="bx bx-chevron-right"></i>
                                        </div>
                                    </div>
                                </x-button.link>
                            @endif
                            @if ($telegramEnabled && $usuario->telegram2faEnabled())
                                <x-button.link href="{{ $rutas['telegram'] }}"
                                    class="font-medium border border-x-0 first:border-t-0 last:border-b-0 border-gray-200 hover:bg-gray-200 focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-red-600 dark:border-neutral-700 hover:dark:bg-neutral-700">
                                    <div class="flex items-center w-full gap-x-4">
                                        <div>
                                            <x-badge color="blue">
                                                <i class="bx bxl-telegram !text-2xl"></i>
                                            </x-badge>
                                        </div>
                                        <div class="grow">
                                            <div class="flex flex-col justify-center">
                                                <p class="text-base font-semibold text-gray-800 dark:text-white">
                                                    Telegram App
                                                </p>
                                                <p p class="text-xs text-gray-500 dark:text-neutral-400">
                                                    Recibe el código mediante esta aplicación
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-gray-800 dark:text-neutral-400">
                                            <i class="bx bx-chevron-right"></i>
                                        </div>
                                    </div>
                                </x-button.link>
                            @endif
                        </div>
                    </div>
                </div>
                @include('layouts/sections/footer')
            </div>
        </div>
    </main>
@endsection
