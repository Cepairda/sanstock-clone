@extends('layouts.site')
@section('body_class', 'product')
@section('meta_title', $product->meta_title)
@section('meta_description', $product->meta_description)

@section('breadcrumbs')
    @php($i = 2)
    @if (isset($product->category))
        @foreach($product->category->ancestors as $ancestor)
            <li itemprop="itemListElement"
                itemscope itemtype="https://schema.org/ListItem"
            >
                <a href="{{ route('site.resource', $ancestor->slug) }}" itemprop="item">
                    <span itemprop="name">
                        {{ $ancestor->name }}
                    </span>
                </a>
                <meta itemprop="position" content="{{ $i }}" />
            </li>
            @php($i++)
        @endforeach
        <li itemprop="itemListElement"
            itemscope itemtype="https://schema.org/ListItem"
        >
            <a href="{{ route('site.resource', $product->category->slug) }}" itemprop="item">
                <span itemprop="name">
                     {{ $product->category->name }}
                </span>
            </a>
            <meta itemprop="position" content="{{ $i++ }}" />
        </li>
    @endif
    <li class="active"
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

    @include('site.components.breadcrumbs', ['title' => $product->getData('name')])


    {{--<section class="section-sm bg-white">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-sm-12 col-lg-5">--}}

                    {{--<!-- Slick Carousel-->--}}
                    {{--<div class="slick-slider carousel-parent"--}}
                         {{--data-child="#child-carousel"--}}
                         {{--data-for="#child-carousel"--}}
                         {{--data-toggle="modal"--}}
                         {{--data-target="#modal-product">--}}
                            {{--<a class="img-thumbnail-variant-2" data-target="#carouselExample" data-slide-to="{{ $j = 0 }}" href="#">--}}
                                  {{--{!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 600, 'alt' => $product->name, 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}--}}
                            {{--<div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div>--}}
                            {{--</a>--}}
                        {{--@foreach($additional as $key => $uri)--}}

                                {{--<a class="img-thumbnail-variant-2" href="" data-target="#carouselExample" data-slide-to="{{ ++$j }}">--}}

                                        {{--<!--img data-src="" class="lazyload no-src" alt="" width="535" height="535"/-->--}}
                                    {{--{!! img([--}}
                                                {{--'type' => 'product',--}}
                                                {{--'sku' => $product->sku,--}}
                                                {{--'size' => 600,--}}
                                                {{--'alt' => $product->name,--}}
                                                {{--'class' => ['lazyload', 'no-src'],--}}
                                                {{--'data-src' => true,--}}
                                                {{--'additional' => true,--}}
                                                {{--'key' => $key--}}
                                            {{--])--}}
                                    {{--!!}--}}

                                    {{--<div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div>--}}
                                {{--</a>--}}

                        {{--@endforeach--}}

                    {{--</div>--}}
                    {{--<div class="slick-slider"--}}
                         {{--id="child-carousel"--}}
                         {{--data-for=".carousel-parent" --}}{{-- Селектор на большую картинку --}}
                         {{--data-arrows="true"          --}}{{-- Стрелки --}}
                         {{--data-loop="false"           --}}{{-- Бесконечный цикл скольжения --}}
                         {{--data-dots="false"           --}}{{-- Точечные индикаторы --}}
                         {{--data-swipe="true"           --}}{{-- Cмахивания / перетаскивания --}}
                         {{--data-center-mode="false"    --}}{{-- Центрирование активного слайда--}}
                         {{--data-items="2"              --}}{{-- Кол-во кратинок в слайдере --}}
                         {{--data-xs-items="2"--}}
                         {{--data-sm-items="3"--}}
                         {{--data-md-items="3"--}}
                         {{--data-lg-items="4"--}}
                         {{--data-slide-to-scroll="1">--}}
                        {{--<div class="item">--}}
                            {{--{!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 150, 'alt' => $product->name, 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}--}}
                        {{--</div>--}}

                        {{--@foreach($additional as $key => $uri)--}}

                            {{--<div class="item">--}}

                                {{--<!--img data-src="" class="lazyload no-src" alt="" width="535" height="535"/-->--}}
                                {{--{!! img([--}}
                                            {{--'type' => 'product',--}}
                                            {{--'sku' => $product->sku,--}}
                                            {{--'size' => 150,--}}
                                            {{--'alt' => $product->name,--}}
                                            {{--'class' => ['lazyload', 'no-src'],--}}
                                            {{--'data-src' => true,--}}
                                            {{--'additional' => true,--}}
                                            {{--'key' => $key--}}
                                        {{--])--}}
                                {{--!!}--}}

                            {{--</div>--}}

                        {{--@endforeach--}}

                    {{--</div>--}}

                {{--</div>--}}

                {{--<div class="col-sm-12 col-lg-7">--}}
                    {{--<div class="product-single">--}}
                        {{--<h4 class="product-single__title">{{ $product->getData('name') ?? 'PRODUCT NAME' }}</h4>--}}
                        {{--<p class="product-single__sku">Код товара:<span>{{ $product->details['sku'] }}</span></p>--}}
                        {{--<p class="product-single__description">{{ $product->description }}</p>--}}
                        {{--<p class="product-price {{ (empty($product->price_updated_at) || $product->price_updated_at->addHours(4)->lt(\Carbon\Carbon::now())) ? 'updatePriceJs' : '' }}"--}}
                           {{--data-product-sku="{{ $product->sku }}">--}}

                            {{--<span>{{ number_format(ceil($product->getDetails('price')),0,'',' ') }}</span>--}}

                            {{--@if ($product->oldPrice)--}}
                                {{--<span class="ml-3">{{ number_format(ceil($product->oldPrice),0,'',' ') }}</span>--}}
                            {{--@endif--}}

                        {{--</p>--}}
                        {{--<div class="mt-5" style="display: flex; align-items: center;">--}}
                            {{--<button class="button button-primary button-icon" data-toggle="modal" data-target="#partnersModal">--}}
                                {{--<span>{{ __('Where buy') }}</span></button>--}}

                            {{--@include('site.product.components.partners')--}}
                            {{--<!-- Modal -->--}}
{{--                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                                <div class="modal-dialog" role="document">--}}
{{--                                    <div class="modal-content">--}}
{{--                                        <div class="modal-header">--}}
{{--                                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Where buy') }}</h5>--}}
{{--                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                <span aria-hidden="true">&times;</span>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                        <div class="modal-body text-center">--}}
{{--                                            <p>{{ __('For all questions call') }}</p>--}}
{{--                                            <p >Call-Center: <a href="callto:0800210377">0-800-210-377</a></p>--}}
{{--                                        </div>--}}
{{--                                        <div class="modal-footer">--}}
{{--                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            {{--<span class="icon icon-md linear-icon-heart ml-4" data-add="favorite" data-sku="{{$product->getDetails('sku')}}"--}}
                                  {{--style="display: block; height: 100%;font-size: 35px; line-height: 1.5; cursor: pointer"></span>--}}
                        {{--</div>--}}
                        {{--<ul class="product-meta mt-5">--}}

                            {{--<li>--}}
                                {{--<dl class="list-terms-minimal">--}}
                                    {{--<dt>*</dt>--}}
                                    {{--<dd>{{ __('warning') }}</dd>--}}
                                {{--</dl>--}}
                            {{--</li>--}}

{{--                            <li>--}}
{{--                                <dl class="list-terms-minimal">--}}
{{--                                    <dt>SKU</dt>--}}
{{--                                    <dd>{{ $product->details['sku'] }}</dd>--}}
{{--                                </dl>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <dl class="list-terms-minimal">--}}
{{--                                    <dt>Category</dt>--}}
{{--                                    <dd>--}}
{{--                                        <ul class="product-categories">--}}
{{--                                            <li><a href="single-product.html">Living Room</a></li>--}}
{{--                                            <li><a href="single-product.html">Dining room</a></li>--}}
{{--                                            <li><a href="single-product.html">Bedroom</a></li>--}}
{{--                                            <li><a href="single-product.html">Office</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </dd>--}}
{{--                                </dl>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <dl class="list-terms-minimal">--}}
{{--                                    <dt>Tags</dt>--}}
{{--                                    <dd>--}}
{{--                                        <ul class="product-categories">--}}
{{--                                            <li><a href="single-product.html">Modern</a></li>--}}
{{--                                            <li><a href="single-product.html">Table</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </dd>--}}
{{--                                </dl>--}}
{{--                            </li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

    {{--<section class="section-sm bg-white">--}}
        {{--<div class="container">--}}
          {{--<div class="row">--}}
            {{--<div class="col-12">--}}

                {{--<!-- Bootstrap tabs-->--}}
                {{--<ul class="nav nav-tabs" id="myTab" role="tablist">--}}

                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('Description') }}</a>--}}
                    {{--</li>--}}

                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __('Specifications') }}</a>--}}
                    {{--</li>--}}

                {{--</ul>--}}

                {{--<div class="tab-content" id="myTabContent">--}}

                    {{--<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">--}}

                        {{--<p>{{ $product->description }}</p>--}}

                        {{--@foreach($additional as $key => $uri)--}}

                            {{--<div class="col-sm-12 text-center">--}}

                                {{--<!--img data-src="" class="lazyload no-src" alt="" width="535" height="535"/-->--}}
                                {{--{!! img([--}}
                                            {{--'type' => 'product',--}}
                                            {{--'sku' => $product->sku,--}}
                                            {{--'size' => 600,--}}
                                            {{--'alt' => $product->name,--}}
                                            {{--'class' => ['lazyload', 'no-src', 'img-fluid'],--}}
                                            {{--'data-src' => true,--}}
                                            {{--'additional' => true,--}}
                                            {{--'key' => $key--}}
                                        {{--])--}}
                                {{--!!}--}}

                            {{--</div>--}}

                        {{--@endforeach--}}

                    {{--</div>--}}

                    {{--<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">--}}

                    {{--<h5>{{ __('Characteristics') }}</h5>--}}

                    {{--<table class="table-product-info">--}}
                            {{--<tbody>--}}
                                {{--@foreach ($product->characteristics as $characteristic)--}}
                                    {{--@if ($characteristic->characteristic->published)--}}
                                        {{--<tr>--}}
                                            {{--<td>{{ $characteristic->name }}</td>--}}
                                            {{--<td>{{ $characteristic->value }}</td>--}}
                                        {{--</tr>--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                        {{--</table>--}}

                    {{--</div>--}}

                {{--</div>--}}

                {{--</div>--}}

            {{--</div>--}}

        {{--</div>--}}

    {{--</section>--}}

    {{--<section class="section-sm bg-white">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-12">--}}
                    {{--@php($enableComment = (config('settings.comments.' . $product->type . '.enable') && $product->getDetails('enable_comments')))--}}
                    {{--@php($enableReview = (config('settings.reviews.' . $product->type . '.enable') && $product->getDetails('enable_reviews')))--}}

                    {{--@if ($enableComment || $enableReview)--}}
                        {{--<ul class="nav nav-tabs" id="myTab" role="tablist">--}}
                            {{--@if ($enableComment)--}}
                                {{--<li class="nav-item">--}}
                                    {{--<a class="nav-link active" id="comment-tab" data-toggle="tab" href="#comment" role="tab" aria-controls="comment" aria-selected="true">{{ __('Comments') }}</a>--}}
                                {{--</li>--}}
                            {{--@endif--}}
                            {{--@if ($enableReview)--}}
                                {{--<li class="nav-item">--}}
                                    {{--<a class="nav-link {{ !$enableComment ? 'active' : '' }}" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">{{ __('Reviews') }}</a>--}}
                                {{--</li>--}}
                            {{--@endif--}}
                        {{--</ul>--}}
                        {{--<div class="tab-content" id="myTabContent">--}}
                            {{--@if ($enableComment)--}}
                            {{--<div class="tab-pane fade show active" id="comment" role="tabpanel" aria-labelledby="comment-tab">--}}

                                {{--<h4>{{ __('Comments') }}</h4>--}}

                                {{--@include('site.components.comments', ['comments' => $product->comments, 'resourceId' => $product->id, 'type' => 1])--}}

                                {{--<hr />--}}
                                {{--<h4>{{ __('Add comment') }}</h4>--}}
                                {{--<form method="post" enctype="multipart/form-data" action="{{ route('site.comments.store') }}">--}}
                                    {{--@csrf--}}

                                    {{--@if ((config('settings.comments.' . $product->type . '.stars')) && $product->getDetails('enable_stars_comments'))--}}
                                        {{--<div class="form-group mb-2">--}}
                                            {{--<div class="rating">--}}
                                                {{--<input type="radio" name="details[star]" id="product-comment-5" value="5"/>--}}
                                                {{--<label class="rating-label star" for="product-comment-5"></label>--}}
                                                {{--<input type="radio" name="details[star]" id="product-comment-4" value="4"/>--}}
                                                {{--<label class="rating-label star" for="product-comment-4"></label>--}}
                                                {{--<input type="radio" name="details[star]" id="product-comment-3" value="3"/>--}}
                                                {{--<label class="rating-label star" for="product-comment-3"></label>--}}
                                                {{--<input type="radio" name="details[star]" id="product-comment-2" value="2"/>--}}
                                                {{--<label class="rating-label star" for="product-comment-2"></label>--}}
                                                {{--<input type="radio" name="details[star]" id="product-comment-1" value="1"/>--}}
                                                {{--<label class="rating-label star" for="product-comment-1"></label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                    {{--<div class="form-group mb-2">--}}
                                        {{--<input type="text" name="details[name]" class="form-control" required="required" placeholder="{{ __('Name') }}" />--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group mb-2">--}}
                                        {{--<input type="email" name="details[email]" class="form-control email-comment" required="required" placeholder="Email" />--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group mb-2">--}}
                                        {{--<input type="tel" name="details[phone]" class="form-control phone-comment" required="required" placeholder="{{ __('Phone') }}" />--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group mb-2">--}}

                                    {{--</div>--}}
                                    {{--@if (config('settings.comments.files.enable'))--}}
                                        {{--<div class="form-group mb-2">--}}
                                            {{--<input type="file" name="attachment[]" class="filer_input" data-jfiler-limit="{{ config('settings.comments.files.count') ?? 5 }}" data-jfiler-fileMaxSize="{{ config('settings.comments.files.size') ?? 1 }}" multiple="multiple" data-jfiler-options='{"language": "{{ LaravelLocalization::getCurrentLocale() }}"}'>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                    {{--<input type="hidden" name="details[resource_id]" value="{{ $product->id }}" />--}}
                                    {{--<input type="hidden" name="details[type]" value="1" />--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input type="submit" class="btn btn-success" value="{{ __('Add comment') }}" />--}}
                                    {{--</div>--}}
                                {{--</form>--}}

                            {{--</div>--}}
                            {{--@endif--}}
                            {{--@if ($enableReview)--}}
                            {{--<div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">--}}

                                {{--<h4>{{ __('Reviews') }}</h4>--}}

                                {{--@include('site.components.comments', ['comments' => $product->reviews, 'resourceId' => $product->id, 'type' => 2])--}}

                                {{--<hr />--}}
                                {{--<h4>{{ __('Add review') }}</h4>--}}
                                {{--<form method="post" enctype="multipart/form-data" action="{{ route('site.comments.store') }}">--}}
                                    {{--@csrf--}}

                                    {{--@if ((config('settings.reviews.' . $product->type . '.stars')) && $product->getDetails('enable_stars_reviews'))--}}
                                        {{--<div class="form-group mb-2">--}}
                                            {{--<div class="rating">--}}
                                                {{--<input type="radio" name="details[star]" id="product-review-5" value="5"/>--}}
                                                {{--<label class="rating-label star" for="product-review-5"></label>--}}
                                                {{--<input type="radio" name="details[star]" id="product-review-4" value="4"/>--}}
                                                {{--<label class="rating-label star" for="product-review-4"></label>--}}
                                                {{--<input type="radio" name="details[star]" id="product-review-3" value="3"/>--}}
                                                {{--<label class="rating-label star" for="product-review-3"></label>--}}
                                                {{--<input type="radio" name="details[star]" id="product-review-2" value="2"/>--}}
                                                {{--<label class="rating-label star" for="product-review-2"></label>--}}
                                                {{--<input type="radio" name="details[star]" id="product-review-1" value="1"/>--}}
                                                {{--<label class="rating-label star" for="product-review-1"></label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                    {{--<div class="form-group mb-2">--}}
                                        {{--<input type="text" name="details[name]" class="form-control" required="required" placeholder="{{ __('Name') }}" />--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group mb-2">--}}
                                        {{--<input type="email" name="details[email]" class="form-control email-comment" required="required" placeholder="Email" />--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group mb-2">--}}
                                        {{--<input type="tel" name="details[phone]" class="form-control phone-comment" required="required" placeholder="{{ __('Phone') }}" />--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group mb-2">--}}

                                    {{--</div>--}}
                                    {{--@if (config('settings.comments.files.enable'))--}}
                                        {{--<div class="form-group mb-2">--}}
                                            {{--<input type="file" name="attachment[]" class="filer_input" data-jfiler-limit="{{ config('settings.comments.files.count') ?? 5 }}" data-jfiler-fileMaxSize="{{ config('settings.comments.files.size') ?? 1 }}" multiple="multiple" data-jfiler-options='{"language": "{{ LaravelLocalization::getCurrentLocale() }}"}'>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                    {{--<input type="hidden" name="details[resource_id]" value="{{ $product->id }}" />--}}
                                    {{--<input type="hidden" name="details[type]" value="2" />--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input type="submit" class="btn btn-success" value="{{ __('Add review') }}" />--}}
                                    {{--</div>--}}
                                {{--</form>--}}

                            {{--</div>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

    {{-- Карусель --}}
    {{--<div class="modal modal-product fade show" id="modal-product" tabindex="-1" role="dialog" aria-hidden="true">--}}

        {{--<div class="modal-dialog modal-product__container" role="document">--}}
            {{--<div class="modal-content h-100">--}}

                {{--<div class="modal-header">--}}
                    {{--<div class="modal-product__title" id="carouselModalLabel">{{ $product->getData('name') }}</div>--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">×</span>--}}
                    {{--</button>--}}
                {{--</div>--}}

                {{--<div class="modal-body d-flex flex-column">--}}

                    {{-- Carousel markup: https://getbootstrap.com/docs/4.4/components/carousel/ --}}
                    {{--<div id="carouselExample" class="carousel slide" data-ride="carousel" data-pause="hover">--}}

                        {{--<ol class="carousel-indicators">--}}

                            {{--<li class="active" data-target="#carouselExample" data-slide-to="0"></li>--}}

                            {{--@for ($c = 1; $c <= $j; $c++)--}}
                                {{--<li data-target="#carouselExample" data-slide-to="{{ $c }}"></li>--}}
                            {{--@endfor--}}

                        {{--</ol>--}}

                        {{--<div class="carousel-inner">--}}

                            {{--<div class="carousel-item active">--}}
                              {{--{!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 600, 'alt' => $product->name, 'class' => ['lazyload', 'no-src', 'image', 'imageZoom'], 'data-src' => true]) !!}--}}
                            {{--</div>--}}

                            {{--@foreach($additional as $key => $uri)--}}

                                {{--<div id="" class="carousel-item height">--}}
                                    {{--<!--img data-src="" class="lazyload no-src" alt="" width="535" height="535"/-->--}}
                                    {{--{!! img([--}}
                                                {{--'type' => 'product',--}}
                                                {{--'sku' => $product->sku,--}}
                                                {{--'size' => 600,--}}
                                                {{--'alt' => $product->name,--}}
                                                {{--'class' => ['lazyload', 'no-src', 'image', 'imageZoom'],--}}
                                                {{--'data-src' => true,--}}
                                                {{--'additional' => true,--}}
                                                {{--'key' => $key--}}
                                            {{--])--}}
                                    {{--!!}--}}
                                {{--</div>--}}

                            {{--@endforeach--}}
                        {{--</div>--}}

                        {{--<a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">--}}
                            {{--<span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
                            {{--<span class="sr-only">Previous</span>--}}
                        {{--</a>--}}

                        {{--<a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">--}}
                            {{--<span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
                            {{--<span class="sr-only">Next</span>--}}
                        {{--</a>--}}

                    {{--</div>--}}
                    {{--<div class="modal-product__price">--}}

                        {{--<div class="product-price text-center updatePriceJs"--}}
                            {{--data-product-sku="{{ $product->sku }}">--}}

                            {{--<span>{{ number_format(ceil($product->getDetails('price')),0,'',' ') }}</span>--}}

                            {{--@if ($product->oldPrice)--}}
                                {{--<span class="ml-3">{{ number_format(ceil($product->oldPrice),0,'',' ') }}</span>--}}
                            {{--@endif--}}

                        {{--</div>--}}
                        {{--<button class="button button-primary button-icon" id="closeCarousel" --}}{{--data-toggle="modal" data-target="#exampleModal"--}}{{-->--}}
                            {{--<span>{{ __('Where buy') }}</span>--}}
                        {{--</button>--}}

                        {{--<div style="display: flex; align-items: center;">--}}
                            {{--<span class="icon icon-md linear-icon-heart ml-4"--}}
                                  {{--data-add="favorite"--}}
                                  {{--data-sku="{{$product->getDetails('sku')}}"--}}
                                  {{--style="display: block; height: 100%;font-size: 35px; line-height: 1.5; cursor: pointer"></span>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{-- Карусель --}}


    {{--<!-- Divider-->--}}
    {{--<div class="shell">--}}
        {{--<div class="divider"></div>--}}
    {{--</div>--}}
    {{--@if($product->relateProducts->isNotEmpty())--}}
        {{--@include('site.product.carousel', ['title' => __('You may also be interested in')])--}}
    {{--@endif--}}


    <main class="main-container pd-bt{{ $product->category->dark_theme ? ' bgc-grad' : ' bgc-white' }}">


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

                            <div class="icon-btn img-icon-up"></div>

                            <div class="slider-icon__wrapp">

                                <ul id="lightgallery" class="slider-icon__container">

                                    @php($index = 1)

                                    <li class="img-icon active"
                                        href="{{ asset('storage/product/458-' . $product->sku . '.webp') }}">

                                        {{--{!! img(['type' => 'product', 'name' => $product->sku, 'size' => 458, 'class' => 'img-icon--lg', 'lazy' => true, 'alt' => $product->name . ' photo-' . $index++]) !!}--}}


                                    </li>

                                    {{--@php( $videos = config('video') )--}}

                                    {{--@foreach($videos as $video)--}}

                                        {{--@if( $product->sku == $video['sku'] )--}}

                                            {{--<li id="icon-video" class="img-icon"--}}

                                                {{--href="https://www.youtube.com/embed/{{ $video['key'] }}">--}}

                                                {{--<img class="lazy-img-thumb" src="{{ asset('site/img/logo75x75.png') }}"--}}
                                                     {{--data-src="https://img.youtube.com/vi/{{ $video['key'] }}/0.jpg">--}}

                                            {{--</li>--}}

                                        {{--@endif--}}

                                    {{--@endforeach--}}

                                    @if( !empty($additional_uris) )

                                        @foreach($additional_uris as $auri)

                                            <li class="img-icon" href="{{ $auri }}">

                                                <img class="lazy-img-thumb" data-src="{{ $auri }}"
                                                     src="{{ asset('site/img/logo75x75.png') }}"
                                                     alt="{{ $product->name }} photo-{{ $index++ }}"/>

                                            </li>

                                        @endforeach

                                    @endif

                                </ul>

                            </div>

                            <div class="icon-btn img-icon-down"></div>

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
