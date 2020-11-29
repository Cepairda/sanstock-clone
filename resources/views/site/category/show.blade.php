@extends('layouts.site')
@section('body_class', 'category')
@section('content')

    @include('site.components.breadcrumbs')

    <section class="section-md bg-white">
        <div class="shell">
            <div class="range range-60 range-md-reverse">
                <div class="cell-md-9 section-divided__main section-divided__main-left">
                    <div class="section-sm">
                        <div class="filter-shop-box">
                            <p>Showing 1–12 of 15 results</p>
                            <div class="form-wrap">
                                <!--Select 2-->
                                <select class="form-input select-filter" data-placeholder="Default sorting" data-minimum-results-for-search="Infinity">
                                    <option>Default sorting</option>
                                    <option value="2">Sort by popularity</option>
                                    <option value="3">Sort by average rating</option>
                                    <option value="4">Sort by newness</option>
                                    <option value="5">Sort by price: low to high</option>
                                    <option value="6">Sort by price: high to low</option>
                                </select>
                            </div>
                        </div>
                        <div class="range range-xs-center range-70">
                            <div class="cell-sm-6 cell-lg-4">
                                @include('site.components.product')
                            </div>
                            <div class="cell-sm-6 cell-lg-4">
                                @include('site.components.product')
                            </div>
                            <div class="cell-sm-6 cell-lg-4">
                                @include('site.components.product')
                            </div>
                            <div class="cell-sm-6 cell-lg-4">
                                @include('site.components.product')
                            </div>
                            <div class="cell-sm-6 cell-lg-4">
                                @include('site.components.product')
                            </div>
                            <div class="cell-sm-6 cell-lg-4">
                                @include('site.components.product')
                            </div>
                            <div class="cell-sm-6 cell-lg-4">
                                @include('site.components.product')
                            </div>
                            <div class="cell-sm-6 cell-lg-4">
                                @include('site.components.product')
                            </div>
                            <div class="cell-sm-6 cell-lg-4">
                                @include('site.components.product')
                            </div>
                        </div>
                    </div>
                    <!-- Pagination-->
                    <section class="section-sm">
                        <!-- Classic Pagination-->
                        <nav>
                            <ul class="pagination-classic">
                                <li class="active"><span>1</span></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a class="icon linear-icon-arrow-right" href="#"></a></li>
                            </ul>
                        </nav>
                    </section>
                </div>
                <div class="cell-md-3 section-divided__aside section__aside-left">
                    <!-- Categories-->
                    <section class="section-sm">
                        <h5>Categories</h5>
                        <ul class="small list">
                            <li><a href="#">Kitchen</a></li>
                            <li><a href="#">Office</a></li>
                            <li><a href="#">Bedroom</a></li>
                            <li><a href="#">Living Room</a></li>
                        </ul>
                    </section>

                    <!-- Filter color-->
                    <section class="section-sm">
                        <h5>Filter By Color</h5>
                        <ul class="small list">
                            <li><a href="#">Black (9)</a></li>
                            <li><a href="#">Blue (3)</a></li>
                            <li><a href="#">Brown (5)</a></li>
                            <li><a href="#">Gray (7)</a></li>
                            <li><a href="#">White (6)</a></li>
                        </ul>
                    </section>

                    <!-- Range-->
                    <section class="section-sm">
                        <h5>Filter By Price</h5>
                        <!--RD Range-->
                        <div class="rd-range-wrap">
                            <div class="rd-range-inner"><span>Price: </span><span class="rd-range-input-value-1"></span><span>—</span><span class="rd-range-input-value-2"></span></div>
                            <div class="rd-range" data-min="10" data-max="500" data-start="[75, 244]" data-step="1" data-tooltip="true" data-min-diff="10" data-input=".rd-range-input-value-1" data-input-2=".rd-range-input-value-2"></div>
                        </div><a class="button button-gray-light-outline" href="#">Filter</a>
                    </section>

                </div>
            </div>
        </div>
    </section>

@endsection