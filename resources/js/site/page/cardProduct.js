(function(){
    "use strict";

    const pageProduct = document.body.classList.contains('product');
    if(!pageProduct) {
        return false;
    }

    const nameGetParam = 'sort';
    const paramsString = window.location.search;
    const searchParams = new URLSearchParams(paramsString);

    if (searchParams.has(nameGetParam)) {
        const id = nameGetParam + '-' + searchParams.get(nameGetParam) + '-tab';
        const tabSelector = `a[data-toggle="tab"]#${id}`;
        $(tabSelector).tab('show');
    }

}());