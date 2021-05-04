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
                    {{--
                       1. Смесители для ванной - 11
                       2. Душевая система - 8
                       3. Мойки из нерж. стали - 20
                       4. Аксессуары для ванной 5 (это категория 1 уровня)
                       5. Смесители для кухонной мойки - 21
                       6. Смесители для раковины - 13
                     --}}

                    @foreach(\App\Category::joinLocalization()->whereIn('virtual_id', [11, 8, 20])->orderByRaw('FIELD(virtual_id, "11, 8, 20")')->get() as $category)
                    <div class="col-6 col-lg-4 mb-contain">
                        <div class="main-ideas__wrapper jsLink" data-href="{{ route('site.resource', $category->slug) }}">
                            <div class="main-ideas__img">
                                <img src="{{ asset('images/site/home-popular-category/' . $category->id . '_230.webp') }}" alt="{!! $category->getData('name') !!}">
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
                        <h2 class="main-pops__title">Title</h2>
                        <p class="main-pops__mb-title">sub Title</p>

                        @php($products = \App\Product::joinLocalization()->whereIn('details->sku', [21650, 21899, 22008])->withCategory()->get())

                        <div class="main-pops__btn btn-maixer btn-group" role="group" aria-label="Basic example">
                            <button class="btn main-pops__btn-mx active">Пропулярное</button>
                            <button class="btn main-pops__btn-mx">Для ванной комнаты</button>
                            <button class="btn main-pops__btn-mx">Для кухни</button>

                        </div>
                    </div>
                    <div class="row main-product-mx product--lg" style="display: flex">
                        @foreach($products as $product)
                            @include('site.product.components.card')
                        @endforeach

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
                            <div class="btn-link-block btn-n">
                                <a href="{{ asset('/keramika-dlya-vannoj/') }}" class="btn-link-block-g">@lang('site.content.b11')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
