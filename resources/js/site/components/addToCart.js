(function() {

    class Cart {
        constructor() {
            this.cookieKeyCart = 'products_cart';
            this.cartCounterId = 'cart-count';
            this.productToCartContainerClassName = '[data-target="add"]';
            this.cartCounterNode = document.getElementById(`${cartCounterId}`);
            this.i18n = {
              ru: {
                  'button-add': 'Купить',
                  'button-added': 'В корзине'
              },
              uk: {
                  'button-add': 'Купити',
                  'button-added': 'В кошику'
              }
            };

            this.getLocalization = this.getLocalization.bind(this);
            this.getCookie = this.getCookie.bind(this);
            this.checkCookieCart = this.checkCookieCart.bind(this);

            this.localization = this.getLocalization();

            this.run();
        }

        getLocalization(){
            const markup = document.documentElement;
            const localizationDocument = markup.getAttribute('lang');
            const localization = lang  => {
                const handl = {
                    'ru-UA' : 'ru',
                    'uk-UA' : 'uk'
                };
                return handl[lang];
            };
            return localization(localizationDocument);
        }

        getCookie(name) {
            const matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }

        checkCookieCart() {
            let cartData = this.getCookie(cookieKeyCart);
            let count = 0;
            if(!(cartData === undefined || cartData === "")) {
                const toObj = JSON.parse(cartData);
                count = Object.keys(toObj).length;

                const barcodeList = Object.getOwnPropertyNames(toObj);

                barcodeList.forEach( item => {
                    const btn = document.querySelector(`${productToCartContainerClassName}[data-barcode="${item}"]`);
                    btn && btn.classList.add('added')
                })
            }
            cartCounterNode.textContent = `${count}`;
            cartCounterNode.hidden= false;
        }

        upDataCart (addToCartBtn) {
            if(!addToCartBtn) {
                console.warn('@BeCrutch: not container!');
                return false;
            }
            const date = new Date();
            const productSku = addToCartBtn.dataset.barcode;
            const value = 1; //кол-во
            const addProductData = {};
            const cartData = this.getCookie(cookieKeyCart);
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

        setEvent() {
            document.addEventListener('click', ({target}) => {
                const cartBtn = target.closest(`${productToCartContainerClassName}`);
                cartBtn && this.upDataCart(cartBtn);
            }, false);
            document.addEventListener('DOMContentLoaded', this.checkCookieCart, false);
        }

        run() {
            this.setEvent();
            const obj = {
                'localization' : this.localization,
            };
            console.log(obj);
        }

    }


    new Cart();

    const cookieKeyCart = 'products_cart';
    const cartCounterId = 'cart-count';
    const productToCartContainerClassName = '[data-target="add"]';
    const cartCounterNode = document.getElementById(`${cartCounterId}`);
    if(!cartCounterNode) {
        return;
    }
    // function getCookie(name) {
    //     let matches = document.cookie.match(new RegExp(
    //         "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    //     ));
    //     return matches ? decodeURIComponent(matches[1]) : undefined;
    // }

    // function checkCookieCart() {
    //     const cartData = getCookie(cookieKeyCart);
    //     let count = 0;
    //     if(!(cartData === undefined || cartData === "")) {
    //         const toObj = JSON.parse(cartData);
    //         count = Object.keys(toObj).length;
    //
    //         const barcodeList = Object.getOwnPropertyNames(toObj);
    //
    //         barcodeList.forEach( item => {
    //          const btn = document.querySelector(`${productToCartContainerClassName}[data-barcode="${item}"]`);
    //          btn && btn.classList.add('added')
    //         })
    //     }
    //     cartCounterNode.textContent = `${count}`;
    //     cartCounterNode.hidden= false;
    // }
    //
    // function upDataCart (addToCartBtn) {
    //     if(!addToCartBtn) {
    //         console.warn('@BeCrutch: not container!');
    //         return false;
    //     }
    //     const date = new Date();
    //     const productSku = addToCartBtn.dataset.barcode;
    //     const value = 1; //кол-во
    //     const addProductData = {};
    //     const cartData = getCookie(cookieKeyCart);
    //     date.setDate(date.getDate() + 1); //жизнь куки
    //     if(!cartData) {
    //         addProductData[productSku] = value;
    //         document.cookie = 'products_cart' + "=" + JSON.stringify(addProductData) + "; path=/; expires=" + date.toUTCString();
    //         cartCounterNode.textContent = `${Object.keys(addProductData).length}`;
    //     } else {
    //         const toObj = JSON.parse(cartData);
    //         toObj[productSku] = value;
    //         document.cookie = 'products_cart' + "=" + JSON.stringify(toObj) + "; path=/; expires=" + date.toUTCString();
    //         const count = Object.keys(toObj).length;
    //         cartCounterNode.textContent = `${count}`;
    //     }
    //
    // }

    // document.addEventListener('click', ({target}) => {
    //     const cartBtn = target.closest(`${productToCartContainerClassName}`);
    //     cartBtn && upDataCart(cartBtn);
    // }, false);
    //document.addEventListener('DOMContentLoaded', checkCookieCart, false);
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