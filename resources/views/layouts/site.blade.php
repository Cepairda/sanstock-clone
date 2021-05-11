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
            @include('site.components.header')
            @yield('content')
        </div>
        @include('site.components.footer')
        <div id="tt" class="position-fixed bottom-0 right-0 p-3" style="z-index: 1055; top: 150px; right: 0;"></div>
        </div>
    <script type="text/javascript" src="{{ mix('js/site/app.js') }}"></script>
    @yield('javascript')
</body>
</html>
