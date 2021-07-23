{{--<div class="table-responsive table-products cart__table">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>{{ __('Product code') }}</td>
            <td>Фото</td>
            <td>{{ __('Description') }}</td>
            <td>{{ __('Price') }}</td>
            <td>{{ __('Add cart') }}</td>
        </tr>

        </thead>

        <tbody>


        @foreach($products as $sku => $product)
            <tr>
                <td>{{ $product["sku"] }}</td>
                <td>
                    <div class="_bl">
                        @php($defectiveImages = $product->allDefectiveImages)
                        @if(empty($defectiveImages))
                            <div class="_bl-g">
                                <img class="lazy img-data-path" width="75"
                                     data-src=""
                                     src="{{ asset('images/white_fone_150x150.jpg' )}}" alt="">
                            </div>
                        @else
                            <div class="_bl-g th-gallery">

                                @foreach($defectiveImages as $key => $value)
                                    <a href="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg">
                                        <img class="_bl-g--img lazy img-data-path" width="75"
                                             data-src="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg"
                                             src="{{ asset('images/white_fone_150x150.jpg' )}}" alt="">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </td>
                <td style="text-align: left;" data-price="{{ $price }}" data-oldprice="{{ $normalPrice }}">
                    @if($product->getData('defective_attributes'))
                        @foreach($product->getData('defective_attributes') as $defective_attribute)
                            {{ '- ' . $defective_attribute }}
                        @endforeach
                    @endif
                </td>
                <td>
                    @if ($normalPrice ?? null)
                        <p><span class="text-nowrap"><s>{{ number_format(ceil($normalPrice),0,'',' ') }} грн.</s></span></p>
                    @endif
                    <span class="text-nowrap">{{ number_format(ceil($price),0,'',' ') }} грн.</span>

                    <div class="pt-3">
                        <p class="mb-1">{{ __('Profit') }}:</p>
                        <span style="
                                min-width: 12px;
                                height: 20px;
                                margin-top: 2px;
                                padding: 2px 12px;
                                border-radius: 50px;
                                background-color: #ec3f33;
                                text-align: center;
                                color: #ffffff;
                                font-size: 14px;
                                font-weight: 700;
                                line-height: 20px;
                                white-space: nowrap;
                                box-shadow: 0 0 3px 0 rgba(0, 0, 0, .35)"
                        >{{ number_format(ceil($differencePrice),0,'',' ') }} грн.</span>
                    </div>

                </td>
                <td>
                    <button class="button" data-add="upDate" data-barcode="{{ $product->sku }}">{{ __('Add to cart') }}</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>--}}
<div class="table-products">
    <div class="row flex table-products__row">
        <div class="col-md-4">
            <div class="row text-center">
                <div class="col-md-6">{{ __('Product code') }}</div>
                <div class="col-md-6">Фото</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row  text-center">
                <div class="col-md-9 align-self-center">{{ __('Description') }}</div>
                <div class="col-md-3 align-self-center">{{ __('Price') }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="row  text-center">
                <div class="col-md-12 align-self-center">{{ __('Add cart') }}</div>
            </div>
        </div>
    </div>

    @foreach($products as $sku => $product)
        <div class="row flex table-products__row">
            <div class="col-6 col-md-4">
                <div class="row text-center">
                    <div class="col-md-6 col-12 align-self-center">{{ $product["sku"] }}</div>
                    <div class="col-md-6 col-12 align-self-center">
                        <div class="_bl">
                            @php($defectiveImages = $product->allDefectiveImages)
                            @if(empty($defectiveImages))
                                <div class="_bl-g">
                                    <img class="lazy img-data-path" width="75"
                                         data-src=""
                                         src="{{ asset('images/white_fone_150x150.jpg' )}}" alt="">
                                </div>
                            @else
                                <div class="_bl-g th-gallery tabs-products__preview-zoom">

                                    @foreach($defectiveImages as $key => $value)
                                        <a class="tabs-products__preview-zoom" href="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg">
                                            <img class="_bl-g--img lazy img-data-path" width="75"
                                                 data-src="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg"
                                                 src="{{ asset('images/white_fone_150x150.jpg' )}}" alt="">
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="row table-products__row-reverse">
                    <div  class="col-md-9 col-6 align-self-center" data-price="{{ $price }}" data-oldprice="{{ $normalPrice }}">
                        @if($product->getData('defective_attributes'))
                            @foreach($product->getData('defective_attributes') as $defective_attribute)
                                {{ '- ' . $defective_attribute }} <br>
                            @endforeach
                        @endif
                    </div>
                    <div  class="col-md-3 col-6 align-self-center text-center">
                        @if ($normalPrice ?? null)
                            <p><span class="text-nowrap"><s>{{ number_format(ceil($normalPrice),0,'',' ') }} грн.</s></span></p>
                        @endif
                        <span class="text-nowrap font-weight-bold">{{ number_format(ceil($price),0,'',' ') }} грн.</span>

                        <div class="pt-3">
                            <p class="mb-1">{{ __('Profit') }}:</p>
                            <span class="tabs-products__profit">{{ number_format(ceil($differencePrice),0,'',' ') }} грн.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-2 align-self-center tabs-products__add-to-cart">
                <div class="d-flex flex-row justify-content-around">
                    <div class="col-12 text-center">
                        <button class="button" data-add="upDate" data-barcode="{{ $product->sku }}">{{ __('Add to cart') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
