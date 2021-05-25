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

    $('[data-toggle="tooltip"]').tooltip();
});



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
