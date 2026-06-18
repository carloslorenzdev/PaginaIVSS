@use('Illuminate\Support\Facades\Context')
@extends('layouts/blank')

@section('content')
    <div class="flex items-center justify-between px-6 pt-4">
        <x-logo />
        <div>
            @include('layouts/sections/navbar/mode-theme')
        </div>
    </div>
    <main class="grid min-h-[calc(100vh-170px)] place-items-center px-6 lg:px-8">
        <div class="text-center">
            <p class="text-6xl font-semibold text-red-700">
                @yield('codigo')
            </p>
            <h1
                class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-800 dark:text-neutral-200 sm:text-7xl">
                @yield('mensaje')
            </h1>
            @hasrole('Admin')
                <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">
                    {{ $exception->getMessage() }}
                </p>
            @endhasrole
            <div class="flex justify-center items-center gap-x-3 mt-6">
                @if (request()->hasHeader('X-Request-ID'))
                    <p class="text-sm text-gray-800 dark:text-neutral-200">
                        {{ request()->header('X-Request-ID') }}
                    </p>
                @endif
                <span class="text-gray-800 dark:text-neutral-200">|</span>
                <p class="text-sm text-gray-800 dark:text-neutral-200">
                    {{ Context::get('trace_id') }}
                </p>
            </div>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <x-button.link href="{{ request()->is('admin*') ? route('admin.panel') : url('/') }}"
                    class="rounded-md bg-red-700 font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                    Volver al inicio
                </x-button.link>
            </div>
        </div>
    </main>
    @include('layouts/sections/footer')
@endsection
