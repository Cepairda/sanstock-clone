<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}-UA">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KVDKG2K');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ mix('css/site/app.css') }}">
    <title>@yield('meta_title')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="theme-color" content="">
    @section('rel_alternate_pagination')
        <link rel="canonical" href="{{ LaravelLocalization::getLocalizedURL() }}">
    @endsection
    @yield('rel_alternate_pagination')
    <link rel="alternate" hreflang="{{ 'ru-ua' }}"
          href="{{ LaravelLocalization::getLocalizedURL('ru') }}">
    <link rel="alternate" hreflang="{{ 'uk-ua' }}"
          href="{{ LaravelLocalization::getLocalizedURL('uk') }}">
    @yield('jsonld')

</head>
<body id="@yield('body_id')" class="@yield('body_class')">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KVDKG2K"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <form>
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    </form>
    <div class="page">

        <div id="page-loader">
            <div class="cssload-container">
                <div class="cssload-speeding-wheel"></div>
            </div>
        </div>

        <div class="content">
            @include('site.components.header.show')
            @yield('content')
            <div class="links-fixed">
                <ul>
                    <li>
                        <div id="to-top"></div>
                    </li>
                    <li class="link-viber">
                        <a href="viber://chat?number=%2B380671097122" target="_blank" {{-- data-toggle="tooltip"--}} data-placement="left" title="Viber">Viber</a>
                    </li>
                    <li class="link-telegram">
                        <a href="https://t.me/sandi_stock" target="_blank" {{--data-toggle="tooltip"--}} data-placement="left" title="Telegram">Telegram</a>
                    </li>
                </ul>
            </div>
        </div>
        @include('site.components.footer')
    </div>
    <script type="text/javascript" src="{{ mix('js/site/app.js') }}"></script>
    @yield('javascript')
</body>
</html>
