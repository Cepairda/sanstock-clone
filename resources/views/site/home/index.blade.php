@extends('layouts.site')
@section('body_class', 'home')
@section('meta_title', __('Home title'))
@section('meta_description',  __('Home description'))

@section('content')

    <main class="main-container bgc-gray">

        @include('site.home.components.banner')

        <!-- Tabs -->
        <div class="tabs-products">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="tabs-products__caption">
                            <div>{{ __('Recent receipts') }}</div>
                            {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, ea!</p>--}}
                        </div>
                        <div class="tabs-products__btn-group">
                            <!--button class="btn btn-item active" data-toggle="#sort-0">Сорт - 0</button-->
                            @foreach($productsGradeKey as $key => $value)
                                <button class="btn btn-item {{ $value == $gradeActiveDefault ? 'active' : ''}}" data-toggle="#sort-{{ $value }}" style="font-style: italic">Сорт-{{ $value }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 px-0">
                        <div class="tabs-products__container">
                            @foreach($productsBySort as $key => $products)
                                <div id="sort-{{ $key }}" class="container-item {{ $key == $gradeActiveDefault ? 'active' : ''}}">
                                    <div class="owl-carousel owl-theme">
                                        @foreach($products as $product)
                                            <div class="container-item__card">
                                                @include('site.product_group.components.card', [
                                                    'product' => $product,
                                                    'productGroup' => $product->productGroup
                                                ])
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>

       @include('site.home.components.infoBlock')

    </main>

@endsection
