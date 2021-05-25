<div class="table-responsive cart__table">
    <table class="table table-hover">
        <caption>Корзина товаров</caption>
        <thead>
        <tr>
            <td>Код товара</td>
            <td>Фото</td>
            <td>Наименование</td>
            <td>Сорт</td>
            <td>Цена</td>
            <td></td>
        </tr>
        </thead>
        @foreach($orderProducts as $sku => $product)

            <tbody>
            <tr>
                <td>{{ $product["sku"] }}</td>
                <td>
                    {{--{!! img(['type' => 'product', 'sku' => $product["sku"], 'size' => 70, 'alt' => $product["name"], 'class' => ['lazyload', 'no-src'], 'data-src' => true]) !!}--}}
                    <img width="100" data-src="/storage/product/{{ $product["sdCode"]  }}/{{ $product["sdCode"] }}.jpg" src="{{ asset('images/white_fone_150x150.jpg') }}" class="img-data-path lazy" alt="">
                </td>
                <td>
                    {{ $product["name"] }}

                    @foreach($product['defective_attributes'] as $defect)
                    <br>
                        {{ '- ' . $defect }}

                    @endforeach
                </td>

                <td>{{ $product["grade"] }}</td>

                <td data-max="{{ $product['max_quantity'] }}">
                    {{ $product["price"] }} грн.
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
