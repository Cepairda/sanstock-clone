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
                       6. Смесители для раковины - 13--}}

                    @foreach(\App\Category::joinLocalization()->whereIn('virtual_id', [11, 8, 20])->orderByRaw('FIELD(virtual_id, "11, 8, 20, 5, 21, 13")')->get() as $category)




                    <div class="col-6 col-lg-4 mb-contain">
                        <div class="main-ideas__wrapper jsLink" data-href="{{ route('site.resource', $category->slug) }}">
                            <div class="main-ideas__img ideas-img-1"></div>
                                {{-- asset('images/site/home-popular-category/' . $category->id . '_230.webp') --}}
                            <div class="main-ideas__description">
                                <h3 class="main-ideas__description-title">{!! $category->getData('name') !!}</h3>
                                <div class="main-ideas__description-link">
                                    <a class="discover-link" href="{{ asset('aksessuary-dlya-vannoj-komnaty') }}">
                                        @lang('site.content.learn_more')<i class="fas fa-chevron-right link-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="col-6 col-lg-4 mb-contain">--}}
                        {{--<div class="main-ideas__wrapper jsLink" data-href="{{ asset('smesiteli-dlya-mojki') }}">--}}
                            {{--<div class="main-ideas__img ideas-img-2"></div>--}}
                            {{--<div class="main-ideas__description">--}}
                                {{--<h3 class="main-ideas__description-title">@lang('site.content.b2')</h3>--}}
                                {{--<div class="main-ideas__description-link">--}}
                                    {{--<a class="discover-link" href="{{ asset('smesiteli-dlya-mojki') }}">--}}
                                        {{--@lang('site.content.learn_more')<i class="fas fa-chevron-right link-lg"></i></a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-6 col-lg-4 mb-contain">--}}
                        {{--<div class="main-ideas__wrapper jsLink" data-href="{{ asset('unitazy') }}">--}}
                            {{--<div class="main-ideas__img ideas-img-3"></div>--}}
                            {{--<div class="main-ideas__description">--}}
                                {{--<h3 class="main-ideas__description-title">@lang('site.content.b3')</h3>--}}
                                {{--<div class="main-ideas__description-link">--}}
                                    {{--<a class="discover-link" href="{{ asset('unitazy') }}">--}}
                                        {{--@lang('site.content.learn_more')<i class="fas fa-chevron-right link-lg"></i></a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}


                    @endforeach
                </div>
            </div>

        </div>
        <div class="main__pops-product bgc-gray">
            <div class="container">
                @isset($tabs[0])
                    {!! view('site.home.components.tabs', ['tabs' => $tabs[0], 'tab_products' => $tab_products, 'title' => trans('site.content.b12'), 'tab_title' => trans('site.content.tab_title1')/*, 'new_products' => $product_mixer_new*/]) !!}
                @endisset
                    {{--@php($tabs = $tabs->sortBy('sort'))--}}
                    <div class="main-pops">
                        <h2 class="main-pops__title">Title</h2>
                        <p class="main-pops__mb-title">sub Title</p>
                        <div class="main-pops__btn btn-maixer btn-group" role="group" aria-label="Basic example">

                            <button class="btn main-pops__btn-mx active">1</button>
                            <button class="btn main-pops__btn-mx">2</button>
                            <button class="btn main-pops__btn-mx">3</button>

                        </div>
                    </div>
                    @php($active = true)
                    <div class="row main-product-mx product--lg" {!! $active ? 'style="display: flex"' : ' '  !!}>
                        {{--/@include('site.product.components.product')--}}
                        {{--@include('site.product.components.product')--}}
                        {{--@include('site.product.components.product')--}}
                    </div>


            </div>
        </div>
        {{--@include('site.home.components.interactiveBanner', ['products' => $banner_products])--}}
        <div id="ceramics" class="main-ceram bgc-grad">
            <div class="container">
                @isset($tabs[1])
                    {!! view('site.home.components.tabs', ['tabs' => $tabs[1], 'tab_products' => $tab_products, 'title' => trans('site.content.b13'), 'tab_title' => trans('site.content.tab_title2')/*, 'new_products' => $product_ceram_new*/]) !!}
                @endisset
                <div class="container main__ceramics">
                    <div class="row">
                        <div class="col-12 col-xl-6 main__ceramics__img"><img class="ceramics__img" src="{{ asset('site/img/ceramics-title.jpg') }}" alt="ceramics-title"></div>
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
