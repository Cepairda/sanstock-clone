@extends('layouts.site')
@section('body_class', 'favorites')

@section('rel_alternate_pagination')
    @if (isset($_GET['page']))
        <link rel="alternate" hreflang="{{ 'ru-ua' }}"
              href="{{ strtok(LaravelLocalization::getLocalizedURL('ru'), '?') }}"
        >
        <link rel="alternate" hreflang="{{ 'uk-ua' }}"
              href="{{ strtok(LaravelLocalization::getLocalizedURL('uk'), '?') }}"
        >
    @endif
@endsection

@section('breadcrumbs')
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ __('Favorites') }}
        </span>
        <meta itemprop="position" content="2" />
    </li>
@endsection

@section('content')

    @include('site.components.breadcrumbs', ['title' => __('Favorites')])

    <section class="section-sm">

        <div class="container">
            <div class="row">
                @if($products->isNotEmpty())
                    <div class="col-12">

                        <div class="filter-shop-box">
                            <p class="heading-4">{{ __('My wishlist') }}</p>
                            {{-- <div class="form-wrap">
                                <!--Select 2-->
                                <select class="form-input select-filter" data-placeholder="Default sorting"
                                        data-minimum-results-for-search="Infinity">
                                    <option>Сортировать</option>
                                    <option value="2">Sort by popularity</option>
                                    <option value="3">Sort by average rating</option>
                                    <option value="4">Sort by newness</option>
                                    <option value="5">Sort by price: low to high</option>
                                    <option value="6">Sort by price: high to low</option>
                                </select>
                            </div> --}}
                        </div>
                    </div>

                    @foreach($products as $product)
                        <div class="col-sm-6 col-md-4 col-lg-3 mt-5">
                            @include('site.components.product')
                        </div>
                    @endforeach
                    <!-- Pagination-->
                    <div class="col-12 d-flex justify-content-center py-5">
                        {!! $products->links() !!}
                    </section>
                @else
                    <div class="col-12 mt-5">
                        <p class="heading-4">{{ __('No selected products') }}</p>
                    </div>
                @endif
            </div>
        </div>

    </section>

@endsection
