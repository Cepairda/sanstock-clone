<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('meta_title', 'SANDI+')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('AdminLTE') }}">
    <link rel="stylesheet" href="{{ asset('components/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('components/AdminLTE/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('components/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin.components.navbar')
    @include('admin.components.sidebar')
    <div class="content-wrapper">
        @include('admin.components.breadcrumb')
        <section class="content">
            @yield('content')
        </section>
    </div>
    @include('admin.components.footer')
</div>
<script src="{{ asset('components/AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('components/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('components/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
@yield('scripts')
<script src="{{ asset('components/AdminLTE/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
