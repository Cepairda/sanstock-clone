@extends('layouts.site')
@section('body_class', 'about')
@section('meta_title', __('About'))
@section('meta_description', __('About'))
@section('breadcrumbs')
    <li class="breadcrumb-item active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ __('404') }}
        </span>
        <meta itemprop="position" content="2"/>
    </li>
@endsection
@section('content')

    <main class="main-container bgc-gray">
        @include('site.components.breadcrumbs')
        <div class="container container-gap-sm">
            <div class="row">
                <div class="col-12 not-found" style="font-size: 16px">
                    <h1 class = "not-found--title">404</h1>
                    <p class = "not-found--subtitle">{{ __('Page not found')  }}</p>
                    <p class = "not-found--desc">{{ __('Wrong address')  }}</p>
                    <div class = "buttons__wrapper">
                        <a class = "buttonOwn buttonOwn-transparent" href = "#" onclick="history.back();">{{ __('Come back')  }}</a>
                        <a class = "buttonOwn buttonOwn-blue" href = "{{ asset('/') }}">{{ __('To main')  }}</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
