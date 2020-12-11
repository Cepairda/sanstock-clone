@extends('layouts.site')
@section('body_class', 'documents')
@section('meta_title', __('Documentation'))
@section('meta_description',  __('Documentation'))

@section('breadcrumbs')
    <li class="active">{{ __('Documentation') }}</li>
@endsection
@section('content')

    @include('site.components.breadcrumbs', ['title' => __('Documentation')])
    <section class="section-md">
        <div class="container">
            <div class="row">
                <h2 class="col-12 text-center" style="padding-bottom: 25px">Документация</h2>
                <div class="col-sm-6 col-lg-4 documents__wrap--item">
                    <a class="" href="https://b2b-sandi.com.ua/files/shares/catalogs/LIDZ_2020.pdf" target="_blank">
                        <img src="{{ asset('images/site/catalog.jpg') }}" alt="">
                        <span>Общий каталог продукции</span>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-4 documents__wrap--item">
                    <a href="https://b2b-sandi.com.ua/files/shares/catalogs/LIDZ_NEW_NOVEMBER.pdf" target="_blank">
                        <img src="{{ asset('images/site/LIDZ_NEW_NOVEMBER.jpg') }}" alt="">
                        <span>Смесители ТМ LIDZ</span>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-4 documents__wrap--item text-center">
                    <a href="https://b2b-sandi.com.ua/files/shares/catalogs/LIDZ_shower_box.pdf" target="_blank">
                        <img src="{{ asset('images/site/LIDZ_SHOWER_BOX.jpg') }}" alt="">
                        <span>Душевые кабины ТМ LIDZ</span>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-4 documents__wrap--item">
                    <a href="{{ route('site.certificates') }}">
                        <img src="https://b2b-sandi.com.ua/photos/shares/certificates/23_09_21_Lidz____________________________________________________________________________.png" alt="">
                        <span>{{ __('Certificates') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
