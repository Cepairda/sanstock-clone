<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}-UA">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MRJTRXC');
    </script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"-->
    <link rel="stylesheet" href="{{ mix('css/site/app.css') }}">
    <style type="text/css">
        {{-- file_get_contents(public_path("/css/site/app.css")) --}}
    </style>
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

</head>
<body id="@yield('body_id')" class="@yield('body_class')">
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MRJTRXC"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
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
