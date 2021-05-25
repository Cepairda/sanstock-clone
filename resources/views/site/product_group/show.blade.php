@extends('layouts.site')
@section('body_class', 'productGroup')
@section('meta_title', $productGroup->meta_title)
@section('meta_description', $productGroup->meta_description)

@section('breadcrumbs')
    @php($i = 2)
    @if (isset($productGroup->category))
        @foreach($productGroup->category->ancestors as $ancestor)
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="{{ route('site.resource', $ancestor->slug) }}" itemprop="item">
                    <span itemprop="name">
                        {{ $ancestor->name }}
                    </span>
                </a>
                <meta itemprop="position" content="{{ $i }}"/>
            </li>
            @php($i++)
        @endforeach
        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="{{ route('site.resource', $productGroup->category->slug) }}" itemprop="item">
                <span itemprop="name">
                     {{ $productGroup->category->name }}
                </span>
            </a>
            <meta itemprop="position" content="{{ $i++ }}"/>
        </li>
    @endif
    <li class="breadcrumb-item active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ $productGroup->name }}
        </span>
        <meta itemprop="position" content="{{ $i }}"/>
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
                            <img src="/storage/product/{{ $productGroup->sdCode }}/{{ $productGroup->sdCode }}.jpg"
                                 data-src="/storage/product/{{ $productGroup->sdCode }}/{{ $productGroup->sdCode }}.jpg">
                            @foreach($additional as $key => $value)
                                <img src="/storage/product/{{ $productGroup->sdCode }}/additional/{{ $productGroup->sdCode }}_{{ $key }}.jpg"
                                     data-src="/storage/product/{{ $productGroup->sdCode }}/additional/{{ $productGroup->sdCode }}_{{ $key }}.jpg">
                            @endforeach
                        </div>
                    </div>
                    <!-- END swipeGallery -->
                </div>

                <div class="col-12 col-lg-6 card__wrapper">
                    <h1 class="card__title">{!! $productGroup->name !!}</h1>
                    <p class="card__code">Код:<span class="card__code-id ml-1">{{ $productGroup->sd_code }}</span></p>
                    <div class="card__price--wrapp">
                        @php($addClassToPrice = 'updatePriceJs')


                        <div class="card__price"
                             style="
                                font-size: 30px;
                                display: inline-block;
                                padding: 0 10px;
                                background-color: #ec3f33;
                                border-radius: 3px;
                                color: #fff;
                                margin-bottom: 10px;">
                            <span>{{ __('Profit') }}:</span>
                            <span data-sort="price-old" class="{{ $addClassToPrice }}">
                                {{-- number_format(ceil($productGroup->price),0,'',' ') --}}1 200
                                <span>грн.</span>
                            </span>

                        </div>

                        <div class="card__price" style="padding: 0 10px;">
                            <span>Цена:</span>
                            <span data-product-sku="{{ $productGroup->sku }}"
                                  data-sort="price"
                                  class="{{ $addClassToPrice }}">
                                        {{ number_format(ceil($productGroup->price),0,'',' ')}}
                                    </span>
                            <span>грн.</span>
                            <span class="price-old">
                                {{-- number_format(ceil($productGroup->differencePrice),0,'',' ') --}}2 447 грн.
                            </span>
                        </div>




                    </div>
                    <p class="card__description">{{ $productGroup->description }}</p>
                </div>
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
                               href="#characteristics" role="tab" aria-controls="characteristics" aria-selected="true">{{ __('Technical characteristics') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-line"></div>

            <div class="container main__tab-content">
                <div class="row">
                    <div id="product-tabs" class="col-12 tab-content" data-active="{{ $sort }}">
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
                                <div id="nav-tab" class="nav nav-tabs" role="tablist">
                                    @for ($_sort = 0; $_sort < 4; $_sort++)
                                        <a class="nav-link w-25 text-center {{ isset($productsSort[$_sort]) ? '' : 'nav-link-gray' }}"
                                           data-sort="{{ $_sort }}"
                                           data-price="{!!  isset($productsSort[$_sort]) ? number_format(ceil($productsSort[$_sort]->price),0,'',' ')  : ''  !!}"
                                           data-toggle="tab" href="#sort-{{ $_sort }}"
                                           role="tab"
                                           aria-controls="nav-home"
                                           aria-selected="false">
                                            Сорт-{{ $_sort }}
                                        </a>
                                    @endfor
                                </div>
                            </nav>

                            <div id="nav-tabContent" class="tab-content">
                                @for ($_sort = 0; $_sort < 4; $_sort++)
                                    <div id="sort-{{ $_sort }}"
                                         class="tab-pane"
                                         role="tabpanel"
                                         aria-labelledby="nav-home-tab">
                                        @if ($productsSort[$_sort] ?? null)
                                            @include('site.product_group.components.productsTable',
                                            [
                                                'products' => $productsSort[$_sort]->products,
                                                'price' => $productsSort[$_sort]->price,
                                                'normalPrice' => $productsSort[$_sort]->normalPrice,
                                                'differencePrice' => $productsSort[$_sort]->differencePrice,
                                            ])
                                        @else
                                            <div style="text-align: center;">
                                                <p>{{ 'Товара данного сорта - нет' }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
