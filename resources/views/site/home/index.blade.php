@extends('layouts.site')
@section('body_class', 'home')
@section('content')

    <section class="home-carousel">
        <div class="owl-carousel owl-theme home__carousel">
            <div class="item">
                <img class="item__img" src="{{ asset('images/site/home-slider/slide-1.jpg') }}" alt="slide-3">
                <div class="container item__desc">
                    <div class="row">
                        <div class="col-12">
                            <p class="item__desc--title">{!! __('Home slide 1') !!}</p>
                            <a class="button button-primary item__desc--link" href="#">{{ __('Show more') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="item">
                <img class="item__img" src="{{ asset('images/site/home-slider/slide-1.jpg') }}" alt="slide-1">
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
                <img class="item__img" src="{{ asset('images/site/home-slider/slide-2.jpg') }}" alt="slide-2">
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

                <h4 class="col-12 text-center">Популярные категории</h4>

                {{--1. Смесители для ванной - 11
                2. Душевая система - 8
                3. Мойки из нерж. стали - 20
                4. Аксессуары для ванной 5 (это категория 1 уровня)
                5. Смесители для кухонной мойки - 21
                6. Смесители для раковины - 13--}}

                @php($categoryId = [11, 8, 20, 5, 21, 13])
                @php($categories = $categories ?? \App\Category::joinLocalization()->get()->toTree())

                @foreach($categories as $category)

                    <div class="col-md-6 col-lg-4 popular-category cat-{{ $category->id }}">
                        <a class="popular-category__inner" href="{{ route('site.resource', $category->slug) }}">
                            <img class="popular-category__inner--image" src="{{ asset('images/site/home-popular-category/' . $category->id . '.png') }}" alt="{!! $category->getData('name') !!}">
                            <p class="popular-category__inner--name" style="font-size: 20px;">{!! $category->getData('name') !!}</p>
                        </a>
                    </div>

                @endforeach

            </div>
        </div>
    </section>

    {{-- @include('site.product.carousel', ['title' => 'Новинки', 'products' => $home_product]) --}}

    <section class="home-bn-info section-lg" style="background-image: url({{ asset('images/site/home-slider/slide-3.jpg') }});">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-12 text-right">
                    <p class="home-bn-info__title">{!! __('Home slide 2') !!}</p>
                    <a class="button button-primary item__desc--link" href="#">{{ __('Show more') }}</a>
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
