@extends('layouts.site')
@section('body_class', 'product')
@section('meta_title', $product->meta_title)
@section('meta_description', $product->meta_description)

@section('breadcrumbs')
    @php($i = 2)
    @if (isset($product->category))
        @foreach($product->category->ancestors as $ancestor)
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
            <a href="{{ route('site.resource', $product->category->slug) }}" itemprop="item">
                <span itemprop="name">
                     {{ $product->category->name }}
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
            {{ $product->name }}
        </span>
        <meta itemprop="position" content="{{ $i }}" />
    </li>
@endsection

@section('jsonld')
    {!! $product->getJsonLd() !!}
@endsection

@section('content')



    <main class="main-container pd-bt{{ $product->category->dark_theme ? ' bgc-grad' : ' bgc-white' }}">

        @include('site.components.breadcrumbs', ['title' => $product->getData('name')])

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
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462.jpg">
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462/29462_1.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462/29462_1.jpg">
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462/29462_2.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462/29462_2.jpg">
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462/29462_3.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462/29462_3.jpg">
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462/29462_4.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462/29462_4.jpg">
                                    <img src="https://isw.b2b-sandi.com.ua/imagecache/150x150/2/9/29462.jpg" data-src="https://isw.b2b-sandi.com.ua/imagecache/large/2/9/29462.jpg">
                                </div>
                            </div>
                            <!-- END swipeGallery -->
                        </div>

                        <div class="col-12 col-lg-6 card__wrapper">

                            <h1 class="card__title">{!! $product->name !!}</h1>

                            {!! isset($json_ld) ? $json_ld : '' !!}

                            <p class="card__code">Код товара:<span class="card__code-id ml-1">{{ $product->sku }}</span></p>

                            <div class="card__price--wrapp">
                                @php($addClassToPrice = !isset($product->price_updated_at) || $product->price_updated_at->addHours(8)->lt(\Carbon\Carbon::now()) ? 'updatePriceJs' : '')
                                <p class="card__price">
                                    <span>Цена:</span>
                                    <span data-product-sku="{{ $product->sku }}" class="{{ $addClassToPrice }}">{{ number_format(ceil($product->price),0,'',' ')}}</span>
                                    <span>грн.</span>
                                </p>

                                @if($product->presence == 0)
                                    <p class="card__code"><span class="card__code-id">@lang('site.content.not_available')</span>
                                    </p>
                                @elseif($product->presence == 1)
                                    <p class="card__code"><span class="card__code-id">@lang('site.content.available')</span></p>
                                @elseif($product->presence == 2)
                                    <p class="card__code"><span
                                                class="card__code-id">@lang('site.content.out_of_production')</span></p>
                                @endif

                                <div class="card__btn">

                                    <div class="btn-link-block">

                                        @if($product->presence == 1)

                                            @if( !empty($partners) )

                                                <a class="btn-link-block-g" href="#" data-toggle="modal"
                                                   data-target="#exampleModal">@lang('site.content.buy')</a>

                                            @else

                                                <a class="btn-link-block-g"
                                                   href="{{ asset('/sale-points/') }}">@lang('site.content.buy')</a>

                                            @endif

                                        @endif

                                    </div>

                                    <div class="card__btn--icon">
                                        @if( (Request::ip() == '93.183.206.50') || (Request::ip() == '127.0.0.1') )
                                            <i id="comparison_{{ $product->sku }}" class="comparison"
                                               data-attribute="comparison"
                                               data-sku="{{ $product->sku }}"></i>
                                        @endif
                                        <i id="favorites_{{ $product->sku }}" class="far icon-favorites ml-0"
                                           data-attribute="favorites" data-sku="{{ $product->sku }}"></i>
                                    </div>

                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

                                    <script>
                                        function demoFromHTML() {

                                            var img = new Image();

                                            img.src = '/storage/product/585-{{ $product->sku }}.webp';

                                            var doc = new jsPDF('p', 'mm', 'a4');

                                            doc.addImage(img, 'PNG', 25, 0);

                                            doc.setTextColor(239, 111, 32);

                                            doc.setFontSize(14);

                                            doc.text(20, 200, 'Product code: {{$product->sku}}');

                                            doc.setTextColor(0, 0, 0);

                                            doc.setFontSize(11);

                                            doc.text(20, 220, window.location.href);

                                            doc.save('Q-tap-{{$product->sku}}.pdf');

                                        }
                                    </script>

                                    {{--<div class="btn-link-block btn-favorites">--}}
                                    {{--<div class="btn-link-block-g btn-favorites--lg">Избранное--}}
                                    {{--<div class="far fa-heart"></div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}

                                </div>
                            </div>

                            {{--@isset($serie_data)
                                <p class="card__code">
                                    <a class="serie-link" style="color: #ef6e20; text-decoration: underline solid;"
                                       href="{{ $serie_data['url'] }}">@lang('site.content.collection_go') {{ $serie_data['name'] }}</a>
                                </p>
                            @endisset--}}


                            <p class="card__description">{{ $product->description }}</p>
                        </div>

                    {{--<img class="w-100" src="{{ $product->main_image }}" alt="{{ $product->name }}" title="{{ $product->name }}">--}}
                    {{--{!! img(['type' => 'product', 'name' => $product->sku, 'data_value' => 0, 'format' => 'webp', 'size' => 585, 'class' => 'w-100']) !!}--}}

            </div>


        </div>

        <div>
            <div class="container main__detail">
                <div class="row">
                    <ul class="col-12 nav nav-pills" id="pills-tab" role="tablist" style="padding-left: 15px;">
                        <li class="nav-item" role="presentation" style="width: 50%;">
                            <a class="nav-link-i active" id="characteristics-tab" data-toggle="pill"
                               href="#characteristics" role="tab" aria-controls="characteristics" aria-selected="true">Технисческие
                                характеристики</a>
                        </li>
                        <li class="nav-item" role="presentation" style="width: 50%;">
                            <a class="nav-link-i" id="tab2-tab" data-toggle="pill" href="#tab2" role="tab"
                               aria-controls="tab2" aria-selected="false">Дефекты</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-line"></div>

            <div class="container main__tab-content">
                <div class="row">
                    <div class="col-12 tab-content">
                        <div class="tab-pane fade show active" id="characteristics" role="tabpanel"
                             aria-labelledby="characteristics-tab">
                            <div class="row tab-content__container">
                                @foreach($product->characteristics->chunk(ceil($product->characteristics->count() / 2)) as $characteristics)
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
                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

                            <ul>
                                <li>Lorem ipsum.</li>
                                <li>Lorem ipsum dolor sit amet.</li>
                                <li>Lorem ipsum dolor sit amet.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, velit.</li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
