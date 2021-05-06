$(document).ready(function () {
    var priceRangeSlider = $('#priceRangeSlider');
    if (priceRangeSlider.length) {
        priceRangeSlider.slider().on({
            slide: (slideEvt) => {
                $('.inp-price-min').val(slideEvt.value[0]);
                $('.inp-price-max').val(slideEvt.value[1]);
            },
            slideStart: (slideEvt) => {
                $('.inp-price-min').val(slideEvt.value[0]);
                $('.inp-price-max').val(slideEvt.value[1]);
            }
        });
        $('#inp-price-min').val($('.min-slider-handle').attr('aria-valuenow'));
        $('#inp-price-max').val($('.max-slider-handle').attr('aria-valuenow'));
    }

});


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