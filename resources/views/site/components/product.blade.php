<div class="product product-grid">
    <div class="product-img-wrap">
        <img src="{{ asset('images/site/21689.jpg') }}" alt="product name">
        <div class="product-icon-wrap">
            <span class="icon icon-md linear-icon-heart" data-toggle="tooltip"
                  data-original-title="Add to Wishlist"></span>
        </div>
    </div>
    <div class="product-caption">
        {{--<ul class="product-categories">
            <li><a href="#">Living Room</a></li>
            <li><a href="#">Dining room</a></li>
            <li><a href="#">Office</a></li>
            <li><a href="#">Bedroom</a></li>
        </ul>--}}
        <h6 class="product-title">
            <a href="#">{{ $product->name ?? '' }}</a>
        </h6>
        <p class="product-price">
            <span>{{ $product->price ?? ''}}</span>
        </p>
        <a class="button-gray-base button button-icon button-icon-left" href="#">
            <span>{{ __('Where buy')}}</span>
        </a>
    </div>
</div>