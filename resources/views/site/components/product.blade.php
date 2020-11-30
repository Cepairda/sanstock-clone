<div class="product product-grid">
    <div class="product-img-wrap w-100" style="padding: 15px;">
        <a href="{{ route('site.resource', $product->slug) }}">
            {!! temp_img('https://b2b-sandi.com.ua/imagecache/large/' . strval($product->sku)[0] . '/' . strval($product->sku)[1] . '/' .  $product->sku . '.jpg') !!}
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
