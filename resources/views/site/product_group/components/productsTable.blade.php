<div class="table-responsive table-products cart__table">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>Код товара</td>
            <td>Фото</td>
            <td>Описание</td>
            <td>Цена</td>
            <td>Добавить корзину</td>
        </tr>

        </thead>

        <tbody>


        @foreach($products as $sku => $product)
            <tr>
                <td>{{ $product["sku"] }}</td>
                <td>
                    <div class="_bl">
                        <div class="_bl-g th-gallery">
                            @foreach($product->defectiveImages as $key => $value)
                                <a href="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg">
                                    <img class="lazy img-data-path" width="75"
                                         data-src="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg"
                                         src="{{ asset('images/white_fone_150x150.jpg' )}}" alt="">
                                </a>
                            @endforeach
                        </div>
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
                        <p class="mb-1">Выгода:</p>
                        <span style="
                        min-width: 12px;
                        height: 20px;
                        margin-top: 2px;
                        padding: 2px 12px;
                        border-radius: 50px;
                        background-color: red;
                        text-align: center;
                        color: #ffffff;
                        font-size: 14px;
                        font-weight: 700;
                        line-height: 20px;
                        box-shadow: 0 0 3px 0 rgba(0, 0, 0, .35)"
                        >{{ number_format(ceil($differencePrice),0,'',' ') }} грн.</span>
                    </div>

                </td>
                <td>
                    <button class="button" data-add="upDate" data-barcode="{{ $product->sku }}">Купить</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
