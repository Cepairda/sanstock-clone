$(document).ready(function () {
    $('.home__carousel').owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        nav: true,
        navElement: 'div',
        navText: ['<span class=" linear-icon-chevron-left"></span>', '<span class="linear-icon-chevron-right"></span>']
    });

});