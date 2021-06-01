//update Price
(function (){
    const pageType = document.getElementById('product-tabs') ? 'product' : 'category';

    let url = '/products/update-price',
        dataProductSort = document.querySelectorAll('[data-product-sort-sd-code]'),
        token = document.querySelector('input[name=_token]'),
        productSortArray = [];

    for (let data of dataProductSort) {
        productSortArray.push([data.dataset.productSortSdCode, +data.dataset.productSortGrade]);
    }

    if (productSortArray.length && token) {
        fetch(url, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": token.value,
            },
            method: "post",
            credentials: "same-origin",
            body: JSON.stringify({'data': productSortArray, 'type': pageType}),
        }).then((response) => {
            return response.json();
        }).then((dataApi) => {
            if (pageType == 'category') {
                for (let data of dataProductSort) {
                    let checkOnExist = false;

                    for (let productData in dataApi) {
                        if (data.dataset.productSortSdCode == dataApi[productData]['sdCode'] && +data.dataset.productSortGrade == dataApi[productData]['grade']) {
                            data.innerHTML = parseInt(Math.ceil(dataApi[productData]['price'])).toLocaleString('ru-Ru');
                            /* if (dataApi[skuApi]['discount_price']) {
                                sku.innerHTML = "<span>" + parseInt(dataApi[skuApi]['discount_price']).toLocaleString('ru-Ru') +"</span>  &nbsp;&nbsp;&nbsp;<span>" + parseInt(dataApi[skuApi]['price']).toLocaleString('ru-Ru') +"</span>";
                            } else {
                                sku.innerHTML = "<span>" + parseInt(dataApi[skuApi]['price']).toLocaleString('ru-Ru') +"</span>";
                            }*/
                            checkOnExist = true;
                        }
                    }

                    if (!checkOnExist) {
                        //let parent = data.closest(".col-12.col-lg-6.col-xl-4").remove();
                    }
                }
            } else if (pageType == 'product') {
                const products = document.querySelectorAll('.table-products table tbody tr');

                for (let data of products) {
                    let checkOnExist = false;

                    const tdArray = data.children;
                    const sku = tdArray[0].textContent.trim();
                    const balance = tdArray[3];//.textContent.trim();
                    const price = tdArray[4];//.textContent.trim();
                    const button = tdArray[5].firstElementChild;

                    for (let productData in dataApi) {
                        if (sku == dataApi[productData]['sku']) {
                            let priceApi = dataApi[productData]['price'] + ' грн.';

                            if (dataApi[productData]['oldPrice']) {
                                priceApi += "<p><s>" + dataApi[productData]['oldPrice'] + " грн.</s></p>";
                            }

                            balance.textContent = dataApi[productData]['balance'];
                            price.innerHTML = priceApi;

                            checkOnExist = true;
                        }
                    }

                    if (!checkOnExist) {
                        //let parent = data.closest(".col-12.col-lg-6.col-xl-4").remove();
                    }

                    button.textContent = 'Нет в наличии';
                }
            }
        });
    }
}());
