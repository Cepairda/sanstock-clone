<div class="product product-grid">

    <div class="product-img-wrap w-100" style="padding: 30px;">
        <a href="{{ route('site.resource', $product->slug) }}" title="{{ $product->name }}">
        {{-- {!! temp_img('https://b2b-sandi.com.ua/imagecache/large/' . strval($product->sku)[0] . '/' . strval($product->sku)[1] . '/' .  $product->sku . '.jpg') !!}--}}

        {!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 1000, 'alt' => $product->name]) !!}
        </a>

        <div class="product-icon-wrap">
            <span class="icon icon-md linear-icon-heart" data-add="favorite" data-sku="{{$product->getDetails('sku')}}"></span>
        </div>

    </div>

    <div class="product-caption">

        {{--<ul class="product-categories">
            <li><a href="#">{{ $product->category }}</a></li>
        </ul>--}}

        <div class="product-title">
            <a href="{{ route('site.resource', $product->slug) }}" alt="{{ $product->name }}">{{ $product->name }}</a>
        </div>

        <p class="product-price {{ !empty($product->price_updated_at) || $product->price_updated_at->addHours(4)->lt(\Carbon\Carbon::now()) ? 'updatePriceJs' : '' }}"
            data-product-sku="{{ $product->sku }}">
            @if($product->price)
                <span>{{ $product->price}}</span>
            @else
            {{ __('No price') }}
            @endif
        </p>

        <a class="button-gray-base button button-icon button-icon-left" href="{{ route('site.resource', $product->slug) }}" alt="{{ $product->name }}">
            <span>{{ __('Where buy')}}</span>
        </a>

    </div>

</div>
