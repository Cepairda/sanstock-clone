@extends('layouts.site')
@section('body_class', 'category')
@section('meta_title', 'Page Title')
@section('meta_description', 'Page Title')

@section('breadcrumbs')
    @foreach($category->ancestors as $ancestor)
        <li><a href="{{ route('site.resource', $ancestor->slug) }}">{{ $ancestor->name }}</a></li>
    @endforeach
    <li class="active">{{ $category->name }}</li>
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

                                    <div class="product product-grid">

                                        <div class="product-img-wrap w-100" style="padding: 30px;">

{{--                                            <img alt="" src="http://lidz.loc.ua/storage/product/1000-21650.jpg">--}}
                                            {!! img(['type' => 'product', 'sku' => $category->product->sku, 'size' => 1000, 'alt' => $category->name]) !!}

                                        </div>

                                        <div class="product-caption">

                                            <div class="product-title">

                                                <a href="{{ route('site.resource', $category->slug) }}">{{ $category->name }}</a>

                                            </div>

                                        </div>

                                    </div>

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
                    <div class="cell-md-9 section-divided__main section-divided__main-left">
                        @if($products->isNotEmpty())
                            <div class="section-sm">
                                <div class="filter-shop-box">
                                    <p>{{ __('Showing') }} {{ $products->count() }} {{ __('of') }} {{ $products->total() }} </p>
                                    <div class="form-wrap">
                                        <!--Select 2-->
                                        <select class="form-input select-filter" data-placeholder="Default sorting"
                                                data-minimum-results-for-search="Infinity">

                                            <option>{{ __('Sort by name low to high') }}</option>
                                            <option value="2">{{ __('Sort by name high to low') }}</option>
                                            <option value="3">{{ __('Sort by price low to high') }}</option>
                                            <option value="4">{{ __('Sort by price high to low') }}</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="range range-xs-center range-70">
                                    @foreach($products as $product)
                                        <div class="cell-sm-6 cell-lg-4">
                                            @include('site.components.product')
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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

                    @include('site.components.filter')

                </div>
            </div>

        </section>

    @endif

@endsection
