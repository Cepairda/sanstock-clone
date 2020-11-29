<div class="product product-grid">
    <div class="product-img-wrap w-100" style="padding: 15px;">

{{--        <img src="https://b2b-sandi.com.ua/imagecache/large/{{ strval($product->sku)[0] }}/{{ strval($product->sku)[1] }}/{{ $product->sku }}.jpg" alt="product name">--}}

        {!! temp_img('https://b2b-sandi.com.ua/imagecache/large/' . strval($product->sku)[0] . '/' . strval($product->sku)[1] . '/' .  $product->sku . '.jpg') !!}

        <div class="product-icon-wrap">
            <span class="icon icon-md linear-icon-heart" data-toggle="tooltip"
                  data-original-title="Add to Wishlist"></span>
        </div>
    </div>
    <div class="product-caption">
        <h6 class="product-title">
{{--            {{ dd(route('site.resource', $product->slug)) }}--}}
            <a href="{{ route('site.resource', $product->slug) }}">{{ $product->name }}</a>
        </h6>
        <p class="product-price">
            <span>{{ $product->price}}</span>
        </p>
        <a class="button-gray-base button button-icon button-icon-left" href="#">
            <span>{{ __('Where buy')}}</span>
        </a>
    </div>
</div>
