(function () {
    "use strict";

    const _pageProduct = document.body.classList.contains('productGroup');
    if (!_pageProduct) {
        return false;
    }

    const nameGetParam = 'sort';
    const paramsString = window.location.search;
    const searchParams = new URLSearchParams(paramsString);
    const _productTabs = document.querySelector('#product-tabs');
    const priceW = document.querySelector('.card__price--wrapp');
    const toSort = document.querySelector('#to-sort');
    const price = document.querySelector('[data-sort="price"]');
    const priceN = document.querySelector('[data-sort="price-normal"]');
    const priceD = document.querySelector('[data-sort="price-difference"]');
    let sort = 0;

    $('a[data-toggle="tab"][data-sort]').on('shown.bs.tab', function ({target}) {
        const sortNumber = target.dataset.sort;
        let pr = this.dataset.price;
        let nr = this.dataset.normal;
        let df = this.dataset.difference;
        if(pr !== '') {
            priceW.hidden = false;
            price.textContent = pr;
            priceN.textContent = nr;
            priceD.textContent = df;
        } else {
            priceW.hidden = true;
        }

        toSort.href = `#sort-tab-${sortNumber}`;
        window.history.pushState({}, 'Title', `?sort=${sortNumber}`);
    });
    $(`a#characteristics-tab[data-toggle="pill"]`).on('shown.bs.tab', function ({target}) {
        showHideCharacteristic();
    });

    toSort.addEventListener('click', function (e) {
        e.preventDefault();
        let element = document.querySelector(`${this.getAttribute('href')}`);
        if(element) {
            const y = element.getBoundingClientRect().top + window.pageYOffset - 120;
            window.scrollTo({top: y, behavior: 'smooth'});
        }
    }, false);

    if (searchParams.has(nameGetParam)) {
        sort = searchParams.get(nameGetParam);
    } else {
        let active = _productTabs ? _productTabs.dataset.active : undefined;
        active !== undefined ? (sort = active) : $(`a#characteristics-tab[data-toggle="pill"]`).tab('show');
    }

    let $tabSelector = $(`a[data-toggle="tab"][data-sort="${sort}"]`);
    $tabSelector.tab('show');


    //=== demo

    const glt = document.querySelectorAll('.th-gallery');
    glt.forEach(el => {
        lightGallery(el, {
            share: false,
            actualSize: false,
            download: true,
            zoom: true,
            fullScreen: true,
            thumbnail: true,
            showThumbByDefault: true,
        });
    });
}());