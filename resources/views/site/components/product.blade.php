<div class="product product-grid">

    <div class="product-img-wrap w-100" style="padding: 30px;">
        <a href="{{ route('site.resource', $product->slug) }}" title="{{ $product->name }}">
        {{-- {!! temp_img('https://b2b-sandi.com.ua/imagecache/large/' . strval($product->sku)[0] . '/' . strval($product->sku)[1] . '/' .  $product->sku . '.jpg') !!}--}}

        {!! img(['type' => 'product', 'sku' => $product->sku, 'size' => 300, 'alt' => $product->name, 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}
        </a>

        @if ($product->icons)
            <div class="product-icon-wrap-left">
                @foreach($product->icons as $icon)
                    <span>
                        <img src="{{ $icon->image }}" title="{{ $icon->name }}" width="40" height="40">
                    </span>
                @endforeach
            </div>
        @endif

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

        <p class="product-price updatePriceJs"
            data-product-sku="{{ $product->sku }}">
            @if($product->price)
                <span>{{ number_format(ceil($product->price),0,'',' ') }}</span>

                @if ($product->oldPrice)
                    &nbsp;&nbsp;&nbsp;<span>{{ number_format(ceil($product->oldPrice),0,'',' ') }}</span>
                @endif
            @else
            {{ __('No price') }}
            @endif
        </p>

        <a class="button-gray-base button button-icon button-icon-left" href="{{ route('site.resource', $product->slug) }}" alt="{{ $product->name }}">
            <span>{{ __('Where buy')}}</span>
        </a>

    </div>

</div>
