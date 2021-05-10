@extends('layouts.site')
@section('body_class', 'cart')
@section('meta_title', __('Cart title'))
@section('meta_description',  __('Cart description'))

@section('breadcrumbs')
    @php($i = 2)
    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">
           Корзина
        </span>
        <meta itemprop="position" content="{{ $i }}"/>
    </li>
@endsection

@section('content')

    <main class="main-container">

        @include('site.components.breadcrumbs', ['title' => 'Cart', 'h1' => true])

        <div class="container">

            <div class="row">

                <!-- Navigations -->
                <div class="col-12 d-flex justify-content-end py-4">
                    <a class="button" href="{{ asset('/checkout') }}">Оформить</a>
                </div>

                <!-- Products -->
                <div class="col-12">
                    @if(count($orderProducts))
                        @include('site.components.cartProductsTable')
                    @else
                        Корзина пуста
                    @endif
                </div>

                <!-- Navigations -->
                <div class="col-12 d-flex justify-content-end py-4">
                    <a class="button" href="{{ asset('/checkout') }}">Оформить</a>
                </div>

            </div>
        </div>

    </main>

@endsection
