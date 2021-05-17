@extends('layouts.site')
@section('body_class', 'productGroup')
@section('meta_title', $productGroup->meta_title)
@section('meta_description', $productGroup->meta_description)

@section('breadcrumbs')
    @php($i = 2)
    @if (isset($productGroup->category))
        @foreach($productGroup->category->ancestors as $ancestor)
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" >
                <a href="{{ route('site.resource', $ancestor->slug) }}" itemprop="item">
                    <span itemprop="name">
                        {{ $ancestor->name }}
                    </span>
                </a>
                <meta itemprop="position" content="{{ $i }}" />
            </li>
            @php($i++)
        @endforeach
        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" >
            <a href="{{ route('site.resource', $productGroup->category->slug) }}" itemprop="item">
                <span itemprop="name">
                     {{ $productGroup->category->name }}
                </span>
            </a>
            <meta itemprop="position" content="{{ $i++ }}" />
        </li>
    @endif
    <li class="breadcrumb-item active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ $productGroup->name }}
        </span>
        <meta itemprop="position" content="{{ $i }}" />
    </li>
@endsection

@section('jsonld')
    {!! $productGroup->getJsonLd() !!}
@endsection

@section('content')

    <main class="main-container pd-bt{{ false ? ' bgc-grad' : ' bgc-white' }}">

        @include('site.components.breadcrumbs', ['title' => $productGroup->getData('name')])

        <div class="container">

            <div class="row main__card">


                        <div class="col-lg-6">
                            <!-- swipeGallery -->
                            <div class="gallery-container">
                                <div class="gallery-images-container">
                                    <div class="gallery-images"></div>
                                </div>
                                <div id="gallery">
                                    {{--
                                      swipeGallery:
                                        src => "thumbnail: 150x150" - small
                                        data-src => "large: 800x800" - big
                                        data-full => ">= 1000x1000 (for scale)"
                                    --}}
                                    <img src="/storage/product/{{ $productGroup->sdCode }}/{{ $productGroup->sdCode }}.jpg" data-src="/storage/product/{{ $productGroup->sdCode }}/{{ $productGroup->sdCode }}.jpg">
                                    @foreach($additional as $key => $value)
                                        <img src="/storage/product/{{ $productGroup->sdCode }}/additional/{{ $productGroup->sdCode }}_{{ $key }}.jpg" data-src="/storage/product/{{ $productGroup->sdCode }}/additional/{{ $productGroup->sdCode }}_{{ $key }}.jpg">
                                    @endforeach
                                    <!--img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462/29462_1.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462/29462_1.jpg">
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462/29462_2.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462/29462_2.jpg">
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462/29462_3.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462/29462_3.jpg">
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462/29462_4.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462/29462_4.jpg">
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462.jpg"-->
                                </div>
                            </div>
                            <!-- END swipeGallery -->
                        </div>

                        <div class="col-12 col-lg-6 card__wrapper">

                            <h1 class="card__title">{!! $productGroup->name !!}</h1>

{{--                            {{dd($productGroup)}}--}}
                            <p class="card__code">Код группы:<span class="card__code-id ml-1">{{ $productGroup->sd_code }}</span></p>

                            <div class="card__price--wrapp">

{{--                                @php($addClassToPrice = !isset($productGroup->price_updated_at) || $productGroup->price_updated_at->addHours(8)->lt(\Carbon\Carbon::now()) ? 'updatePriceJs' : '')--}}
                                @php($addClassToPrice = 'updatePriceJs')
                                <p class="card__price">
                                    <span>Цена:</span>
                                    <span data-product-sku="{{ $productGroup->sku }}" data-sort="price"
                                          class="{{ $addClassToPrice }}">{{ number_format(ceil($productGroup->price),0,'',' ')}}</span>
                                    <span>грн.</span>
                                </p>
                                <p data-product-group="old_price" class="card__price text-muted d-none" style="font-size: 16px;">
                                    <span>Старая цена:</span>
                                    <span data-product-sku="{{ $productGroup->sku }}" data-sort="old_price"
                                          class="{{ $addClassToPrice }}"><s>{{ number_format(ceil($productGroup->price),0,'',' ')}}</s></span>
                                    <span>грн.</span>
                                </p>
                            </div>

                            {{--@isset($serie_data)
                                <p class="card__code">
                                    <a class="serie-link" style="color: #ef6e20; text-decoration: underline solid;"
                                       href="{{ $serie_data['url'] }}">@lang('site.content.collection_go') {{ $serie_data['name'] }}</a>
                                </p>
                            @endisset--}}


                            <p class="card__description">{{ $productGroup->description }}</p>
                        </div>

                    {{--<img class="w-100" src="{{ $productGroup->main_image }}" alt="{{ $productGroup->name }}" title="{{ $productGroup->name }}">--}}
                    {{--{!! img(['type' => 'product', 'name' => $productGroup->sku, 'data_value' => 0, 'format' => 'webp', 'size' => 585, 'class' => 'w-100']) !!}--}}

            </div>


        </div>

        <div>
            <div class="container main__detail">
                <div class="row">
                    <ul class="col-12 nav nav-pills" id="pills-tab" role="tablist" style="padding-left: 15px;">
                        <li class="nav-item" role="presentation" style="width: 50%;">
                            <a class="nav-link-i active" id="tab2-tab" data-toggle="pill" href="#tab2" role="tab"
                               aria-controls="tab2" aria-selected="false">Сорт</a>
                        </li>
                        <li class="nav-item" role="presentation" style="width: 50%;">
                            <a class="nav-link-i" id="characteristics-tab" data-toggle="pill"
                               href="#characteristics" role="tab" aria-controls="characteristics" aria-selected="true">Технисческие
                                характеристики</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-line"></div>

            <div class="container main__tab-content">
                <div class="row">
                    <div id="product-tabs" class="col-12 tab-content">
                        <div class="tab-pane fade" id="characteristics" role="tabpanel"
                             aria-labelledby="characteristics-tab">
                            <div class="row tab-content__container">
                                @foreach($productGroup->characteristics->chunk(ceil($productGroup->characteristics->count() / 2)) as $characteristics)
                                    <div class="col-12 col-lg-6">
                                        @foreach($characteristics as $characteristic)
                                            <div class="info-block" data-dropdown="false">
                                                <div class="info-block--name">{!! $characteristic->name !!}</div>
                                                <div class="info-block--value">{!! $characteristic->value !!} </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @for ($i = 0; $i < 4; $i++)
                                            <a class="nav-link w-25 text-center {{ $sort == $i ? 'active' : '' }}"
                                               data-sort="{{ $i  }}"
                                               data-toggle="tab" href="#sort-{{ $i}}"
                                               role="tab" onclick="changePriceBySort(this.dataset.sort)"
                                               aria-controls="nav-home"
                                               aria-selected="{{ $sort == $i ? 'true' : 'false' }}"
                                            >
                                                Сорт-{{ $i}}
                                            </a>
                                    @endfor
                                    <!--a class="nav-link w-25 text-center" data-sort="0" data-toggle="tab" href="#sort-0" role="tab" aria-controls="nav-home" aria-selected="true">Сорт-0</a>
                                    <a class="nav-link w-25 text-center" data-sort="1" data-toggle="tab" href="#sort-1" role="tab" aria-controls="nav-profile" aria-selected="false">Сорт-1</a>
                                    <a class="nav-link w-25 text-center" data-sort="2" data-toggle="tab" href="#sort-2" role="tab" aria-controls="nav-contact" aria-selected="false">Сорт-2</a>
                                    <a class="nav-link w-25 text-center" data-sort="3" data-toggle="tab" href="#sort-3" role="tab" aria-controls="nav-contact" aria-selected="false">Сорт-3</a-->
                                </div>
                            </nav>


                            <div class="tab-content" id="nav-tabContent">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="tab-pane {{ $sort == $i ? 'active show' : 'fade' }}" id="sort-{{ $i }}" role="tabpanel" aria-labelledby="nav-home-tab">
                                        @if ($productsSort[$i] ?? null)

                                            @include('site.product_group.components.productsTable', ['products' => $productsSort[$i]->products, 'productsDefectiveAttributes' => $productsDefectiveAttributes, 'sort' => $i, 'current_sort' => $sort])

                                        @else
                                           <div style="text-align: center;">{{ 'Товар не найден' }}</div>

                                        @endif
                                    </div>
                                @endfor
                                <!--div class="tab-pane fade" id="sort-0" role="tabpanel" aria-labelledby="nav-home-tab">
                                   {{--@include('site.product.components.productsTable')--}}
                                </div>
                                <div class="tab-pane fade" id="sort-1" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    {{--@include('site.product.components.productsTable')--}}
                                </div>
                                <div class="tab-pane fade" id="sort-2" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    @include('site.product.components.productsTable')
                                </div>
                                <div class="tab-pane fade" id="sort-3" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    нет товара
                                </div-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
