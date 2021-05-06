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
                    <div class="btn-link-block">
                        <span class="btn-link-block-g" data-toggle="modal" data-target="#exampleModal">Оформить</span>
                    </div>
                </div>

                <!-- Products -->
                <div class="col-12">
                    <div class="table-responsive cart__table">
                        <table class="table table-hover">
                            <caption>Корзина товаров</caption>
                            <thead>
                            <tr>
                                <td>Код товара</td>
                                <td>Фото</td>
                                <td>Наименовае</td>
                                <td>Количество</td>
                                <td>Цена</td>
                                <td>Сумма</td>
                                <td></td>
                            </tr>
                            </thead>
                            @foreach($orderProducts as $sku => $product)
                            <tbody>
                            <tr>
                                <td>{{ $product["sku"] }}</td>
                                <td>
                                    {{--{!! img(['type' => 'product', 'sku' => $product["sku"], 'size' => 70, 'alt' => $product["name"], 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}--}}
                                    <img width="150" src="{{'https://isw.b2b-sandi.com.ua/imagecache/150x150/' . strval($product["sku"])[0] . '/' . strval($product["sku"])[1] . '/' .  $product["sku"] . '.jpg'}}" alt="">
                                </td>
                                <td>{{ $product["name"] }}</td>

                                <td>
                                    @include('site.product.components.add')
                                </td>

                                <td data-max="{{ $product['max_quantity'] }}">
                                    {{ $product["price"] }} грн.
                                </td>

                                <td>
                                    {{ $product["quantity"] * $product["price"] }} грн.
                                </td>
                                <td>
                                    <span style="cursor: pointer;">
                                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="none" stroke="#000" stroke-width="1.06" d="M16,16 L4,4"></path>
                                            <path fill="none" stroke="#000" stroke-width="1.06" d="M16,4 L4,16"></path>
                                        </svg>
                                    </span>
                                </td>

                            </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>

                <!-- Navigations -->
                <div class="col-12 d-flex justify-content-end py-4">

                    <div class="btn-link-block">
                        <span class="btn-link-block-g" data-toggle="modal" data-target="#exampleModal">Оформить</span>
                    </div>

                </div>

            </div>
        </div>

        @include('site.orders.checkout')

    </main>

@endsection
