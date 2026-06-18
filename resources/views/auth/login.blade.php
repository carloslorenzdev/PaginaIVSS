@extends('layouts/blank')

@section('titulo', 'Iniciar Sesión')

@section('content')
    <main class="flex flex-wrap justify-center min-h-[calc(100vh-50px)]">
        <div class="hidden md:block w-1/2 relative overflow-hidden">
            <div class="size-full absolute z-0">
                <x-svg.laberinto class="h-full stroke-gray-400/30 dark:stroke-red-900/90" />
            </div>
            <div class="flex flex-col h-full relative">
                <div class="px-6 pt-6">
                    <a href="/" class="inline-flex">
                        <x-svg.ivss class="size-16 fill-red-600 dark:fill-neutral-200" />
                    </a>
                </div>
                <div class="grow flex flex-col justify-center px-6 space-y-2">
                    <div class="animate-fade-in-left animate-delay-100 animate-duration-200">
                        <h1
                            class="text-5xl/10 font-bold tracking-tight text-shadow-xs animate-fade-in-down animate-delay-100 bg-linear-to-r from-red-500 to-violet-500 dark:from-red-500 dark:via-rose-500 dark:via-20% dark:to-pink-600 bg-clip-text text-transparent">
                            Panel Administrativo
                        </h1>
                        <p class="text-md tracking-tight text-gray-800 dark:text-white text-shadow-xs">
                            Gestión y administración de la Página Web Institucional del IVSS
                        </p>
                    </div>
                </div>
                <div>
                    @include('layouts/sections/footer')
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/2">
            <div class="flex flex-col justify-center h-full">
                <div class="flex items-center justify-end px-6 pt-4">
                    <div>
                        @include('layouts/sections/navbar/mode-theme')
                    </div>
                </div>
                <div class="grow px-6 md:px-16 lg:px4 flex flex-col justify-center items-center">
                    <div class="w-full md:max-w-md space-y-3 animate-fade-in-left">
                        <div class="flex justify-center md:hidden">
                            <x-logo />
                        </div>
                        <div class="text-center md:text-left mt-6">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
                                ¡Bienvenido! 👋
                            </h2>
                            <h5 class="text-gray-600 dark:text-neutral-400">
                                Por favor, ingresa tus credenciales
                            </h5>
                        </div>
                        @include('auth/login-form')
                    </div>
                </div>
                <div class="block md:hidden">
                    @include('layouts/sections/footer')
                </div>
            </div>
        </div>
    </main>
@endsection
