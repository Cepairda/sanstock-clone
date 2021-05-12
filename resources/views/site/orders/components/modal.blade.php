<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Кошик</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('site.components.cartProductsTable')
            </div>
            <div class="modal-footer">
                <button type="button" class="button added" data-dismiss="modal">Закрыть</button>
                <a href="{{ asset('/cart/checkout') }}" type="button" class="button">Перейти к оформлению</a>
            </div>
        </div>
    </div>
</div>