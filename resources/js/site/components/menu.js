(function(){
    const headerNav = document.querySelector('.header-nav');

    const navToggles = document.querySelectorAll('[data-action="nav-toggle"]');

    const closeNav = document.querySelector('#close-nav');
    const hM = document.querySelector('.head-menu--title');
    const bL = document.querySelector('.box-list__inner');

    navToggles.forEach(element => {

        element.addEventListener('click', function () {
            if(headerNav.classList.contains('show')) {
                headerNav.classList.remove('show');
            } else {
                headerNav.classList.add('show');
            }
            backdroup.action();
        });
    });



    // closeNav.addEventListener('click', function () {
    //     headerNav.classList.remove('show');
    //     backdroup.action();
    // });


    hM.addEventListener('click', function () {
        //document.querySelector('.head-menu').classList.add('active');
    });

    //===---
    document.addEventListener('click', ({target}) => {
        const t = target.closest('.modal-backdrop');
        if (t) {
            headerNav.classList.remove('show');
            backdroup.action();
        }
    }, false);
}());