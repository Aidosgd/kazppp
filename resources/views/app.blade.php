<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kazppp.test</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body>
    <header>
        <div class="container">
            @include('parts.header')
        </div>
    </header>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
