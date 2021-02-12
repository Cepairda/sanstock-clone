<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}-UA">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ mix('css/site/app.css') }}">
    <title>@yield('meta_title')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="theme-color" content="">
    @section('rel_alternate_pagination')
        <link rel="canonical"
              href="{{ LaravelLocalization::getLocalizedURL() }}"
        >
    @endsection
    @yield('rel_alternate_pagination')
    <link rel="alternate" hreflang="{{ 'ru-ua' }}"
          href="{{ LaravelLocalization::getLocalizedURL('ru') }}">
    <link rel="alternate" hreflang="{{ 'uk-ua' }}"
          href="{{ LaravelLocalization::getLocalizedURL('uk') }}">
    @yield('jsonld')
<!-- Global site tag (gtag.js) - Google Analytics -->
{{--    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MH95R4F43C"></script>--}}
{{--    <script>--}}
{{--        window.dataLayer = window.dataLayer || [];--}}
{{--        function gtag(){dataLayer.push(arguments);}--}}
{{--        gtag('js', new Date());--}}

{{--        gtag('config', 'G-MH95R4F43C');--}}
{{--    </script>--}}
</head>
<body id="@yield('body_id')" class="@yield('body_class')">
    <div class="page">
        <div id="page-loader">
            <div class="cssload-container">
                <div class="cssload-speeding-wheel"></div>
            </div>
        </div>
        @include('site.components.header')
        @yield('content')
        @include('site.components.footer')
    </div>
    <script type="text/javascript" src="{{ mix('js/site/app.js') }}"></script>
    @yield('javascript')
</body>
</html>
