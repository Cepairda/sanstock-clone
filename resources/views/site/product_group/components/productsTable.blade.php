<div class="table-responsive table-products cart__table">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>Код товара</td>
            <td>Фото</td>
            <td>Наименовае</td>
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
                    {{--{!! img(['type' => 'product', 'sku' => $product["sku"], 'size' => 70, 'alt' => $product["name"], 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}--}}
                    @foreach($product->defectiveImages as $key => $value)
                        <img width="150"
                             src="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg"
                             alt="">
                    @endforeach
                </td>
                <td>{{ $product->name }}</td>
                <td>
                    1
                </td>
                <td>
                    {{ $product->price }} грн.
                </td>
                <td>
                    <button class="button" data-add="upDate" data-barcode="{{ $product->sku }}">Купить</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
