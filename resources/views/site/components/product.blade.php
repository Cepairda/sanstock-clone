<div class="product product-grid">
    <div class="product-img-wrap">
        <img src="{{ asset('images/site/21689.jpg') }}" alt="product name">
        <div class="product-icon-wrap">
            <span class="icon icon-md linear-icon-heart" data-toggle="tooltip"
                  data-original-title="Add to Wishlist"></span>
        </div>
    </div>
    <div class="product-caption">
        <h6 class="product-title">
            <a href="#">{{ $product->name ?? ' Смеситель для раковины LIDZ (CRM) 90 00 077 00' }}</a>
        </h6>
        <p class="product-price">
            <span>{{ $product->price ?? '1 832'}}</span>
        </p>
        <a class="button-gray-base button button-icon button-icon-left" href="#">
            <span>{{ __('Where buy')}}</span>
        </a>
    </div>
</div>