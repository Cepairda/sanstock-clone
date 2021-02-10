@extends('layouts.site')
@section('body_class', 'category')

@if (isset($_GET['page']))
    @section('rel_alternate_pagination')
        <link rel="canonical"
              href="{{ strtok(LaravelLocalization::getLocalizedURL(), '?') }}"
        >
    @endsection
@endif

@section('breadcrumbs')
    <li class="active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ __('Search') }}
        </span>
        <meta itemprop="position" content="2" />
    </li>
@endsection

@section('content')

    @include('site.components.breadcrumbs', ['title' => 'Поиск "' . $searchQuery . '"'])

    <form>
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>
    </form>

    <section class="section-md bg-white">

        <div class="shell">
            <div class="range range-60 range-md-reverse">
                @if($products->isNotEmpty())
                    <div class="cell-12 section-divided__main">
                        <div class="section-sm">
                            <div class="filter-shop-box">
                                <p>{{ __('Showing') }} {{ $products->count() }} {{ __('of') }} {{ $products->total() }} </p>
                                <!--div class="form-wrap">

                                    <select class="form-input select-filter" data-placeholder="Default sorting"
                                            data-minimum-results-for-search="Infinity">

                                        <option>{{ __('Sort by name low to high') }}</option>
                                        <option value="2">{{ __('Sort by name high to low') }}</option>
                                        <option value="3">{{ __('Sort by price low to high') }}</option>
                                        <option value="4">{{ __('Sort by price high to low') }}</option>

                                    </select>
                                </div-->
                            </div>
                            <div class="range range-xs-center range-70">
                                @foreach($products as $product)
                                    <div class="cell-sm-4 cell-lg-3">
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
                @else
                    <div class="section-sm m-auto">
                        <p>{{ __('Search not result', ['search_value' => $searchQuery]) }}</p>
                    </div>
                @endif
            </div>
        </div>

    </section>

@endsection
