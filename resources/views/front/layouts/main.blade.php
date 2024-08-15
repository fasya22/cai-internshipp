<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    @include('front.layouts.head')
</head>

<body>
    <div id="wrapper">
    @include('front.layouts.navbar')
        <main>    
            @yield('content')
            @include('front.layouts.footer')
        </main>
    </div>
    @include('front.layouts.script')
</body>

</html>