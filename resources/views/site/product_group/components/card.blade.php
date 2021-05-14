{{--<div class="col-12 col-lg-6 col-xl-4">--}}
    <div class="product__wrapper">
        <div class="product__wrapper-lg">
            <div class="product__img jsLink" data-href="#">
                <img class="product__img-lg img-data-path lazy"
                     data-src="/storage/product/{{ $productGroup->sdCode }}/{{ $productGroup->sdCode }}.jpg"
                     src="{{ asset('images/no_img.jpg') }}"
                     title="{{ $productGroup->name }}">
            </div>
            <div class="d-flex product-description">
                <div class="product-description__item jsLink"
                     data-href="#">
                    <span class="product-title">{{ $productGroup->name }}</span>
                </div>
                <div class="product-icon">
                    <i id="comparison_123" class="comparison" data-attribute="comparison"
                       data-sku="123"></i>
                    <i id="favorites_123" class="far icon-favorites ml-0" data-attribute="favorites"
                       data-sku="123"></i>
                </div>
            </div>

            <div class="product-wrapper">
                <a href="{{ route('site.resource', $productGroup->category->slug) }}" class="product-description--item">Category{{ $productGroup->category->getData('name') }}</a>
                <div class="product-price">
                    <div class="product-price__item">
                        <p>
                            <span data-product-sku="123">{{ number_format(ceil($product->price),0,'',' ') }}</span>
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
