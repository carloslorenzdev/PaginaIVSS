<!DOCTYPE html>
<html lang="es" class="min-h-screen">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('imagenes/favicon-16x16.png') }}">
    <title>{{ !empty($title) ? $title : '' }}@hasSection('titulo')@yield('titulo')@endif | Panel Admin</title>
    @include('layouts/sections/styles')
    @include('layouts/sections/scriptsIncludes')
    @livewireStyles
    <style nonce="{{ app('csp-nonce') }}">[x-cloak] { display: none !important; }</style>
</head>

    <body class="min-h-screen bg-gray-100 dark:bg-neutral-900">
    @session('alert')
        <x-toast :data="$value" />
    @endsession
    @session('success')
        <x-toast :data="['success', $value]" />
    @endsession
    @session('error')
        <x-toast :data="['danger', $value]" />
    @endsession
    @if($errors->any())
        <x-toast :data="['danger', $errors->first()]" />
    @endif
    @yield('layoutContent')
    @include('layouts/sections/scripts')
    @livewireScripts
</body>

</html>
