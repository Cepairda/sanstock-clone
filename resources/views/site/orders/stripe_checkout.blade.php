@extends('layouts.site')
@section('body_class', 'checkout')
@section('meta_title', __('Checkout title'))
@section('meta_description',  __('Checkout description'))

@section('breadcrumbs')
{{--    <li class="breadcrumb-item" itemprop="itemListElement"--}}
{{--        itemscope itemtype="https://schema.org/ListItem">--}}
{{--        <a href="{{ asset('/cart') }}" itemprop="item" content="{{ asset('/cart') }}">--}}
{{--            <span itemprop="name">{{ __('Cart') }}</span>--}}
{{--        </a>--}}
{{--        <meta itemprop="position" content="2"/>--}}
{{--    </li>--}}
    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">
           Заказ оформлен
        </span>
        <meta itemprop="position" content="3"/>
    </li>
@endsection

@section('content')

    <main class="main-container">
        @include('site.components.breadcrumbs')

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-12">

                    <div class="main-container__title">

                        <h1 class="">Ваш заказ успешно оформлен</h1>

                    </div>

                </div>

                <div class="col-8">
                    <div class="main__contacts-form">

                        Заказ #{{ $order_id }} отправлен в обработку!
                        <br>
                        Спасибо за Ваш выбор!


                    </div>
                </div>

            </div>
        </div>
    </main>

    @section('javascript')
        <script type="text/javascript" src="{{ mix('js/site/page/checkout.js') }}"></script>
    @endsection

@endsection
