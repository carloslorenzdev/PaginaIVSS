@use('Illuminate\Support\Facades\Vite')
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @cspMetaTag
    <title></title>
    <style type="text/css" @cspNonce>
        .page-break-always {
            page-break-after: always;
        }

        .page-break-before {
            page-break-before: always;
        }

        .page-break-inside {
            page-break-inside: avoid;
        }
    </style>
    <style type="text/css" @cspNonce>
        {!! Vite::content('resources/css/app.css') !!}
    </style>
    @yield('css-custom')
</head>

<body>
    @yield('contenido')
    @yield('js-custom')
</body>

</html>
