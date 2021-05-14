/**
 * data-target="add"  -  event
 * data-barcode="00000"  -   code
 *
 */

(function() {
    "use strict";
    const cookieKeyCart = 'products_cart';
    const cartCounterId = 'cart-count';
    const productUpDateToCartSelector = '[data-add="upDate"]';
    const productToCartModalSelector = '[data-add="modal"]';
    const productDeleteCartSelector = '[data-add="delete"]';
    const cartModalId = 'cartModal';
    const cartCounterNode = document.getElementById(`${cartCounterId}`);
    const toast =
            `<div class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2500">
                    <div class="toast-header">
                        <strong class="mr-auto">Bootstrap</strong>
                        <small>11 мин назад</small>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        Привет, мир! Это тост-сообщение.
                    </div>
                </div>`;

    class Cart {

        constructor() {
            this.cookieKeyCart = 'products_cart';
            this.cartCounterId = 'cart-count';
            this.productToCartContainerClassName = '[data-add="to-add"]';
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
            this.openModal = this.openModal.bind(this);

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

        setCookie(products){
            const date = new Date();
            date.setDate(date.getDate() + 1); //жизнь куки
            document.cookie = 'products_cart' + "=" + JSON.stringify(products) + "; path=/; expires=" + date.toUTCString();
            this.setCount(products);
            //this.setToast();

        }

        setCount(products = null) {
            let count;
            if(products != null) {
                count = Object.keys(products).length;
            } else {
                const cartData = this.getCookie(cookieKeyCart);
                count = Object.keys(cartData).length;
            }
            cartCounterNode.textContent = `${count}`;
        }

        buttonsChange(sku) {

            let cartData = this.getCookie(cookieKeyCart);
            let availability = false;

            if(!(cartData === undefined || cartData === "")) {
                const products = JSON.parse(cartData);
                availability = products.hasOwnProperty(sku);
            }

            const buttons = document.querySelectorAll(`${productUpDateToCartSelector}[data-barcode="${sku}"]`);
            buttons && buttons.forEach(btn => {
                if(availability) {
                    btn.classList.add('added');
                    btn.textContent = this.i18n[this.getLocalization()]['button-added'];
                } else {
                    btn.classList.remove('added');
                    btn.textContent = this.i18n[this.getLocalization()]['button-add'];
                }
            });

        }

        delete(button) {

            const productSku = button.dataset.barcode;

            const cartData = this.getCookie(cookieKeyCart);

            if(cartData) {

                const products = JSON.parse(cartData);
                delete products[productSku];

                this.setCookie(products);

                const tr = button.closest('tr');
                tr && (tr.remove());

                this.buttonsChange(productSku);


            }

        }

        checkCookieCart() {
            let cartData = this.getCookie(cookieKeyCart);
            let count = 0;
            if(!(cartData === undefined || cartData === "")) {
                const products = JSON.parse(cartData);
                count = Object.keys(products).length;
                for (const [key] of Object.entries(products)) {
                    this.buttonsChange(key);
                }

            }
            cartCounterNode.textContent = `${count}`;
            cartCounterNode.hidden= false;
        }

        upDateCart (addToCartBtn) {

            const productSku = addToCartBtn.dataset.barcode;
            const value = 1; //кол-во
            let products = {};
            const cartData = this.getCookie(cookieKeyCart);

            if (!cartData) {

                products[productSku] = value;
                this.setCookie(products);
                this.openModal();

            } else {

                products = JSON.parse(cartData);

                if (addToCartBtn.classList.contains('added')) {

                    delete products[productSku];
                    this.setCookie(products);
                    this.buttonsChange(productSku);

                } else {

                    products[productSku] = value;

                    this.setCookie(products);
                    this.buttonsChange(productSku);
                    this.openModal()

                }
            }

        }

        openModal() {
            const modalNode = document.getElementById(`${cartModalId}`);

            async function postData(url = '', data = {}) {
                // Default options are marked with *
                const response = await fetch(url, {
                    method: 'GET', // *GET, POST, PUT, DELETE, etc.
                    //mode: 'cors', // no-cors, *cors, same-origin
                    //cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                    //credentials: 'same-origin', // include, *same-origin, omit
                    headers: {
                        //'Content-Type': 'application/json',
                        'csrf-token': document.querySelector('#csrf-token').value,
                    },
                    //redirect: 'follow', // manual, *follow, error
                    //referrerPolicy: 'no-referrer', // no-referrer, *client
                });
                return await response.json(data); // parses JSON response into native JavaScript objects
            }

            postData('/order-products-table' )
                .then((data) => {
                    const table =  data.body; // JSON data parsed by `response.json()` call
                    document.body.insertAdjacentHTML('beforeend', table);
                    $(`#${cartModalId}`).modal('show');

                    $(`#${cartModalId}`).on('hidden.bs.modal', function (e) {
                        $(this).remove();
                    });
                });
        }

        setToast() {
            const tt = document.querySelector('#tt');
            //tt.innerHTML = '';
            tt.insertAdjacentHTML('beforeend', toast);
            $('.toast').on('hidden.bs.toast', function () {
                $(this).remove();
            });
            $('.toast').toast('show');
        }

        setEvent() {
            document.addEventListener('click', ({target}) => {
                const upDateBtn = target.closest(`${productUpDateToCartSelector}`);
                const openModal = target.closest(`${productToCartModalSelector}`);
                const deleteBtn = target.closest(`${productDeleteCartSelector}`);

                upDateBtn && this.upDateCart(upDateBtn);
                openModal && this.openModal();
                deleteBtn && this.delete(deleteBtn);
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

   window.cart =  new Cart();
}());
