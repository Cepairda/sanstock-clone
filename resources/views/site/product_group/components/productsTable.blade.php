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
                    @foreach($product->defectiveImages as $key => $value)
                        <img width="150"
                             src="/storage/product/{{ $productGroup->sdCode }}/{{ $product->sku }}/{{ $product->sku }}_{{ $key }}.jpg"
                             alt="">
                    @endforeach
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

{{--<script>--}}
    {{--function changePriceBySort(sort) {--}}

        {{--if(sort in sort_price) {--}}

            {{--let price = document.querySelector('[data-sort="price"]');--}}

            {{--if(price !== null) {--}}

                {{--if('price' in sort_price[sort] && sort_price[sort].price !== '') {--}}
                    {{----}}
                    {{--price.textContent = sort_price[sort].price;--}}

                    {{--let oldPrice = document.querySelector('[data-product-group="old_price"]');--}}
                    {{--if(oldPrice !== null) {--}}
                        {{--if('old_price' in sort_price[sort] && sort_price[sort].old_price !== '') {--}}
                            {{--oldPrice.querySelector('[data-sort="old_price"] s').textContent = sort_price[sort].old_price;--}}
                            {{--if(oldPrice.classList.contains('d-none')) oldPrice.classList.remove('d-none');--}}
                        {{--} else {--}}
                            {{--oldPrice.querySelector('[data-sort="old_price"] s').textContent = '0';--}}
                            {{--if(!oldPrice.classList.contains('d-none')) oldPrice.classList.add('d-none');--}}
                        {{--}--}}
                    {{--}--}}
                {{--} else {--}}

                    {{--price.textContent = '0';--}}
                {{--}--}}
            {{--}--}}
        {{--}--}}
        {{--addOrReplaceOrderBy('sort', sort);--}}
    {{--}--}}

    {{--function addOrReplaceOrderBy(paramName, newData) {--}}
        {{--let url = new URL(window.location.href);--}}
        {{--url.searchParams.set(paramName, newData);--}}
        {{--history.pushState(null, null, url.href);--}}
    {{--}--}}

    {{--changePriceBySort('{{$current_sort}}');--}}

{{--</script>--}}
