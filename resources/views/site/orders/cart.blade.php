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
                   @include('site.components.productsTable')
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
