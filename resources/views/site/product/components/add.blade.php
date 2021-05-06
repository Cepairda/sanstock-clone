@php($barcode = isset($product->sku) ? $product->sku : (isset($product['sku']) ? $product['sku'] : null))
<!-- add -->
<div class="add__container product-to-cart" data-target="add" data-sku="{{ $barcode }}" {{ isset($barcode) ? '' : 'style="border-color: red;"' }}>

    <div class="add__quantity">
        <button class="add__quantity--btn" data-add="minus">-</button>
        <input class="add__quantity--input" data-add="input" type="text" value="{{ isset($product["quantity"]) ? $product["quantity"] : '1' }}" style="text-align: center; width: 100px;" readonly>
        <button class="add__quantity--btn" data-add="plus">+</button>
        <div class="add__quantity--available">Доступно: <span>1</span></div>
    </div>

    <div class="add__to-cart btn-link-block add-to-cart" data-target="add" data-sku="{{ $barcode }}">
       <span class="btn-link-block-g">Добавить в козину</span>
    </div>

</div>