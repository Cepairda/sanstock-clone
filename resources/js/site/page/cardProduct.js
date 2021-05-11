(function(){
    "use strict";

    const pageProduct = document.body.classList.contains('product');
    if(!pageProduct) {
        return false;
    }

    const nameGetParam = 'sort';
    const paramsString = window.location.search;
    const searchParams = new URLSearchParams(paramsString);
    let tabSelector = '';

    if (searchParams.has(nameGetParam)) {
        tabSelector = `a[data-toggle="tab"][data-sort="${searchParams.get(nameGetParam)}"]`;
    } else {
        const tableContainer = 'table-products';
        const idContainerTabs =  'product-tabs';
        const containetTabs = document.querySelector(`#${idContainerTabs}`);

        if (containetTabs) {

             const s1 = (id) => {
                const container = containetTabs.querySelector(`#sort-${id}`);
                if (!container) {
                    return false;
                } else {
                    const tabTable = container.querySelector(`.table-products`);
                    if(tabTable) {
                        return `a[data-toggle="tab"][data-sort="${id}"]`;
                    } else {
                        return s1(++id);
                    }
                }

            };
            const result = s1(0);
            tabSelector = result ? result : '';
            console.log(result);
        }


    }
    $(tabSelector).tab('show');


    $('a[data-toggle="tab"][data-sort]').on('shown.bs.tab', function ({target}) {
        const sortNumber = target.dataset.sort;
        window.history.pushState({}, 'Title', `?sort=${sortNumber}`);
    })

}());