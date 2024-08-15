<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    @include('inc.head')
</head>

<body>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@11"])
    @include('inc.navbar')
        <div class="wrapper">

            @yield('content')
            @include('inc.footer')
            <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        </div>
    @include('inc.script')
</body>

</html>
