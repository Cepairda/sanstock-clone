@php

@endphp

<div class="col-12 col-lg-6 col-xl-4 product__wrapper">
    <div class="product__wrapper-lg">
        <div class="product__img jsLink" data-href="#">
            <img class="product__img-lg" src="{{'https://isw.b2b-sandi.com.ua/imagecache/large/' . strval($product->sd_code)[0] . '/' . strval($product->sd_code)[1] . '/' .  $product->sku . '.jpg'}}" title="{{ $product->name }}">
        </div>
        <div class="d-flex product-description">
            <div class="product-description__item jsLink"
                 data-href="#">
                <span class="product-title">{{ $product->name }}</span>
            </div>
            <div class="product-icon">
                <i id="comparison_123" class="comparison" data-attribute="comparison"
                   data-sku="123"></i>
                <i id="favorites_123" class="far icon-favorites ml-0" data-attribute="favorites"
                   data-sku="123"></i>
            </div>
        </div>

        <div class="product-wrapper">
            <a href="{{-- route('site.resource', $product->category->slug) --}}" class="product-description--item">Category{{-- $product->category->getData('name') --}}</a>
            <div class="product-price">
                <div class="product-price__item">
                    <p>
                        <span data-product-sku="123">{{ number_format(ceil($product->price),0,'',' ') }}</span>
                        <span>грн.</span>
                    </p>
                </div>
                <a class="button" href="{{ route('site.resource', $product->productGroup->slug) }}?sort={{ $product->grade }}" alt="{{ $product->name }}" data-target="add" data-barcode="{{ $product->sku }}">{{ __('Buy')}}</a>
            </div>
        </div>

    </div>
</div>
