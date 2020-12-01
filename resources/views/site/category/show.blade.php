@extends('layouts.site')
@section('body_class', 'category')

@section('breadcrumbs')
    @foreach($category->ancestors as $ancestor)
        <li><a href="{{ route('site.resource', $ancestor->slug) }}">{{ $ancestor->name }}</a></li>
    @endforeach
    <li class="active">{{ $category->name }}</li>
@endsection

@section('content')

{{--  {{ dd($category->ancestors) }}--}}

    @include('site.components.breadcrumbs', ['title' => $category->getData('name')])

    @if( $category->ancestors->isNotEmpty() )

        <section class="section-md bg-white">

            <div class="shell">
            <div class="range range-60 range-md-reverse">
                <div class="cell-md-9 section-divided__main section-divided__main-left">
                    <div class="section-sm">
                        <div class="filter-shop-box">
                            <p>Showing 1–12 of 15 results</p>
                            <div class="form-wrap">
                                <!--Select 2-->
                                <select class="form-input select-filter" data-placeholder="Default sorting"
                                        data-minimum-results-for-search="Infinity">
                                    <option>По названию</option>
                                    <option value="2">Sort by popularity</option>
                                    <option value="3">Sort by average rating</option>
                                    <option value="4">Sort by newness</option>
                                    <option value="5">Sort by price: low to high</option>
                                    <option value="6">Sort by price: high to low</option>
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
                </div>

                @include('site.components.filter')

            </div>
        </div>

        </section>

    @else

        <section class="section-md bg-white">

            <div class="shell">

                <div class="range range-60 range-md-reverse">

                    <div class="section-sm">

                        <div class="range range-center range-70">

                            @foreach($category->descendants as $category)

                                <div class="cell-sm-6 cell-lg-4">

                                    <div class="product product-grid">

                                        <div class="product-img-wrap w-100" style="padding: 30px;">

                                            <img alt="" src="http://lidz.loc.ua/storage/product/1000-21650.jpg">

                                        </div>

                                        <div class="product-caption">

                                            <div class="product-title">

                                                <a href="{{ route('site.resource', $category->slug) }}">SUBCATEGORY NAME HERE</a>

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

    @endif

@endsection
