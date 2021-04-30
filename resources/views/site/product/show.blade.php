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
            {{--<div class="main__breadcrumb">--}}
                {{--<ul class="main__breadcrumb-lg" itemscope itemtype="https://schema.org/BreadcrumbList">--}}
                    {{--<li class="breadcrumb-item" itemprop="itemListElement"--}}
                        {{--itemscope itemtype="https://schema.org/ListItem">--}}
                        {{--<a href="{{ asset('/') }}" itemprop="item" content="{{ asset('/') }}">--}}
                            {{--<span itemprop="name">@lang('site.content.home')</span>--}}
                        {{--</a>--}}
                        {{--<meta itemprop="position" content="1"/>--}}
                    {{--</li>--}}
                    {{--@php($i = 2)--}}
                    {{--@foreach($breadcrumb as $item)--}}
                        {{--<li class="breadcrumb-item" itemprop="itemListElement"--}}
                            {{--itemscope itemtype="https://schema.org/ListItem">--}}
                            {{--<a href="{{ asset($item->alias->url) }}" itemprop="item"--}}
                               {{--content="{{ asset($item->alias->url) }}">--}}
                                {{--<span itemprop="name">{{ str_limiter($item->name) }}</span>--}}
                            {{--</a>--}}
                            {{--<meta itemprop="position" content="{{ $i }}"/>--}}
                        {{--</li>--}}
                        {{--@php($i++)--}}
                    {{--@endforeach--}}
                    {{--<li class="breadcrumb-item active" itemprop="itemListElement"--}}
                        {{--itemscope itemtype="https://schema.org/ListItem">--}}
                                {{--<span itemprop="item" content="{{ asset($product->alias->url ) }}">--}}
                                    {{--<span itemprop="name">{{ str_limiter($product->name) }}</span>--}}
                                {{--</span>--}}
                        {{--<meta itemprop="position" content="{{ $i }}"/>--}}
                    {{--</li>--}}
                {{--</ul>--}}

            {{--</div>--}}


            <div class="row main__card">

                <div class="col-12 col-lg-6">

                    <div class="row slider mx-0 h-100">

                        <div class="col-lg-2 slider-icon">

                            <!-- swipeGallery -->
                            <div class="gallery-container">
                                <div class="gallery-images-container">
                                    <div class="gallery-images"></div>
                                </div>
                                {{--
                                    for lightGallery:

                                    src => "thumbnail: 150x150"
                                    data-src => "large: 800x800"
                                    data-full => ">= 1000x1000 (for scale)"
                                --}}
                                <div id="gallery" {{-- !empty($product->additional_images) || $product->documents->onlyPresentable()->isNotEmpty() ? '' : 'hidden' --}}>
                                    <img src="data:image/jpeg;base64,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"
                                         data-src="https://steamuserimages-a.akamaihd.net/ugc/940586530515504757/CDDE77CB810474E1C07B945E40AE4713141AFD76/">
                                    {{--@foreach($product->additional_images as $additionalImage)--}}
                                    {{--<img src=""--}}
                                    {{--data-src="">--}}
                                    {{--@endforeach--}}

                                </div>
                            </div>
                            <!-- END swipeGallery -->


                        </div>

                        <div class="col-lg-10 slider-img">

                            <div>

                                {{--{!! img(['type' => 'product', 'name' => $product->sku, 'data_value' => 0, 'size' => 458, 'class' => 'img-slide active']) !!}--}}

                            </div>

                        </div>

                    </div>

                    {{--<img class="w-100" src="{{ $product->main_image }}" alt="{{ $product->name }}" title="{{ $product->name }}">--}}


                    {{--{!! img(['type' => 'product', 'name' => $product->sku, 'data_value' => 0, 'format' => 'webp', 'size' => 585, 'class' => 'w-100']) !!}--}}


                </div>

                <div class="col-12 col-lg-6 card__wrapper">

                    @php( $product->name = str_replace('Q-tap', '<br>Q-tap', $product->name) )

                    @if( !empty($serie_data) )

                        {{--<h1 class="card__title">{!! str_replace($serie_data['name'], '<a href="' . $serie_data['url'] . '">' . $serie_data['name'] . '</a>', $product->name) !!}</h1>--}}
                        <h1 class="card__title">{!! str_replace($serie_data['name'], $serie_data['name'], $product->name) !!}</h1>

                    @else

                        <h1 class="card__title">{!! $product->name !!}</h1>

                    @endif

                    @if(auth()->check() && auth()->user()->accesses->contains('products.edit'))
                        <a class="btn btn-danger" href="{{ url('admin/products/' . $product->id . '/edit' ) }}">Редактировать</a>
                        <a class="btn btn-success" target="_blank"
                           href="{{ url('/image/by-sku/' . $product->sku . '/') }}">Генерировать изображения</a>
                    @endif

                    {!! isset($json_ld) ? $json_ld : '' !!}

                    <p class="card__code">@lang('site.content.sku'): <span
                                class="card__code-id">{{ $product->sku }}</span></p>

                    {{--<p><a href="javascript:demoFromHTML()" class="card__code">PDF</a></p>--}}

                    <div class="card__price--wrapp">
                        <p class="card__price">
                            @lang('site.content.price'):
                            <span data-product-sku="{{ $product->sku }}"
                                  class="{{ !isset($product->price_updated_at) || $product->price_updated_at->addHours(8)->lt(\Carbon\Carbon::now()) ? 'updatePriceJs' : '' }}">
                            {{ number_format(ceil($product->price),0,'',' ')}}
                        </span>
                            грн.
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
            </div>
            <div class="container main__detail px-0">
                <ul class="nav nav-pills row" id="pills-tab" role="tablist">
                    <li class="nav-item col-6">
                        <a class="nav-link-i active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                           role="tab"
                           aria-controls="pills-home" aria-selected="true">@lang('site.content.techhar')</a>
                    </li>
                    <li class="nav-item col-6">
                        <a class="nav-link-i nav-link-instruction" id="pills-profile-tab" data-toggle="pill"
                           href="#pills-profile"
                           role="tab"
                           aria-controls="pills-profile" aria-selected="false">@lang('site.comments.title')</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-line"></div>
        <div class="container main__tab-content">
            <div class="tab-content" id="pills-tabContent">

                <div class="nav-pills">
                    <div class="nav-link-i link-mobile active">@lang('site.content.techhar')</div>
                </div>

                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                     aria-labelledby="pills-home-tab">
                    <div class="row tab-content__container">



                        {{--@foreach($product->characteristics->chunk(ceil($product->characteristics->count() / 2)) as $k => $chunk)--}}
                            {{--<div class="col-md-12 col-lg-6 tab-content--{{ $k == 0 ? 'lf' : 'rg' }}">--}}
                                {{--<ul>--}}
                                    {{--@foreach($chunk as $characteristic)--}}
                                        {{--<li class="content__cont--lg">--}}
                                            {{--<div class="name-id">{{ $characteristic->name }}</div>--}}
                                            {{--<div class="name-lg">--}}
                                                {{--@if($characteristic->id === 27)--}}
                                                    {{--<a href="{{ $serie_data['url'] }}">{{ $serie_data['name'] }}</a>--}}
                                                {{--@elseif($characteristic->id === 26)--}}
                                                    {{--<a href="{{ asset('/') }}">{{ $characteristic->value->value }}</a>--}}
                                                {{--@else--}}
                                                    {{--{{ $characteristic->value->value }}--}}
                                                {{--@endif--}}
                                            {{--</div>--}}
                                            {{-- <div class="name-lg">{!! $characteristic->id === 27 ? '<a href="' . $serie_data['url'] . '">' . $serie_data['name'] . '</a>' :  $characteristic->value->value !!}</div>--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    </div>
                </div>

                <div class="nav-pills">
                    <div class="nav-link-i link-mobile active">@lang('site.comments.title')</div>
                </div>

                {{--<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">--}}

                    {{--<div class="row">--}}

                        {{--<div class="col-12 documentation-item">--}}

                            {{--@include('site.components.comments.index', ['resource_id' => $product->id, 'type' => 'product'])--}}

                        {{--</div>--}}

                        {{--@if( !empty($additional_uris) )--}}

                        {{--@foreach($additional_uris as $auri)--}}

                        {{--<div class="col-sm-12 col-md-6 documentation-item">--}}

                        {{--<img class="lazy w-100" data-src="{{ $auri }}" src="{{ asset('/site/libs/icon/logo.svg') }}"/>--}}

                        {{--</div>--}}

                        {{--@endforeach--}}

                        {{--@endif--}}

                    {{--</div>--}}

                {{--</div>--}}

            </div>
        </div>
        {{--<div class="bgc-gray main__product">--}}
            {{--<div class="container">--}}
                {{--<h4 class="main-product__title">@lang('site.content.recomended_products')</h4>--}}
                {{--<div class="row main-product">--}}
                    {{--{!! view('site.components.products', ['products' => $recommended_products, 'cols' => 3]) !!}--}}
                    {{--                    @foreach($recommended_products as $recommended_product)--}}
                    {{--                        <div class="col-md-6 col-lg-3 product__wrapper">--}}
                    {{--                            <div class="product__wrapper-lg">--}}
                    {{--                                <div class="product__img jsLink"--}}
                    {{--                                     data-href="{{ asset($recommended_product->alias->url) }}">--}}
                    {{--                                    <img class="product__img-lg" src="{{ $recommended_product->main_image }}"--}}
                    {{--                                         alt="{{ $recommended_product->name }}"--}}
                    {{--                                         title="{{ $recommended_product->name }}">--}}
                    {{--                                </div>--}}
                    {{--                                <div class="d-flex product-description">--}}
                    {{--                                    <div class="product-description__item jsLink"--}}
                    {{--                                         data-href="{{ asset($recommended_product->alias->url) }}">--}}
                    {{--                                        <h3 class="product-title">{{ $recommended_product->name }}</h3>--}}
                    {{--                                    </div>--}}
                    {{--                                    <i class="far icon-favorites ml-0" id="fav_{{ $recommended_product->sku }}" data-sku="{{ $recommended_product->sku }}"></i>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="product-wrapper">--}}
                    {{--                                    <p class="product-description--item">{{ $recommended_product->category->name }}</p>--}}
                    {{--                                    <div class="product-price">--}}
                    {{--                                        <div class="product-price__item">--}}
                    {{--                                            <p>{{ ceil($recommended_product->price) }} грн.</p>--}}
                    {{--                                        </div>--}}
                    {{--                                        <div class="btn-link-block">--}}
                    {{--                                            <a href="{{ asset($recommended_product->alias->url) }}"--}}
                    {{--                                               class="btn-link-block-g">@lang('site.content.buy')</a>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    @endforeach--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}


        <!-- Modal -->
        {{--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
             {{--aria-hidden="true">--}}
            {{--<div class="modal-dialog modal-dialog-centered modal-lg" role="document">--}}
                {{--<div class="modal-content">--}}
                    {{--<div class="modal-header">--}}
                        {{--<h6 class="modal-title" id="exampleModalLabel">@lang('site.pages.points')</h6>--}}
                        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                            {{--<span aria-hidden="true">&times;</span>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                    {{--<div class="modal-body">--}}
                        {{--<div class="row">--}}

                            {{--@foreach($partners as $partner)--}}

                                {{--@if( empty($partner['id']) )--}}


                                    {{--<div class="col-6 col-sm-4 col-md-3 partnet-list-item lead">--}}

                                        {{--<div onclick="window.open('{{ $partner['uri'] }}')">--}}

                                            {{--<img class="img-responsive" alt="partners" src="{{ asset('site/img/partners/empty.jpg') }}">--}}

                                            {{--<div class="message">@lang('site.pages.become-a-partner')</div>--}}

                                        {{--</div>--}}

                                    {{--</div>--}}

                                {{--@else--}}

                                    {{--<div class="col-6 col-sm-4 col-md-3 partnet-list-item">--}}

                                        {{--<div onclick="window.open('{{ $partner['uri'] }}')">--}}

                                            {{--<img id="shop-id-{{ $partner['id'] }}" class="img-responsive" alt="partners"--}}
                                                 {{--src="{{ asset('site/img/partners/' . $partner['id'] . '.jpg') }}">--}}

                                        {{--</div>--}}

                                    {{--</div>--}}

                                {{--@endif--}}

                            {{--@endforeach--}}

                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        {{--<div class="btn-link-block">--}}
                            {{--<a class="btn-link-block-g" data-dismiss="modal">Закрыть</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    </main>

@endsection
