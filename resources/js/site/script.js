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



//Reload page checkbox category
(function () {
    let form = document.querySelector('#sidebar-filter') || false;
    let reset = form.querySelector('button[type="reset"]');
    if(form) {
        form.addEventListener('input', e => {
            let checkbox = e.target.closest('[type="checkbox"]');
            checkbox && form.submit();
        }, false);

        let checkboxes = form.querySelectorAll('input[type="checkbox"]');

        reset.addEventListener('click', e => {
            for (let i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = false;
            }
        });
    }
}());
