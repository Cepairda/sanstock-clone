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
            {{ __('About us') }}
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
                    <h1 class="mb-4">{{ __('About us') }}</h1>
                    <p class="mb-3">{{ __('descriptions.about_us-1-1') }}</p>
                    <p class="mb-4">{{ __('descriptions.about_us-1-2') }}</p>

                    <h3 class="pt-3 mb-3">{{ __('descriptions.about_us-2-title') }}</h3>
                    <p class="mb-3">{{ __('descriptions.about_us-2-1') }}</p>
                    <p class="mb-3">{{ __('descriptions.about_us-2-2') }}</p>
                    <p class="mb-3">{{ __('descriptions.about_us-2-3') }}</p>
                    <p class="mb-4">{{ __('descriptions.about_us-2-4') }}</p>

                    <h3 class="pt-3 mb-3">{{ __('descriptions.about_us-3-title') }}</h3>
                    <ul class="pl-3">
                        <li class="mb-1">- <span class="ml-3">{{ __('descriptions.about_us-3-list-1') }}</span></li>
                        <li class="mb-1">- <span class="ml-3">{{ __('descriptions.about_us-3-list-2') }}</span></li>
                        <li class="mb-1">- <span class="ml-3">{{ __('descriptions.about_us-3-list-3') }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

@endsection
