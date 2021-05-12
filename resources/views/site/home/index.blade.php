@extends('layouts.site')
@section('body_class', 'home')
@section('meta_title', __('Home title'))
@section('meta_description',  __('Home description'))

@section('content')

    <main class="main bgc-gray">

        @include('site.home.components.banner')

        <div class="main__ideas">
            <div class="container">
                <div class="row main-ideas">
                    @foreach(\App\Category::joinLocalization()->whereIn('resource_id', [ 1091, 1009, 894])->get() as $category)
                    <div class="col-6 col-lg-4 mb-contain">
                        <div class="main-ideas__wrapper jsLink" data-href="{{ route('site.resource', $category->slug) }}">
                            <div class="main-ideas__img">
                                <img width="150" class="lazy" data-src="{{ asset('images/site/home-popular-category/' . $category->id . '_230.webp') }}" alt="{!! $category->getData('name') !!}">
                            </div>
                                {{-- asset('images/site/home-popular-category/' . $category->id . '_230.webp') --}}
                            <div class="main-ideas__description">
                                <h3 class="main-ideas__description-title">{!! $category->getData('name') !!}</h3>
                                <div class="main-ideas__description-link">
                                    <a class="discover-link" href="{{ route('site.resource', $category->slug) }}">
                                        Увидеть больше<i class="fas fa-chevron-right link-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="main__pops-product bgc-gray">
            <div class="container">
                    <div class="main-pops">
                        <h2 class="main-pops__title">Lorem ipsum dolor sit.</h2>
                        <p class="main-pops__mb-title">sub Title</p>

                        @php($products = \App\Product::joinLocalization()->get())

                        <div class="d-flex justify-content-center pt-3 btn-maixer btn-group" role="group" aria-label="Basic example">
                            <button class="btn main-pops__btn-mx active">Пропулярное</button>
                            <button class="btn main-pops__btn-mx">Для ванной комнаты</button>
                            <button class="btn main-pops__btn-mx">Для кухни</button>

                        </div>
                    </div>
                <div class="row main-product-mx product--lg" style="display: flex">
                    <div class="owl-carousel owl-theme">
                        @foreach($products as $product)
                            <div class="px-3">
                                @include('site.product.components.card')
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
        <div id="ceramics" class="main-ceram bgc-grad">
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
