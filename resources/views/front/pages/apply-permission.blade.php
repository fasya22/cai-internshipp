<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{asset('front/images/icon.png')}}">

    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" type="text/css">
</head>

<body>

    <!-- Begin page -->
    <div class="wrapper-page d-flex align-items-center justify-content-center">
        <div class="card">
            <div class="card-block">
                <div class="ex-page-content text-center" style="padding: 30px">
                    <h1 class="text-dark">Oops!</h1>
                    <h4 class="">Sorry, you do not have permission to access this page.</h4><br>
                    <a class="btn btn-primary mb-5 waves-effect waves-light" href="/home"><i class="mdi mdi-home"></i>
                        Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>


    @include('inc.footer')

    <!-- jQuery  -->

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('admin/js/waves.min.js') }}"></script>

    <script src="{{ asset('admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <script src="{{ asset('admin/js/app.js') }}"></script>

</body>

</html>
