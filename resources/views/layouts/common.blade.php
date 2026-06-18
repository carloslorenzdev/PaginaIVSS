<!DOCTYPE html>
<html lang="es" class="min-h-screen">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('imagenes/favicon-16x16.png') }}">
    <title>@yield('titulo') | Panel Admin</title>
    @cspMetaTag
    @include('layouts/sections/styles')
    @include('layouts/sections/scriptsIncludes')
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
    @yield('layoutContent')
    @include('layouts/sections/scripts')
</body>

</html>
