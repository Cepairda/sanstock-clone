<div class="table-responsive table-products cart__table">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>Код товара</td>
            <td>Фото</td>
            <td>Описание</td>
            <td>Количество</td>
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
                        <div class="_bl-p"></div>
                        <div class="_bl-g th-gallery">
                            @foreach($product->defectiveImages as $key => $value)
                                <a href="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg">
                                    <img class="lazy img-data-path" width="75"
                                         data-src="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg"
                                         src="{{ asset('images/white_fone_150x150.jpg' )}}" alt="">
                                </a>
                            @endforeach
                        </div>
                        <div class="_bl-n"></div>
                    </div>
                </td>
                <td style="text-align: left;" data-price="{{ $product->price }}" data-oldprice="{{ $product->old_price }}">
                    @if(isset($productsDefectiveAttributes[$product["sku"]]))

                    @foreach($productsDefectiveAttributes[$product["sku"]] as $defective_attribute)

                        {{ '- ' . $defective_attribute }}

                    @endforeach
                    @endif
                </td>
                <td>
                    1
                </td>
                <td>
                    {{ $product->price }} грн.
                    @if ($product->old_price ?? null)
                        <p><s>{{ $product->old_price }} грн.</s></p>
                    @endif
                </td>
                <td>
                    <button class="button" data-add="upDate" data-barcode="{{ $product->sku }}">Купить</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>