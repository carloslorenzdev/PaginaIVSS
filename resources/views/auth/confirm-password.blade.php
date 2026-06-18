@extends('layouts/blank')

@section('titulo', 'Confirmación')

@section('content')
    <div class="flex items-center justify-between px-6 pt-4">
        <x-logo />
        <div>
            @include('layouts/sections/navbar/mode-theme')
        </div>
    </div>
    <main class="flex flex-wrap justify-center min-h-[calc(100vh-120px)] px-6 md:px-10 lg:px-20">
        <div class="hidden md:block w-1/3 lg:w-2/3">
            <div class="flex justify-center items-center h-full">
                <div class="size-50 md:size-60 lg:size-130 rounded-lg dark:bg-neutral-200">
                    <x-ilustraciones.pass-confirm />
                </div>
            </div>
        </div>
        <div class="w-full md:w-2/3 lg:w-1/3">
            <div class="flex flex-col justify-center pt-5 h-full animate-fade-in-up animate-duration-200">
                <div class="grow px-4 sm:px-6">
                    <div class="flex flex-col justify-center items-center gap-4 animate-fade-in-left animate-delay-100">
                        <h2 class="text-red-600 dark:text-neutral-200">
                            <i class="bx bx-shield-alt-2 !text-5xl md:!text-6xl lg:!text-8xl"></i>
                        </h2>
                    </div>
                    <div class="mt-3 md:mt-8">
                        <div class="fex items-center justify-start">
                            <x-button.link
                                class="!inline-flex justify-center font-semibold text-red-600 rounded hover:text-red-700 focus:text-red-600 dark:text-neutral-200 dark:hover:text-red-500 dark:focus:text-red-500"
                                href="{{ url()->previous() }}">
                                <i class="bx bx-left-arrow-alt m-0"></i>
                                Regresar
                            </x-button.link>
                        </div>
                        <div class="my-3 text-sm md:text-base text-gray-600 dark:text-neutral-200">
                            Esta es un área segura de la aplicación. Por favor confirma con tu contraseña antes de
                            continuar.
                        </div>
                        <div class="overflow-x-auto">
                            <form class="space-y-6 px-2" method="POST" action="{{ route('password.confirm') }}">
                                @csrf
                                <div class="max-w-sm">
                                    <x-input.label for="password">Contraseña</x-input.label>
                                    <x-input.password id="password" name="password" placeholder="Tu contraseña" required
                                        autofocus />
                                    <x-input.error campo="password" />
                                </div>

                                <div class="flex justify-end mt-4">
                                    <x-input.button>
                                        Confirmar
                                    </x-input.button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @include('layouts/sections/footer')
            </div>
        </div>
    </main>
@endsection
