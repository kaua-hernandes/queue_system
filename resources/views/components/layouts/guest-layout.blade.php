<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} {!! empty($subtitle) ? '' : ' &vellip; ' . $subtitle !!}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    {{-- load resources | fontawesome 6.x --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-zinc-200">

    {{ $slot }}

</body>
</html>
