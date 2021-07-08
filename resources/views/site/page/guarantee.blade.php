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
            {{ __('WARRANTY AND RETURN TERMS') }}
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
                    <h1 class="mb-4">{{ __('WARRANTY AND RETURN TERMS') }}</h1>

                    <h3 class="pt-3 mb-3">{{ __('Guarantee') }}</h3>
                    <p class="mb-3">{{ __('Guarantee Description') }}</p>

                    <h3 class="pt-3 mb-3">{{ __('Purchase returns') }}</h3>
                    <p class="mb-3">{{ __('Purchase returns Description') }}</p>

                    <h3 class="pt-3 mb-3">{{ __('Return conditions') }}</h3>
                    <p class="mb-3">{{ __('Return conditions Description 1') }}</p>
                    <p class="mb-3">{{ __('Return conditions Description 2') }}</p>
                </div>
            </div>
        </div>
    </main>

@endsection
