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
    let sort = 0;

    $('a[data-toggle="tab"][data-sort]').on('shown.bs.tab', function ({target}) {
        const sortNumber = target.dataset.sort;
        window.history.pushState({}, 'Title', `?sort=${sortNumber}`);
    });
    $(`a#characteristics-tab[data-toggle="pill"]`).on('shown.bs.tab', function ({target}) {
        showHideCharacteristic();
    });

    if (searchParams.has(nameGetParam)) {
        sort = searchParams.get(nameGetParam);
    } else {
        let active = _productTabs ? _productTabs.dataset.active : undefined;
        active !== undefined ? (sort = active) : $(`a#characteristics-tab[data-toggle="pill"]`).tab('show');
    }

    let $tabSelector = $(`a[data-toggle="tab"][data-sort="${sort}"]`);
    $tabSelector.tab('show');
}());