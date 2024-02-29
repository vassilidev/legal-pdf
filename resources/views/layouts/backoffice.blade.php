<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Back office - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdn.form.io/formiojs/formio.full.min.css'>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @livewireStyles
    @stack('css')
</head>
<body @production oncontextmenu="return false" @endproduction>
<header>
    @include('layouts.backoffice.navbar')
</header>

<main>
    @yield('content')
</main>

@livewireScripts
<script src='https://cdn.form.io/formiojs/formio.full.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
@stack('js')
</body>
</html>