// $(document).ready(function () {
//     $('.home__carousel').owlCarousel({
//         mouseDrag: false,//Отключаем MouseDrag (Т.к. у нас 1 изображение)
//         touchDrag: false,//Отключаем MouseDrag (Т.к. у нас 1 изображение)
//         pullDrag: false,//Отключаем MouseDrag (Т.к. у нас 1 изображение)
//         items: 1,
//         loop: false,
//         margin: 10,
//         nav: false,
//         navElement: 'div',
//         navText: ['<span class=" linear-icon-chevron-left"></span>', '<span class="linear-icon-chevron-right"></span>']
//     });
// });

$('body').on('click', '#showMore', function () {
    var $this = $(this);
    let page = $this.data('page');

    $.ajax({
        method: 'post',
        url: $this.data('url'),
        dataType: 'json',
        data: {
            page: page,
            slug: $this.data('slug'),
            _token: $this.data('token')
        },
        beforeSend: function () {
        },
        success: function (data) {

            $('.products-wrapper').append(data.products);
            if (data.show_more) {
                $this.data('page', data.show_more['page']);
                $this.data('parameters', data.show_more['parameters']);
            } else {
                $this.remove();
            }

            let pagination = $('.pagination li');

            if (pagination.length - page - 1) {
                $('.pagination li').eq(+page).addClass('active');
                $('.pagination li').eq(+page).empty().append('<span>' + (page) + '</span>').addClass('page-item');
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
});

window.delay = (() => {
    let timer = 0;
    return (callback, ms) => {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();



//favorites
(function(){
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    window.favoriteSelected = () => {
        let favorites = getCookie('favorites'),
            favoritesMass = (favorites === undefined || favorites === "") ? '' : favorites.split(','),
            leng = favoritesMass.length;
        favoriteLink.textContent = leng;
        if (leng) {
            favoritesMass.forEach(sku => {
                document.querySelector(`[data-add="favorite"][data-sku="${sku}"]`) && document.querySelector(`[data-add="favorite"][data-sku="${sku}"]`).classList.add('selected');
            });
        }
    }
    let favoriteLink = document.querySelector('.header-favorites-count'),
        favorites = document.querySelectorAll('[data-add="favorite"]'),
        addRemoveFavorite = favorite => {
            let date = new Date(),
                sku = favorite.dataset.sku,
                cookies = getCookie('favorites');
            date.setDate(date.getDate() + 365);

            if(!cookies){
                document.cookie = 'favorites' + "=" + sku + "; path=/; expires=" + date.toUTCString();
                favorite.classList.add('selected');
                document.querySelector('.header-favorites-count').textContent = 1;
            } else {
                let favorites = getCookie('favorites'),
                    favoritesMass = favorites.split(','),
                    indexSku = favoritesMass.indexOf(sku);

                if(indexSku < 0) {
                    favoritesMass.push(sku);
                    favorite.classList.add('selected');
                } else {
                    favoritesMass.splice(indexSku, 1);
                    if(document.body.classList.contains('favorites')) {
                        let card = favorite.closest('.product.product-grid');
                        card.parentElement.classList.add('hideBock')
                        setTimeout(() => card.parentElement.remove(), 355);

                        !favoritesMass.length && location.reload();
                    } else {
                        favorite.classList.remove('selected');
                    }
                }

                document.querySelector('.header-favorites-count').textContent = favoritesMass.length;
                document.cookie = 'favorites' + "=" + favoritesMass.join(',') + "; path=/; expires=" + date.toUTCString();
            }
        };
        document.addEventListener('click', function(e) {
            //console.log('we here');
            let t = e.target,
                favorite =  t.closest('[data-add="favorite"]');
            favorite && addRemoveFavorite(favorite);
        }, false);
    window.addEventListener('load', favoriteSelected(), false);
}());

//liveSearch
(function (){
    const inputSearch = document.querySelector('#rd-navbar-search-form-input'),
          searchResult = document.querySelector('.rd-search-results-live');
    async function xhrLiveSearch (value) {
        const xhrUrl = `${location.origin}/live-search?query=${value}`,
            response = await fetch(xhrUrl, {});
        if (response.status === 200) {
            let data = await response.text();
            searchResult.textContent = '';
            searchResult.insertAdjacentHTML('afterbegin', data);
            favoriteSelected();

            let val  = document.querySelector('.search_error .search');
            val ? val.textContent = value : undefined;
        }
    }

    inputSearch.oninput = function () {
        let value = this.value.trim();

        delay(function () {
            if (value.length >= 3) {
                xhrLiveSearch(value)
            }
        }, 500);
    }
}());

//update Price
(function (){
    // function formatNumber(num) {
    //     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
    // }

    let url = '/products/update-price',
        dataSku = document.querySelectorAll('[data-product-sku].updatePriceJs'),
        token = document.querySelector('input[name=_token]'),
        skuArray = [];

    for (let sku of dataSku) {
        skuArray.push(+sku.dataset.productSku);
    }

    if (skuArray.length && token) {
        fetch(url, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": token.value,
            },
            method: "post",
            credentials: "same-origin",
            body: JSON.stringify({'sku': skuArray}),
        }).then((response) => {
            return response.json();
        }).then((dataApi) => {
                console.log(dataApi);
            for (let skuApi in dataApi) {
                for (let sku of dataSku) {
                    if (+sku.dataset.productSku == skuApi) {
                        if (dataApi[skuApi]['discount_price']) {
                            sku.innerHTML = "<span>" + parseInt(dataApi[skuApi]['discount_price']).toLocaleString('ru-Ru') +"</span>  &nbsp;&nbsp;&nbsp;<span>" + parseInt(dataApi[skuApi]['price']).toLocaleString('ru-Ru') +"</span>";
                        } else {
                            sku.innerHTML = "<span>" + parseInt(dataApi[skuApi]['price']).toLocaleString('ru-Ru') +"</span>";
                        }
                    }
                }
            }
        });
    }
}());

//Reload page checkbox category
(function () {
    let form = document.querySelector('.section-divided__aside') || false;
    if(form) {
    form.addEventListener('input', e => {
        let checkbox = e.target.closest('[type="checkbox"]');
        checkbox && form.submit();
    }, false)
    }
}());

//lightgallery.js
//window.addEventListener("load", () => (document.body.classList.contains('product') && lightGallery(document.querySelector('.slick-track'))), false);

//filter category
(function () {
    const selectSort = document.querySelector('.form-input.select-filter');
    if (selectSort) {
        selectSort.onchange = function () {
            switch (+this.value) {
                case 1:
                    location.href = '?name=up';
                    break;
                case 2:
                    location.href = '?name=down';
                    break;
                case 3:
                    location.href = '?price=up';
                    break;
                case 4:
                    location.href = '?price=down';
                    break;
            }
        }
    }
}());

$('div.products-wrapper').on('mouseenter', '.product-img-wrap', function (){
    let currentImgWrap = this;
    let images = $(currentImgWrap).find('img').length;
    let sku = $(currentImgWrap).parent().find('.product-price').data('product-sku');

    if (images < 2) {
        $.ajax({
            method: 'post',
            url: '/products/get-first-additional',
            dataType: 'json',
            data: {
                sku: sku,//$this.data('slug'),
                _token: $('#csrf-token').val(),
            },
            success: function (data) {
                if(data.additional[0]) {
                    $(currentImgWrap).find('a').append("<img class='image-hover' src='" + data.additional[0] + "'>");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
});

/**
 * открытие модального окна 'Где купить'
 */
$('body').on('click', '#closeCarousel', function (){
    $('#modal-product').modal('hide');
    setTimeout(() => $('#partnersModal').modal({show: true}), 150);
});

/**
 * добавление паддинга для nav
 * при открытия модального окна bootstrap
 */
(function () {
    let $body = $('body');

    function bodyWidthScroll() {
        let body = document.body,
            pr1 = body.clientWidth, pr2;
        body.style.overflow = 'hidden';
        pr2 = body.clientWidth;
        body.style.overflow = null;
        return pr2 - pr1;
    }

    $body.on('show.bs.modal', function () {
        let navBar = document.querySelector('.rd-navbar-static'),
            navBarStuck = navBar ? navBar.classList.contains('rd-navbar--is-stuck') : false;
        if (navBarStuck) {
            let navBarPadRight = getComputedStyle(navBar).paddingRight;
            navBar.style.transition = 'none';
            navBar.style.paddingRight = `calc(${bodyWidthScroll()}px + ${navBarPadRight})`;
        }
    });
    $body.on('hidden.bs.modal', function () {
        let navBar = document.querySelector('.rd-navbar-static');
        navBar && (navBar.style.paddingRight = null);
    });
}());