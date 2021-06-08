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
            {{ __('Payments') }}
        </span>
        <meta itemprop="position" content="2"/>
    </li>
@endsection
@section('content')

    <main class="main-container bgc-gray">

    @include('site.components.breadcrumbs')


        <div class="container container-gap-sm">
            <div class="row">
                <div class="col-12" style="font-size: 16px">

                    <h1 class="text-center mb-4">{{ __('Payments') }}</h1>

                    <div class="mb-4" hidden>
                        <img class="w-100" src="{{-- asset('images/site/banners/' . LaravelLocalization::getCurrentLocale() . '/payments.png') --}}" alt="{{ __('Delivery') }}">
                    </div>

                    <h3 class="pt-3 mb-3">{{ __('descriptions.payments-1-1') }}:</h3>
                    <ul class="pl-3 mb-4" style="list-style: disc;">
                        <li class="mb-3"><strong class="d-block">{{ __('Cashless payment') }}</strong>{{ __('descriptions.payments-1-list-1') }};</li>
                        <li class="mb-3"><strong class="d-block">{{ __('Cash') }}</strong>{{ __('descriptions.payments-1-list-2') }}.</li>
                    {{--<li class="mb-3"><strong class="d-block">{{ __('Online payment on the site') }}</strong>{{ __('descriptions.payments-1-list-3') }}.</li>--}}
                    </ul>
                    <p><span class="d-block font-weight-bold mb-1">{{ __('Importantly') }}!</span>{{ __('descriptions.payments-1-2') }}</p>
                </div>
            </div>
        </div>

    </main>

@endsection