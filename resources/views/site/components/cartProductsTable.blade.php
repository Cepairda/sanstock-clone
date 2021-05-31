<div class="table-responsive cart__table">
    <table class="table table-hover">
        <caption>{{ __('Cart products') }}</caption>
        <thead>
        <tr>
            <td>{{ __('Product code') }}</td>
            <td>Фото</td>
            <td>{{ __('Name of') }}</td>
            <td>Сорт</td>
            <td>{{ __('Price') }}</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
            @foreach($orderProducts as $sku => $product)


                <tr>
                    <td>{{ $product["sku"] }}</td>
                    <td>
                        <img width="100" data-src="/storage/product/{{ $product["sdCode"]  }}/{{ $product["sdCode"] }}.jpg"
                             src="{{ asset('images/white_fone_150x150.jpg') }}" class="img-data-path lazy" alt="">
                    </td>
                    <td>
                        {{ $product["name"] }}

                        @foreach($product['defective_attributes'] as $defect)
                            <br>
                            {{ '- ' . $defect }}

                        @endforeach
                    </td>

                    <td>
                        <span data-toggle="tooltip" data-placement="top"
                              title="{{ __('descriptions.desc_sort-' . $product["grade"]) }}"
                              class="label" data-sort="{{ $product["grade"] }}">Сорт-{{ $product["grade"] }}</span>


                    </td>

                    <td>
                        <span class="text-nowrap">{{ number_format(ceil($product["price"]),0,'',' ') }} грн.</span>
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


            @endforeach
            @if(isset($order_sum))
                <tr class="h6 font-weight-bold not-hover">
                    <td colspan="3"></td>
                    <td class="text-right">{{ __('Total') }}:</td>
                    <td>{{  number_format(ceil($order_sum),0,'',' ') }} грн.</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
