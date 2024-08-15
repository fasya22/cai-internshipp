<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>{{ config('app.name', 'Laravel') }}</title>
{{-- <meta content="" name="description">
  <meta content="" name="keywords"> --}}

<link rel="shortcut icon" href="{{ asset('front/images/icon.png') }}">

<link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/css/icons.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('admin/plugins/morris/morris.css') }}">
<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}">
<!-- DataTables -->
<link href="{{ asset('admin/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('admin/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('admin/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet"
    type="text/css" media="screen">
{{-- <link href="{{asset('admin/plugins/fullcalendar/css/fullcalendar.min.css')}}" rel="stylesheet" /> --}}

<style>
    .layout-px-spacing {
        min-height: calc(100vh - 166px) !important;
    }

    .bootstrap-select {
        display: flex !important;
        width: auto !important;
    }
</style>
