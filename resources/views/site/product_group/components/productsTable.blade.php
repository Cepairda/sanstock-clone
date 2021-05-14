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
                    <img width="150"
                         src="{{'https://isw.b2b-sandi.com.ua/imagecache/150x150/' . strval($product["sku"])[0] . '/' . strval($product["sku"])[1] . '/' .  $product["sku"] . '.jpg'}}"
                         alt="">
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
