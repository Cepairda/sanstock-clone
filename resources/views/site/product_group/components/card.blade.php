{{--<div class="col-12 col-lg-6 col-xl-4">--}}
<div class="product__wrapper">
        <div class="product__wrapper-lg">
            <a class="product__img" href="{{ route('site.resource', $productGroup->slug) }}?sort={{ $product->grade }}">
                <img class="product__img-lg img-data-path lazy"
                     data-src="/storage/product/{{ $productGroup->sdCode }}/{{ $productGroup->sdCode }}.jpg"
                     src="{{ asset('images/no_img.jpg') }}"
                     title="{{ $productGroup->name }}">
            </a>
            <div class="d-flex product-description">
                <a class="product-description__item "
                     href="{{ route('site.resource', $productGroup->slug) }}">
                    <span class="product-title">{{ $productGroup->name }}</span>
                </a>
            </div>

            <div class="product-wrapper">
                <a href="{{ route('site.resource', $productGroup->slug) }}?sort={{ $product->grade }}" data-toggle="tooltip" data-placement="top" title="{{ __('descriptions.desc_sort-' . $product->grade) }}" class="product-description--item">Сорт-{{ $product->grade }}</a>
                <div class="product-price">
                    <div class="product-price__item">
                        <p><span class="product-price__item--old">{{ number_format(ceil($product->normalPrice),0,'',' ') }} грн.</span></p>
                        <p>
                            <span data-product-sort-sd-code="{{ $productGroup->sdCode }}" data-product-sort-grade="{{ $product->grade }}">{{ number_format(ceil($product->price),0,'',' ') }}</span>
                            <span>грн.</span>
                        </p>

                    </div>
                    <a class="button" href="{{ route('site.resource', $productGroup->slug) }}?sort={{ $product->grade }}" alt="{{ $product->name }}"
                       data-target="add" data-barcode="{{ $product->sku }}">{{ __('Buy')}}</a>
                </div>
            </div>
        </div>
    </div>
{{--</div>--}}
