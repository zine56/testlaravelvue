<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Prueba Técnica Position') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.5.10/dist/vuetify.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

</head>
<body>
<body>
    <div id="app">
        <user-menu
            :is-authenticated="{{ Auth::check() ? 'true' : 'false' }}"
            user-name="{{ Auth::check() ? Auth::user()->name : '' }}"
        ></user-menu>
        @yield('content')
    </div>
    <!-- Pass authentication data to Vue -->
    <script>
      window.__IS_AUTHENTICATED__ = {{ Auth::check() ? 'true' : 'false' }};
      window.__USER_NAME__ = "{{ Auth::check() ? Auth::user()->name : '' }}";
    </script>
    <!-- Logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</body>
</html>
