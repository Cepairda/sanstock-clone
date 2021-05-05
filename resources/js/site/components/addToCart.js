(function() {
    const cookieKeyCart = 'products_cart';
    const cartCounterId = 'cart-count';
    const productToCartContainerClassName = 'product-to-cart';
    const addToCart = 'add-to-cart';
    const cartCounterNode = document.getElementById(`${cartCounterId}`);
    if(!cartCounterNode) {
        return;
    }
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    function checkCookieCart() {
        const cartData = getCookie(cookieKeyCart);
        let count = 0;
        if(!(cartData === undefined || cartData === "")) {
            const toObj = JSON.parse(cartData);
            count = Object.keys(toObj).length;
        }
        cartCounterNode.textContent = `${count}`;
        cartCounterNode.hidden= false;
    }

    function upDataCart (addToCartBtn) {
        const container = addToCartBtn.closest(`.${productToCartContainerClassName}`);
        if(!container) {
            console.warn('@BeCrutch: not container!');
            return false;
        }
        const date = new Date();
        const productSku = container.dataset.sku;
        const value = container.querySelector('input').value;
        const addProductData = {};
        const cartData = getCookie(cookieKeyCart);
        date.setDate(date.getDate() + 1); //жизнь куки

        if(!cartData) {
            addProductData[productSku] = value;
            document.cookie = 'products_cart' + "=" + JSON.stringify(addProductData) + "; path=/; expires=" + date.toUTCString();
            cartCounterNode.textContent = `${Object.keys(addProductData).length}`;
        } else {
            const toObj = JSON.parse(cartData);
            toObj[productSku] = value;
            document.cookie = 'products_cart' + "=" + JSON.stringify(toObj) + "; path=/; expires=" + date.toUTCString();
            const count = Object.keys(toObj).length;
            cartCounterNode.textContent = `${count}`;
        }

    }

    document.addEventListener('click', ({target}) => {
        const cartBtn = target.closest(`.${addToCart}`);
        cartBtn && upDataCart(cartBtn);
    }, false);
    document.addEventListener('DOMContentLoaded', checkCookieCart, false);
}());

// $(document).ready(function(){
//     $('.toast').toast('show');
// });
// <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
//     <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
//     <div class="toast-header">
//     <strong class="mr-auto">Bootstrap</strong>
//     <small>11 мин назад</small>
// <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
//     <span aria-hidden="true">&times;</span>
// </button>
// </div>
// <div class="toast-body">
//     Привет, мир! Это тост-сообщение.
// </div>
// </div>
// </div>