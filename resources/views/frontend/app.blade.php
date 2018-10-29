<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}">
    <title>Kazppp.test</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body>
    <div id="app">
        <header>
            <div class="container">
                @include('frontend.parts.header')
            </div>
        </header>
        <div class="container">
            @yield('content')
        </div>
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
