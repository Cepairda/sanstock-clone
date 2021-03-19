@extends('layouts.site')
@section('body_class', 'home')
@section('meta_title', __('Home title'))
@section('meta_description',  __('Home description'))

@section('content')

    @php($category_banner_1 = \App\Category::joinLocalization()->where('virtual_id', 21)->first())

    <section class="home-carousel">
        <div class="owl-carousel owl-theme home__carousel">
            <div class="item">
                <img class="item__img" src="{{ asset('images/site/home-slider/slide-1.webp') }}" alt="slide-1">
                <div class="container item__desc">
                    <div class="row">
                        <div class="col-12">
                            <p class="item__desc--title">{!! __('Home slide 1') !!}</p>
                            @isset($category_banner_1)
                                <a class="button button-primary item__desc--link" href="{{ route('site.resource', $category_banner_1->slug) }}">{{ __('Show more') }}</a>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="item">
                <img class="item__img" src="{{-- asset('images/site/home-slider/slide-1.webp') --}}" alt="slide-1">
                <div class="container item__desc" style="">
                    <div class="row">
                        <div class="col-12">
                            <p class="item__desc--title">Высокое качество,<br>доступное каждому</p>
                            <a class="button button-primary item__desc--link" href="#">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="item">
                <img class="item__img" src="{{-- asset('images/site/home-slider/slide-2.webp') --}}" alt="slide-2">
                <div class="container item__desc">
                    <div class="row">
                        <div class="col-12">
                            <p class="item__desc--title">Высокое качество,<br>доступное каждому</p>
                            <a class="button button-primary item__desc--link" href="#">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

    <section class="home-popular-categories section-lg">
        <div class="container">
            <div class="row">

                <h4 class="col-12 text-center">{{ __('Popular categories') }}</h4>

                {{--
                1. Смесители для ванной - 11
                2. Душевая система - 8
                3. Мойки из нерж. стали - 20
                4. Аксессуары для ванной 5 (это категория 1 уровня)
                5. Смесители для кухонной мойки - 21
                6. Смесители для раковины - 13--}}

                @foreach(\App\Category::joinLocalization()->whereIn('virtual_id', [11, 8, 20, 5, 21, 13])->orderByRaw('FIELD(virtual_id, "11, 8, 20, 5, 21, 13")')->get() as $category)

                    <div class="col-md-6 col-lg-4 popular-category cat-{{ $category->id }}">
                        <a class="popular-category__inner" href="{{ route('site.resource', $category->slug) }}">
                            <img class="popular-category__inner--image lazyload no-src" src="{{ asset('images/site/default_white.jpg') }}" data-src="{{ asset('images/site/home-popular-category/' . $category->id . '_230.webp') }}" alt="{!! $category->getData('name') !!}">
                            <p class="popular-category__inner--name" style="font-size: 20px;">{!! $category->getData('name') !!}</p>
                        </a>
                    </div>

                @endforeach

            </div>
        </div>
    </section>

    {{-- @include('site.product.carousel', ['title' => 'Новинки', 'products' => $home_product]) --}}

    @php($category_banner_2 = \App\Category::joinLocalization()->where('virtual_id', 20)->first())


    <section class="home-bn-info section-lg" style="background-image: url({{ asset('images/site/home-slider/slide-3.webp') }});">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-12 text-right">
                    <p class="home-bn-info__title">{!! __('Home slide 2') !!}</p>
                    @isset($category_banner_2)
                        <a class="button button-primary item__desc--link" href="{{ route('site.resource', $category_banner_2->slug) }}">{{ __('Show more') }}</a>
                    @endisset
                </div>
            </div>
        </div>
    </section>

    {{-- 4 article blog --}}
    {{--<section class="section-lg bg-white text-center">
        <div class="shell">
            <h4>Статьи</h4>
            <div class="range range-60 range-sm-center">
                <div class="cell-sm-6 cell-md-4">
                    @include('site.components.post')
                </div>
                <div class="cell-sm-6 cell-md-4">
                    @include('site.components.post')
                </div>
                <div class="cell-sm-6 cell-md-4">
                    @include('site.components.post')
                </div>
            </div>
        </div>
    </section>--}}
@endsection
