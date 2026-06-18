@extends('layouts/blank')

@section('titulo', 'Confirmación ' . $metodo)

@section('content')
    <div class="flex items-center justify-between px-6 py-4">
        <x-logo />
        <div>
            @include('layouts/sections/navbar/mode-theme')
        </div>
    </div>
    <main class="flex flex-wrap justify-center min-h-[calc(100vh-120px)] px-6 md:px-10 lg:px-20">
        <div class="hidden md:block w-1/3 lg:w-2/3">
            <div class="flex justify-center items-center h-full">
                <div class="size-50 md:size-60 lg:size-130 rounded-lg dark:bg-neutral-200">
                    <x-ilustraciones.otp-female />
                </div>
            </div>
        </div>
        <div class="w-full md:w-2/3 lg:w-1/3">
            <div class="flex flex-col justify-center pt-5 h-full">
                <div class="grow px-4 sm:px-6 animate-fade-in-up animate-duration-200">
                    <div class="flex flex-col justify-center items-center gap-4 animate-fade-in-left animate-delay-200">
                        <h2 class="text-red-600 dark:text-neutral-200">
                            <i class="bx {{ $icono }} !text-5xl md:!text-6xl lg:!text-8xl"></i>
                        </h2>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-400">{{ $metodo }}</h3>
                    </div>
                    <div class="mt-3 md:mt-8">
                        <div @class([
                            'flex items-center',
                            'justify-between' => count($seleccionables) > 1,
                            'justify-start' => count($seleccionables) == 1,
                        ])>
                            <x-button.link
                                class="!inline-flex justify-center font-semibold text-red-600 rounded hover:text-red-700 focus:text-red-600 dark:text-neutral-200 dark:hover:text-red-500 dark:focus:text-red-500"
                                href="{{ $previous }}">
                                <i class="bx bx-left-arrow-alt m-0"></i>
                                Regresar
                            </x-button.link>
                            @if (count($seleccionables) > 1)
                                <x-tooltip titulo="Seleccionar otro método de 2FA">
                                    <x-button.link
                                        href="{{ url()->temporarySignedRoute('2fa.selecciona-metodo', now()->addMinutes(10)) }}"
                                        class="!inline-flex justify-center font-semibold border text-red-600 rounded hover:text-red-700 hover:border-red-700 focus:text-red-600 focus:ring-2 focus:ring-red-600 dark:text-neutral-200 dark:hover:text-red-500 dark:focus:text-red-500">
                                        Otro Método
                                    </x-button.link>
                                </x-tooltip>
                            @endif
                        </div>
                        <div class="my-3 text-sm md:text-base text-gray-600 dark:text-neutral-200">
                            Esta es un área segura de la aplicación. Por favor ingresa el código enviado por la aplicación
                        </div>
                        <div class="overflow-x-auto">
                            <x-form-otp class="px-2" ruta="{!! $ruta !!}" boton="Confirmar" />
                        </div>
                        @if ($codigo)
                            <div class="flex justify-end items-center mt-3">
                                <x-tooltip titulo="Reenviar código">
                                    <x-button.link href="{{ route('2fa.telegram.envia-otp') }}"
                                        class="!inline-flex justify-center font-semibold text-red-600 rounded hover:text-red-700 hover:border hover:border-red-700 focus:text-red-600 focus:ring-2 focus:ring-red-600 dark:text-neutral-200 dark:hover:text-red-500 dark:focus:text-red-500">
                                        Reenviar Código
                                    </x-button.link>
                                </x-tooltip>
                            </div>
                        @endif
                    </div>
                </div>
                @include('layouts/sections/footer')
            </div>
        </div>
    </main>
@endsection
