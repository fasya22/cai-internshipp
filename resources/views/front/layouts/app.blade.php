<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('inc.head')
</head>
<body>
    <div id="wrapper">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
