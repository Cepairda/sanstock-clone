@extends('layouts.site')
@section('body_class', 'cart')
@section('meta_title', __('Cart title'))
@section('meta_description',  __('Cart description'))

@section('breadcrumbs')
    @php($i = 2)
    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">
           {{ __('Cart') }}
        </span>
        <meta itemprop="position" content="{{ $i }}"/>
    </li>
@endsection

@section('content')

    <main class="main-container">

        @include('site.components.breadcrumbs', ['title' => 'Cart', 'h1' => true])

        <div class="container container-gap-sm">

            <div class="row">
                @if(count($orderProducts))
                    <!-- Navigations -->
                    @include('site.orders.components.cartNavigations')

                    <!-- Table products -->
                    <div class="col-12">
                        @include('site.components.cartProductsTable')
                    </div>

                    <!-- Navigations -->
                    @include('site.orders.components.cartNavigations')

                    @else
                    <div class="col-12">
                        <div class="cart__empty">
                            <div class="cart__empty--img">
                                <span class="icon-cart"></span>
                            </div>
                            <p class="cart__empty--title">
                                {{ __('Cart empty') }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </main>

@endsection
