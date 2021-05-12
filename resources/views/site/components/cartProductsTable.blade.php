<div class="table-responsive cart__table">
    <table class="table table-hover">
        <caption>Корзина товаров</caption>
        <thead>
        <tr>
            <td>Код товара</td>
            <td>Фото</td>
            <td>Наименовае</td>
            <td>Количество</td>
            <td>Цена</td>
            <td>Сумма</td>
            <td></td>
        </tr>
        </thead>
        @foreach($orderProducts as $sku => $product)
            <tbody>
            <tr>
                <td>{{ $product["sku"] }}</td>
                <td>
                    {{--{!! img(['type' => 'product', 'sku' => $product["sku"], 'size' => 70, 'alt' => $product["name"], 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}--}}
                    <img width="150" data-src="" src="" class="lazy" alt="">
                </td>
                <td>{{ $product["name"] }}</td>

                <td>
                    {{ $product["quantity"] }}
                </td>

                <td data-max="{{ $product['max_quantity'] }}">
                    {{ $product["price"] }} грн.
                </td>

                <td>
                    {{ $product["quantity"] * $product["price"] }} грн.
                </td>
                <td>
                    <span style="cursor: pointer;" data-add="delete" data-barcode="{{ $product["sku"] }}">
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" stroke="#000" stroke-width="1.06" d="M16,16 L4,4"></path>
                            <path fill="none" stroke="#000" stroke-width="1.06" d="M16,4 L4,16"></path>
                        </svg>
                    </span>
                </td>

            </tr>
            </tbody>
        @endforeach
    </table>
</div>