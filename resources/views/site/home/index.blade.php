@extends('layouts.site')
@section('body_class', 'home')
@section('meta_title', __('Home title'))
@section('meta_description',  __('Home description'))

@section('content')

    <main class="main-container bgc-gray">

        @include('site.home.components.banner')

        <!-- Tabs -->
        <div class="tabs-products">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="tabs-products__caption">
                            <div>Lorem ipsum dolor sit.</div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, ea!</p>
                        </div>
                        <div class="tabs-products__btn-group">
                            <!--button class="btn btn-item active" data-toggle="#sort-0">Сорт - 0</button-->
                            @foreach($productsGradeKey as $key => $value)
                                <button class="btn btn-item {{ $value == $gradeActiveDefault ? 'active' : ''}}" data-toggle="#sort-{{ $value }}">Сорт - {{ $value }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 px-0">
                        <div class="tabs-products__container">
                            @foreach($productsBySort as $key => $products)
                                <div id="sort-{{ $key }}" class="container-item {{ $key == $gradeActiveDefault ? 'active' : ''}}">
                                    <div class="owl-carousel owl-theme">
                                        @foreach($products as $product)
                                            <div class="container-item__card">
                                                @include('site.product_group.components.card', [
                                                    'product' => $product,
                                                    'productGroup' => $product->productGroup
                                                ])
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Info-blocks -->
        <div class="info-blocks">
            <div class="container">
                <div class="row">

                    <!-- Sort-0 -->
                    <div class="col-12">
                        <div class="info-block">
                            <div class="info-block__image">
                                <img src="{{ asset('images/site/home-popular-category/' . 5443 . '_230.webp') }}"
                                     alt="ceramics-title">
                            </div>

                            <div class="info-block__desc">
                                <h3>Сорт-0</h3>
                                <p>Товар в этом сорте имеет, как правило, только повреждения упаковки. В некоторых случаях - еле заметные потертости и/или царапины. Скидка на изделия этого сорта минимальная.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sort-1 -->
                    <div class="col-12">
                        <div class="info-block">
                            <div class="info-block__desc">
                                <h3><i>Сорт-1</i></h3>
                                <p>К «сорту 1» относится продукция, которая может иметь испорченную упаковочную коробку, легкие потертости, легкую волнистость, небольшое нарушение геометрии, царапины, нечеткий логотип или его отсутствие. Цена на изделия этого сорта привлекательнее, чем у предыдущего.</p>
                            </div>
                            <div class="info-block__image">
                                <img src="{{ asset('images/site/home-popular-category/' . 5443 . '_230.webp') }}"
                                     alt="ceramics-title">
                            </div>
                        </div>
                    </div>


                    <!-- Sort-2 -->
                    <div class="col-12">
                        <div class="info-block">
                            <div class="info-block__image">
                                <img src="{{ asset('images/site/home-popular-category/' . 5443 . '_230.webp') }}"
                                     alt="ceramics-title">
                            </div>

                            <div class="info-block__desc">
                                <h3>Сорт-2</h3>
                                <p>У изделий этого сорта могут дополнительно присутствовать вмятины, вздутия/пятна на задней части изделия, сколы. Как следствие, скидка на изделия в этом сорте больше, чем у предыдущих сортов.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sort-3 -->
                    <div class="col-12">
                        <div class="info-block">
                            <div class="info-block__desc">
                                <h3><i>Сорт-3</i></h3>
                                <p>В «сорте 3» могут также присутствовать трещины, не влияющие на использование изделия. Наличие в большем масштабе, чем в предыдущих сортах, вмятин, царапин/точек/потертостей, кривизны корпуса и составляющих частей изделия, которые не исключают полноценное его использование. Соответственно, скидка на этот сорт самая максимальная.</p>
                            </div>
                            <div class="info-block__image">
                                <img src="{{ asset('images/site/home-popular-category/' . 5443 . '_230.webp') }}"
                                     alt="ceramics-title">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
