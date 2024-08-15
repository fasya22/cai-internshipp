<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    @include('dashboard.inc.head')
</head>

<body>
    @include('dashboard.inc.navbar')
    <div class="wrapper">
        {{-- @include('inc.sidebar') --}}
        <div class="content-page">

            @yield('content')
            @include('dashboard.inc.footer')
            <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
        </div>
    </div>
    @include('dashboard.inc.script')
</body>

</html>
