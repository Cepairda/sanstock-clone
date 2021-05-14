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
                            <button class="btn btn-item active" data-toggle="#sort-0">Сорт - 0</button>
                            <button class="btn btn-item" data-toggle="#sort-1">Сорт - 1</button>
                            <button class="btn btn-item" data-toggle="#sort-2">Сорт - 2</button>
                            <button class="btn btn-item" data-toggle="#sort-3">Сорт - 3</button>
                        </div>
                    </div>

                    @php($products = \App\ProductSort::joinLocalization()->withProductGroup()->take(8)->get())

                    <div class="col-12 px-0">
                        <div class="tabs-products__container">
                            <div id="sort-0" class="container-item active">
                                <div class="owl-carousel owl-theme">

                                    @foreach($products as $product)
                                        <div class="container-item__card">
                                            @include('site.product.components.card', [
                                                'product' => $product,
                                                'productGroup' => $product->productGroup
                                            ])
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div id="sort-1" class="container-item">1</div>
                            <div id="sort-2" class="container-item">2</div>
                            <div id="sort-3" class="container-item">3</div>
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
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium dolorem eligendi eum expedita in maxime. Aliquam beatae consequatur doloribus eius in laudantium optio quisquam sequi.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sort-1 -->
                    <div class="col-12">
                        <div class="info-block">
                            <div class="info-block__desc">
                                <h3><i>Сорт-1</i></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut debitis exercitationem non omnis quis tenetur!</p>
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
                                <h3>Сорт-1</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium dolorem eligendi eum expedita in maxime. Aliquam beatae consequatur doloribus eius in laudantium optio quisquam sequi.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sort-3 -->
                    <div class="col-12">
                        <div class="info-block">
                            <div class="info-block__desc">
                                <h3><i>Сорт-3</i></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut debitis exercitationem non omnis quis tenetur!</p>
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
