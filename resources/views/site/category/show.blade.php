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
                                <select class="form-input select-filter" data-placeholder="Default sorting"
                                        data-minimum-results-for-search="Infinity">
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
                            @foreach($category->products as $product)
                                <div class="cell-sm-6 cell-lg-4">
                                    @include('site.components.product')
                                </div>
                            @endforeach
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

                <form class="cell-md-3 section-divided__aside section__aside-left" action="">
                    <!-- Categories-->
                    <section class="section-sm">
                        <h5>Назначение</h5>
                        <ul class="small list">
                            <li>
                                <div class="form-group form-check custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="exampleCheck1">
                                    <label class="custom-control-label" for="exampleCheck1">Для умывальника
                                        <span>(48)</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="form-group form-check custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="exampleCheck2">
                                    <label class="custom-control-label" for="exampleCheck2">Для душа
                                        <span>(34)</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="form-group form-check custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="exampleCheck3">
                                    <label class="custom-control-label" for="exampleCheck3">Для ванны <span>(24)</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="form-group form-check custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="exampleCheck4">
                                    <label class="custom-control-label" for="exampleCheck4">Для биде
                                        <span>(15)</span></label>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Filter color-->
                    <section class="section-sm">
                        <h5>Цвет</h5>
                        <ul class="small list">
                            <li>
                                <div class="form-group form-check custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="exampleCheck5">
                                    <label class="custom-control-label" for="exampleCheck5">Хромированный
                                        <span>(48)</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="form-group form-check custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="exampleCheck6">
                                    <label class="custom-control-label" for="exampleCheck6">Белый
                                        <span>(34)</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="form-group form-check custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="exampleCheck7">
                                    <label class="custom-control-label" for="exampleCheck7">Серый
                                        <span>(24)</span></label>
                                </div>
                            </li>
                            <li>
                                <div class="form-group form-check custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="exampleCheck8">
                                    <label class="custom-control-label" for="exampleCheck8">Антрацит
                                        <span>(15)</span></label>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Range-->
                    <section class="section-sm">
                        <h5>Filter By Price</h5>
                        <!--RD Range-->
                        <div class="rd-range-wrap">
                            <div class="rd-range-inner"><span>Price: </span><span class="rd-range-input-value-1"></span><span>—</span><span
                                        class="rd-range-input-value-2"></span></div>
                            <div class="rd-range" data-min="10" data-max="500" data-start="[75, 244]" data-step="1"
                                 data-tooltip="true" data-min-diff="10" data-input=".rd-range-input-value-1"
                                 data-input-2=".rd-range-input-value-2"></div>
                        </div>
                        <a class="button button-gray-light-outline" href="#">Filter</a>
                    </section>
                </form>
            </div>
        </div>
    </section>

@endsection