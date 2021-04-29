@extends('layouts.site')
@section('body_class', 'category')
@section('meta_title', $category->meta_title)
@section('meta_description', $category->meta_description)

@if (isset($_GET['page']))
    @section('rel_alternate_pagination')
            <link rel="canonical"
                  href="{{ strtok(LaravelLocalization::getLocalizedURL(), '?') }}"
            >
    @endsection
@endif

@section('breadcrumbs')
    @php($i = 2)
    @foreach($category->ancestors as $ancestor)
        <li itemprop="itemListElement"
            itemscope itemtype="https://schema.org/ListItem"
        >
            <a href="{{ route('site.resource', $ancestor->slug) }}" itemprop="item">
                <span itemprop="name">
                    {{ $ancestor->name }}
                </span>
            </a>
            <meta itemprop="position" content="{{ $i }}" />
        </li>
        @php($i++)
    @endforeach
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ $category->name }}
        </span>
        <meta itemprop="position" content="{{ $i }}" />
    </li>
@endsection

@section('content')

    @include('site.components.breadcrumbs', ['title' => $category->getData('name'), 'h1' => true])

    <form>
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    </form>

    @php($descendants = $category->descendants)

    {{--@if( $category->descendants->isNotEmpty() )--}}

        {{--<section class="section-md bg-white">--}}

            {{--<div class="shell">--}}

                {{--<div class="range range-60 range-md-reverse">--}}

                    {{--<div class="section-sm">--}}

                        {{--<div class="range range-center range-70">--}}

                            {{--@foreach($category->descendants as $category)--}}

                                {{--<div class="cell-sm-6 cell-lg-4">--}}
                                    {{--<a href="{{ route('site.resource', $category->slug) }}">--}}
                                        {{--<div class="product product-grid">--}}

                                            {{--<div class="product-img-wrap w-100" style="padding: 30px;">--}}
                                                {{--<img alt="" src="http://lidz.loc.ua/storage/product/1000-21650.jpg">--}}
                                                {{--{!! img(['type' => 'product', 'sku' => $category->product->sku, 'size' => 1000, 'alt' => $category->name]) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="product-caption">--}}
                                                {{--<div class="product-title">{{ $category->name }}</div>--}}
                                            {{--</div>--}}

                                        {{--</div>--}}

                                    {{--</a>--}}

                                {{--</div>--}}

                            {{--@endforeach--}}

                        {{--</div>--}}

                    {{--</div>--}}

                {{--</div>--}}

            {{--</div>--}}

        {{--</section>--}}

    {{--@else--}}

        {{--<section class="section-md bg-white">--}}

            {{--<div class="shell">--}}
                {{--<div class="range range-60 range-md-reverse">--}}
                    {{--<div class="section-divided__main {{ $productsTotal <= 1 ? 'cell-12' : 'cell-md-9 section-divided__main-left'}}">--}}
                        {{--@if($products->isNotEmpty())--}}
                            {{--<div class="section-sm">--}}
                                {{--<div class="filter-shop-box">--}}
                                    {{--<p>{{ __('Showing') }} {{ $products->count() }} {{ __('of') }} {{ $products->total() }} </p>--}}
                                    {{--<div class="form-wrap">--}}
                                        {{--<!--Select 2-->--}}
                                        {{--<select class="form-input select-filter" data-placeholder="Default sorting"--}}
                                                {{--data-minimum-results-for-search="Infinity">--}}
                                            {{--<option >{{ __('Sort by') }}</option>--}}
                                            {{--<option value="1" {{ ($_GET['name'] ?? null) == 'up' ? 'selected' : '' }}>{{ __('Sort by name low to high') }}</option>--}}
                                            {{--<option value="2" {{ ($_GET['name'] ?? null) == 'down' ? 'selected' : '' }}>{{ __('Sort by name high to low') }}</option>--}}
                                            {{--<option value="3" {{ ($_GET['price'] ?? null) == 'up' ? 'selected' : '' }}>{{ __('Sort by price low to high') }}</option>--}}
                                            {{--<option value="4" {{ ($_GET['price'] ?? null) == 'down' ? 'selected' : '' }}>{{ __('Sort by price high to low') }}</option>--}}

                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="range range-xs-center range-70 products-wrapper">--}}
                                    {{--@foreach($products as $product)--}}
                                        {{--<div class="cell-sm-6 cell-lg-4">--}}
                                            {{--@include('site.components.product')--}}
                                        {{--</div>--}}
                                    {{--@endforeach--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<section class="text-center">--}}
                                {{--<!-- Classic Pagination-->--}}
                                {{--@isset($showMore)--}}
                                {{--<button type="button" class="btn-more-link" data-page="{{ $showMore['page'] }}"--}}
                                        {{--data-url="{{ LaravelLocalization::localizeUrl('/show-more') . '?' . Request::getQueryString() }}"--}}
                                        {{--id="showMore"--}}
                                        {{--data-token="{{ csrf_token() }}" data-slug="{{ $showMore['slug'] }}"--}}
                                {{-->--}}
                                    {{--@lang('Show More')--}}
                                {{--</button>--}}
                                {{--@endisset--}}
                            {{--</section>--}}
                            {{--<!-- Pagination-->--}}
                            {{--<section class="section-sm">--}}
                                {{--<!-- Classic Pagination-->--}}
                                {{--{!! $products->links() !!}--}}
                            {{--</section>--}}
                        {{--@else--}}
                            {{--<div class="section-sm m-auto">--}}
                                {{--<p class="pt-5 text-center">{{ __('No products') }}</p>--}}
                            {{--</div>--}}
                        {{--@endif--}}

                    {{--</div>--}}
                    {{--@if ($productsTotal > 1)--}}
                        {{--@include('site.category.components.filter')--}}
                    {{--@endif--}}


                {{--</div>--}}
            {{--</div>--}}

        {{--</section>--}}

    {{--@endif--}}

    <div class="main-category bgc-gray">
        <div class="container">

            {{--<div class="main__breadcrumb">--}}
                {{--<ul class="main__breadcrumb-lg" itemscope itemtype="https://schema.org/BreadcrumbList">--}}
                    {{--<li class="breadcrumb-item" itemprop="itemListElement"--}}
                        {{--itemscope itemtype="https://schema.org/ListItem">--}}
                        {{--<a href="{{ asset('/') }}" itemprop="item" content="{{ asset('/') }}">--}}
                            {{--<span itemprop="name">@lang('site.content.home')</span>--}}
                        {{--</a>--}}
                        {{--<meta itemprop="position" content="1"/>--}}
                    {{--</li>--}}
                    {{--@php($i = 2)--}}
                    {{--@foreach($breadcrumb as $item)--}}
                        {{--<li class="breadcrumb-item" itemprop="itemListElement"--}}
                            {{--itemscope itemtype="https://schema.org/ListItem">--}}
                            {{--<a href="{{ asset($item->alias->url) }}" itemprop="item"--}}
                               {{--content="{{ asset($item->alias->url) }}">--}}
                                {{--<span itemprop="name">{{ str_limiter($item->name) }}</span>--}}
                            {{--</a>--}}
                            {{--<meta itemprop="position" content="{{ $i }}"/>--}}
                        {{--</li>--}}
                        {{--@php($i++)--}}
                    {{--@endforeach--}}
                    {{--<li class="breadcrumb-item active" itemprop="itemListElement"--}}
                        {{--itemscope itemtype="https://schema.org/ListItem">--}}
                                {{--<span itemprop="item" content="{{ asset($category->alias->url ) }}">--}}
                                    {{--<span itemprop="name">{{ str_limiter($category->name) }}</span>--}}
                                {{--</span>--}}
                        {{--<meta itemprop="position" content="{{ $i }}"/>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}

            @if($descendants->isNotEmpty())

                <div class="row main-category__wrapper">

                    @foreach($descendants as $descendant)


                        @if($descendant->children->isNotEmpty())

                            <div class="col-sm-12 level-2">

                                <h2>{{ $descendant->name }}</h2>

                                <div class="row">

                                    @foreach($descendant->children as $children)

                                        @if( $children->is_menu_item && $children->published )

                                            <div class="col-6 col-md-4 col-lg-2 category__wrapper--item">

                                                <div class="wrapper">

                                                    <div class="main-category__img jsLink" data-href="{{ asset($children->alias->url )}}">

                                                        {!! img(['type' => 'category', 'original' => 'site/img/img_menu/' . $children->id . '.jpg', 'name' => $children->id, 'size' => 175, 'alt' => strip_tags($children->name)]) !!}

                                                    </div>

                                                    <a href="{{ asset($children->alias->url) }}"><span>{!! $children->name !!}</span></a>

                                                </div>

                                            </div>

                                        @endif

                                    @endforeach

                                </div>

                            </div>

                        @else

                            @if( $descendant->is_menu_item && $descendant->published )

                                <div class="col-6 col-md-4 col-lg-2 category__wrapper--item">

                                    <div class="main-category__img jsLink" data-href="{{ asset($descendant->alias->url )}}">

                                        {!! img(['type' => 'category', 'original' => 'site/img/img_menu/' . $descendant->id . '.jpg', 'name' => $descendant->id, 'size' => 175, 'alt' => strip_tags($descendant->name)]) !!}

                                    </div>

                                    <a href="{{ asset($descendant->alias->url) }}"><span>{!! $descendant->name !!}</span></a>

                                </div>

                            @endif

                        @endif

                        <hr>

                    @endforeach

                </div>

            @endif

            @isset($category->parent_id)
                <div class="row main__filter">
                    @if($products->isNotEmpty())
                        <main class="col-sm-12 col-lg-8 col-xl-9 order-2">
                            <div class="main__title">{!! $category->h1 !!}</div>
                            {!! isset($json_ld) ? $json_ld : '' !!}
                            <div class="main__sort">
                                <p>@lang('site.content.sort'):</p>
                                <div class="sort-wrapper">
                                    {{--<span class="sort-view">@lang('site.links_to_sort.' . (isset($parameters['sort']) ? $parameters['sort'][0] : 'name'))</span>--}}
                                    {{--<ul>--}}
                                        {{--<li class="sort-view-link jsLink"--}}
                                            {{--data-href="{{ asset($links_to_sort['price']) }}">@lang('site.links_to_sort.price')</li>--}}
                                        {{--<li class="sort-view-link jsLink"--}}
                                            {{--data-href="{{ asset($links_to_sort['-price']) }}">@lang('site.links_to_sort.-price')</li>--}}
                                        {{--<li class="sort-view-link jsLink"--}}
                                            {{--data-href="{{ asset($links_to_sort['name']) }}">@lang('site.links_to_sort.name')</li>--}}
                                        {{--<li class="sort-view-link jsLink"--}}
                                            {{--data-href="{{ asset($links_to_sort['-name']) }}">@lang('site.links_to_sort.-name')</li>--}}
                                    {{--</ul>--}}
                                </div>

                                @if (isset($filters))
                                    <div class="btn-filter open-filter">
                                        @lang('site.content.filter')
                                    </div>
                                @endif

                            </div>
                            <div class="row filter-wrapper">
                                @foreach($products as $product)
                                    @include('site.product.components.product')
                                @endforeach
                            </div>
                            @isset($show_more)
                                <button type="button" class="btn-more-link" data-page="{{ $show_more['page'] }}"
                                        data-url="{{ asset('show-more') }}"
                                        data-parameters="{{ $show_more['parameters'] }}" id="showMore"
                                        data-token="{{ csrf_token() }}" data-alias="{{ $show_more['alias'] }}">
                                    @lang('site.content.showmore')
                                </button>
                            @endisset
                            <div class="col-sm-12 nav-pages">
                                <nav aria-label="Page navigation">
                                    {{--{!! $products->links('site.components.pagination') !!}--}}
                                </nav>
                            </div>
                        </main>
                    @endif

                    <aside class="col-sm-3 col-lg-4 col-xl-3 main-filter order-1">

                        @if (isset($filters))

                            @include('site.category.components.filters', ['alias' => $category->alias])

                        @else

                            <div class="filter-banner">

                                <img class="mw-100 lazy-img-thumb" src="{{ asset('site/libs/icon/logo.svg') }}" data-src="{{ asset('site/img/category-bs/' . $category->id . '.jpg') }}" alt="">

                                <div class="btn-outer">

                                    <div class="btn-link-block">

                                        <a href="" class="btn-link-block-g">$category->data->banner_btn_text</a>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </aside>

                    @if(isset($category->text) && $current_page == 1)
                        <div class="col-sm-12 order-3 block-text">{!! $category->text !!}</div>
                    @endif

                </div>
            @endisset

        </div>

    </div>

@endsection
