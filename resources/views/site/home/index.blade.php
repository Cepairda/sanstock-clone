@extends('layouts.site')
@section('body_class', 'home')
@section('meta_title', __('Home title'))
@section('meta_description',  __('Home description'))

@section('content')

    <main class="main-container bgc-gray">

        @include('site.home.components.banner')

        <div class="tabs-products">
            <div class="container">
                <div class="row">

                    <div class="col-12">

                        <div class="tabs-products__caption">
                            <div>Lorem ipsum dolor sit.</div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, ea!</p>
                        </div>


                        <div class="tabs-products__btn-group">
                            <button class="btn btn-item active" data-toggle="#sort-0">Сорт - 0</button>
                            <button class="btn btn-item" data-toggle="#sort-1">Сорт - 1</button>
                            <button class="btn btn-item" data-toggle="#sort-2">Сорт - 2</button>
                            <button class="btn btn-item" data-toggle="#sort-3">Сорт - 3</button>
                        </div>


                    </div>

                    <div class="col-12 px-0">
                        <div id="sort-0" class="tabs-products__container">
                            <div class="owl-carousel owl-theme">
                                @php($products = \App\ProductSort::joinLocalization()->withProductGroup()->get())
                                @foreach($products as $product)
                                    <div class="px-3">
                                        @include('site.product.components.card', [
                                            'product' => $product,
                                            'productGroup' => $product->productGroup
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="sort-1" class="tabs-products__container">1</div>
                        <div id="sort-2" class="tabs-products__container">2</div>
                        <div id="sort-3" class="tabs-products__container">3</div>
                    </div>
                </div>


            </div>
        </div>
        <div id="ceramics" class="main-ceram">
            <div class="container">
                <div class="container main__ceramics">
                    <div class="row">
                        <div class="col-12 col-xl-6 main__ceramics__img d-flex justify-content-center align-items-center">
                            <img class="ceramics__img" src="{{ asset('images/site/home-popular-category/' . 5443 . '_230.webp') }}" alt="ceramics-title">
                        </div>
                        <div class="col-12 col-xl-6 main__ceramics__descriptions">
                            <h3 class="descriptions__title-lg color-black">@lang('site.content.b9')</h3>
                            <p class="descriptions-lg">@lang('site.content.b10')</p>
                            <a href="{{ asset('/keramika-dlya-vannoj/') }}" class="button">Перейти</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="m-5">--}}
            {{--<button class="button">{{ __('Where buy')}}</button>--}}
            {{--<a href="#" class="button">{{ __('Where buy')}}</a>--}}
        {{--</div>--}}
    </main>

@endsection
