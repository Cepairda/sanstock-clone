<div class="product product-grid">
    <div class="product-img-wrap">
        <img src="https://b2b-sandi.com.ua/imagecache/large/{{ strval($product->sku)[0] }}/{{ strval($product->sku)[1] }}/{{ $product->sku }}.jpg" alt="product name">
        <div class="product-icon-wrap">
            <span class="icon icon-md linear-icon-heart" data-toggle="tooltip"
                  data-original-title="Add to Wishlist"></span>
        </div>
    </div>
    <div class="product-caption">
        {{-- <ul class="product-categories">
            <li><a href="#">{{ $product->category ?? 'Ctegory' }}</a></li>
        </ul> --}}
        <div class="product-title">
        {{-- {{ dd(route('site.resource', $product->slug)) }}--}}
            <a href="{{ route('site.resource', $product->slug) }}">{{ $product->name }}</a>
        </div>
        <p class="product-price">
            <span>{{ $product->price}}</span>
        </p>
        <a class="button-gray-base button button-icon button-icon-left" href="#">
            <span>{{ __('Where buy')}}</span>
        </a>
    </div>
</div>