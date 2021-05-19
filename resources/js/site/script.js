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


    $('.owl-carousel').owlCarousel({
        items:4
    });


});

function eff({offsetX, offsetY, target}) {
    const btn = target.closest('.button');
    if(!btn) {
     return;
    }
    const el = document.createElement('span');
    const r = {
        x: - btn.offsetWidth,
        y: 0
    };
    el.style.setProperty('transform', `translate3d(${r.x}px, ${r.y}px, 0px)`);
    btn.insertAdjacentElement('afterbegin', el);
    const el1 = btn.querySelector('span');
    setTimeout( ()=> {el1.classList.add('xx');}, 160);
}
function effEnd({target}) {
    const btn = target.closest('.button');
    if(!btn) {
        return;
    }
    const el = btn.querySelectorAll('span');
    el.forEach(elem => elem.remove());
}

document.addEventListener('mouseover', eff, false);
document.addEventListener('mouseout', effEnd, false);
document.addEventListener('click', ({target}) => {
    //const x = target.closest('');
});

//liveSearch
(function (){
    const inputSearch = document.querySelector('#input-search'),
          searchResult = document.querySelector('.search-results-live');
    async function xhrLiveSearch (value) {
        const xhrUrl = `${location.origin}/live-search?query=${value}`,
            response = await fetch(xhrUrl, {});
        if (response.status === 200) {
            let data = await response.text();
            searchResult.textContent = '';
            searchResult.insertAdjacentHTML('afterbegin', data);

            let val  = document.querySelector('.search_error .search');
            val ? val.textContent = value : undefined;
        }
    }

    inputSearch.oninput = function () {
        let value = this.value.trim();

        delay(function () {
            if (value.length >= 3) {
                xhrLiveSearch(value)
                inputSearch.classList.add('no-empty');
            } else if (value.length == 0) {
                inputSearch.classList.remove('no-empty');
            }
        }, 500);
    }

    inputSearch.onfocus = function () {
        inputSearch.classList.add('active');
    }

    inputSearch.onblur = function () {
        inputSearch.classList.remove('active');
    }
}());

window.delay = (() => {
    let timer = 0;
    return (callback, ms) => {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

//Reload page checkbox category
(function () {
    let form = document.querySelector('#sidebar-filter') || false;

    if(form) {
        form.addEventListener('input', e => {
            let checkbox = e.target.closest('[type="checkbox"]');
            checkbox && form.submit();
        }, false)
    }
}());
