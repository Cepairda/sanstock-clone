@extends('layouts.site')
@section('body_class', 'documents')
@section('meta_title', __('Documentation'))
@section('meta_description',  __('Documentation'))

@section('breadcrumbs')
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ __('Documentation') }}
        </span>
        <meta itemprop="position" content="2" />
    </li>
@endsection
@section('content')

    @include('site.components.breadcrumbs', ['title' => __('Documentation')])
    <section class="section-md">
        <div class="container">
            <div class="row">
                <h2 class="col-12 text-center" style="padding-bottom: 25px">Документация</h2>
                <div class="col-sm-6 col-lg-4 documents__wrap--item">
                    <a class="" href="{{ asset('files/shares/catalogs/LIDZ_2020.pdf') }}" target="_blank">
                        <img src="{{ asset('images/site/catalog.jpg') }}" alt="">
                        <span>Общий каталог продукции</span>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-4 documents__wrap--item">
                    <a href="{{ asset('files/shares/catalogs/LIDZ_NEW_NOVEMBER.pdf') }}" target="_blank">
                        <img src="{{ asset('images/site/LIDZ_NEW_NOVEMBER.jpg') }}" alt="">
                        <span>Смесители ТМ LIDZ</span>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-4 documents__wrap--item text-center">
                    <a href="{{ asset('files/shares/catalogs/LIDZ_shower_box.pdf') }}" target="_blank">
                        <img src="{{ asset('images/site/LIDZ_SHOWER_BOX.jpg') }}" alt="">
                        <span>Душевые кабины ТМ LIDZ</span>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-4 documents__wrap--item">
                    <a href="{{ route('site.certificates') }}">
                        <img src="{{ asset('photos/shares/certificates/23_09_21_Lidz____________________________________________________________________________.webp') }}" alt="">
                        <span>{{ __('Certificates') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
