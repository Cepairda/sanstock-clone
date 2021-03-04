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

    @include('site.components.breadcrumbs', ['title' => $category->getData('name')])

    <form>
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    </form>

    @if( $category->descendants->isNotEmpty() )

        <section class="section-md bg-white">

            <div class="shell">

                <div class="range range-60 range-md-reverse">

                    <div class="section-sm">

                        <div class="range range-center range-70">

                            @foreach($category->descendants as $category)

                                <div class="cell-sm-6 cell-lg-4">

                                    <a href="{{ route('site.resource', $category->slug) }}" class="product product-grid">

                                        <div class="product-img-wrap w-100" style="padding: 30px;">

{{--                                            <img alt="" src="http://lidz.loc.ua/storage/product/1000-21650.jpg">--}}
                                            {!! img(['type' => 'product', 'sku' => $category->product->sku, 'size' => 1000, 'alt' => $category->name]) !!}

                                        </div>

                                        <div class="product-caption">

                                            <div class="product-title">

                                                <span>{{ $category->name }}</span>

                                            </div>

                                        </div>

                                    </a>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </section>

    @else

        <section class="section-md bg-white">

            <div class="shell">
                <div class="range range-60 range-md-reverse">
                    <div class="section-divided__main {{ $products->total() <= 1 ? 'cell-12' : 'cell-md-9 section-divided__main-left'}}">
                        @if($products->isNotEmpty())
                            <div class="section-sm">
                                <div class="filter-shop-box">
                                    <p>{{ __('Showing') }} {{ $products->count() }} {{ __('of') }} {{ $products->total() }} </p>
                                    <div class="form-wrap">
                                        <!--Select 2-->
                                        <select class="form-input select-filter" data-placeholder="Default sorting"
                                                data-minimum-results-for-search="Infinity">
                                            <option >{{ __('Sort by') }}</option>
                                            <option value="1" {{ ($_GET['name'] ?? null) == 'up' ? 'selected' : '' }}>{{ __('Sort by name low to high') }}</option>
                                            <option value="2" {{ ($_GET['name'] ?? null) == 'down' ? 'selected' : '' }}>{{ __('Sort by name high to low') }}</option>
                                            <option value="3" {{ ($_GET['price'] ?? null) == 'up' ? 'selected' : '' }}>{{ __('Sort by price low to high') }}</option>
                                            <option value="4" {{ ($_GET['price'] ?? null) == 'down' ? 'selected' : '' }}>{{ __('Sort by price high to low') }}</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="range range-xs-center range-70 products-wrapper">
                                    @foreach($products as $product)
                                        <div class="cell-sm-6 cell-lg-4">
                                            @include('site.components.product')
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <section class="text-center">
                                <!-- Classic Pagination-->
                                @isset($showMore)
                                <button type="button" class="btn-more-link" data-page="{{ $showMore['page'] }}"
                                        data-url="{{ LaravelLocalization::localizeUrl('/show-more') . '?' . Request::getQueryString() }}"
                                        id="showMore"
                                        data-token="{{ csrf_token() }}" data-slug="{{ $showMore['slug'] }}"
                                >
                                    @lang('Show More')
                                </button>
                                @endisset
                            </section>
                            <!-- Pagination-->
                            <section class="section-sm">
                                <!-- Classic Pagination-->
                                {!! $products->links() !!}
                            </section>
                        @else
                            <div class="section-sm m-auto">
                                <p class="pt-5 text-center">{{ __('No products') }}</p>
                            </div>
                        @endif

                    </div>
                    @if ($products->total() > 1)
                        @include('site.components.filter')
                    @endif


                </div>
            </div>

        </section>

    @endif

@endsection
