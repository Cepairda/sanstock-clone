@extends('layouts.site')
@section('body_class', 'favorites')

@section('breadcrumbs')
    <li class="active">Избранное</li>
@endsection

@section('content')

    @include('site.components.breadcrumbs', ['title' => 'Избранное'])

    <section class="section-lg">

        <div class="container">
            <div class="row">
                @if($products->isNotEmpty())
                    <div class="col-12">

                        <div class="filter-shop-box">
                            <p class="heading-4">Мой список желаний</p>
                            <div class="form-wrap">
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
                            </div>
                        </div>
                    </div>

                    @foreach($products as $product)
                        <div class="col-sm-6 col-md-4 col-lg-3 mt-5">
                            @include('site.components.product')
                        </div>
                    @endforeach
                @else
                    <div class="col-12 mt-5">
                        <p class="heading-4">Нет избранных товаров</p>
                    </div>
                @endif
            </div>
        </div>

    </section>

@endsection