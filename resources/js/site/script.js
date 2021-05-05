
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



// //liveSearch
// (function (){
//     const inputSearch = document.querySelector('#rd-navbar-search-form-input'),
//           searchResult = document.querySelector('.rd-search-results-live');
//     async function xhrLiveSearch (value) {
//         const xhrUrl = `${location.origin}/live-search?query=${value}`,
//             response = await fetch(xhrUrl, {});
//         if (response.status === 200) {
//             let data = await response.text();
//             searchResult.textContent = '';
//             searchResult.insertAdjacentHTML('afterbegin', data);
//             favoriteSelected();
//
//             let val  = document.querySelector('.search_error .search');
//             val ? val.textContent = value : undefined;
//         }
//     }
//
//     inputSearch.oninput = function () {
//         let value = this.value.trim();
//
//         delay(function () {
//             if (value.length >= 3) {
//                 xhrLiveSearch(value)
//             }
//         }, 500);
//     }
// }());