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
        responsive : {
            // breakpoint from 0 up
            0 : {
                items: 1
            },
            // breakpoint from 480 up
            500 : {
                items: 2
            },
            // breakpoint from 992 up
            992 : {
                items: 3
            },
            // breakpoint from 1200 up
            1200 : {
                items: 4
            }
        },

    });

    $('[data-toggle="tooltip"]').tooltip();
    $('[type="tel"]').mask('+38 (000) 000-00-00');
});

//To top
(() => {
    const selector = '#to-top';
    const coefficient = 2;
    const toTop = document.querySelector(selector);
    const clientHeight = document.documentElement.clientHeight / coefficient;
    if (!toTop) {
        return;
    }
    document.addEventListener('scroll', () => (window.pageYOffset > clientHeight ? toTop.classList.add('show') : toTop.classList.remove('show')), false);
    document.addEventListener('click', ({target}) => {
        const toTop = target.closest(selector);
        toTop && window.scrollTo({top: 0, left: 0, behavior: "smooth"});
    }, false);
})();



//Reload page checkbox category
(function () {
    let form = document.querySelector('#sidebar-filter') || false;

    if(form) {
        form.addEventListener('input', e => {
            let checkbox = e.target.closest('[type="checkbox"]');
            checkbox && form.submit();
        }, false);

        let reset = form.querySelector('button[type="reset"]');
        let checkboxes = form.querySelectorAll('input[type="checkbox"]');



        reset.addEventListener('click', e => {
            e.preventDefault();

            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }

            const priceRangeSlider = $('#priceRangeSlider');
            const min = priceRangeSlider.slider('getAttribute', 'min');
            const max = priceRangeSlider.slider('getAttribute', 'max');
            priceRangeSlider.slider('setValue', [min, max]);

            const minPriceInp = form.querySelector('.inp-price-min');
                minPriceInp.value = min;
            const maxPriceInp = form.querySelector('.inp-price-max');
                maxPriceInp.value = max;
        }, false);
    }
}());
