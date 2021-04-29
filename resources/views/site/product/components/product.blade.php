@php

@endphp

<div class="col-12 col-lg-6 col-xl-4 product__wrapper">
    <div class="product__wrapper-lg">
        <div class="product__img jsLink" data-href="#">

            {{--{!! img(['type' => 'product', 'name' => $product->sku, 'format' => 'jpg', 'size' => 237, 'class' => 'product__img-lg', 'lazy' => true, 'alt' => $product->name]) !!}--}}

        </div>
        <div class="d-flex product-description">
            <div class="product-description__item jsLink"
                 data-href="#">
                <span class="product-title">Lorem ipsum dolor.</span>
            </div>
            <div class="product-icon">
                <i id="comparison_123" class="comparison" data-attribute="comparison"
                   data-sku="123"></i>
                <i id="favorites_123" class="far icon-favorites ml-0" data-attribute="favorites"
                   data-sku="123"></i>
            </div>
        </div>

        <div class="product-wrapper">
            <p class="product-description--item">Lorem ipsum.</p>
            <div class="product-price">
                <div class="product-price__item">
                    <p>
                            <span data-product-sku="123">
                                {{ number_format(ceil($product->price),0,'',' ') }}
                            </span>
                        <span>грн.</span>
                    </p>
                    {{--@if($product->presence == 0)--}}
                        {{--<p><span>@lang('site.content.not_available')</span></p>--}}
                    {{--@elseif($product->presence == 1)--}}
                        {{--<p><span>@lang('site.content.available')</span></p>--}}
                    {{--@elseif($product->presence == 2)--}}
                        {{--<p><span>@lang('site.content.out_of_production')</span></p>--}}
                    {{--@endif--}}
                </div>
                <div class="btn-link-block">
                    <a href="{{ route('site.resource', $product->slug) }}" alt="{{ $product->name }}"
                       class="btn-link-block-g">{{ __('Where buy')}}</a>
                </div>
            </div>
        </div>

    </div>
</div>
