<div class="col-12 d-flex justify-content-end py-5">

    <div class="dropdown">
        <p class="dropdown-toggle"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false"
           style="padding: 14px 16px; cursor: pointer;">
            {{ __('Additionally') }}
        </p>
        <div class="dropdown-menu dropdown-menu-right py-2">
            <p class="dropdown-item" href="#" style="font-size: 14px; cursor: pointer" data-add="clear">{{ __('Empty cart') }}</p>
        </div>
    </div>

    <a class="button" href="{{ asset('/cart/checkout') }}">{{ __('Checkout') }}</a>
</div>