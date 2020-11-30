<div class="product product-grid">

    <div class="product-img-wrap w-100" style="padding: 30px;">

{{--        {!! temp_img('https://b2b-sandi.com.ua/imagecache/large/' . strval($product->sku)[0] . '/' . strval($product->sku)[1] . '/' .  $product->sku . '.jpg') !!}--}}

        {!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 1000, 'alt' => $product->name]) !!}

        <div class="product-icon-wrap">
            <span class="icon icon-md linear-icon-heart" data-toggle="tooltip" data-original-title="Add to Wishlist"></span>
        </div>

    </div>

    <div class="product-caption">

        {{--<ul class="product-categories">
            <li><a href="#">{{ $product->category }}</a></li>
        </ul>--}}

        <div class="product-title">
            <a href="{{ route('site.resource', $product->slug) }}">{{ $product->name }}</a>
        </div>

        <p class="product-price">
            @if($product->price)
                <span>{{ $product->price}}</span>
            @else
                Нет цены
            @endif
        </p>

        <a class="button-gray-base button button-icon button-icon-left" href="{{ route('site.resource', $product->slug) }}">
            <span>{{ __('Where buy')}}</span>
        </a>

    </div>

</div>
