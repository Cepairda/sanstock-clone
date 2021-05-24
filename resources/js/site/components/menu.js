(function(){
    const headerNav = document.querySelector('.header-nav');
    const openNav = document.querySelector('#open-nav');
    const closeNav = document.querySelector('#close-nav');
    const hM = document.querySelector('.head-menu--title');
    const bL = document.querySelector('.box-list__inner');

    openNav.addEventListener('click', function () {
        headerNav.classList.add('show');
        backdroup.action();
    });

    closeNav.addEventListener('click', function () {
        headerNav.classList.remove('show');
        backdroup.action();
    });

    hM.addEventListener('click', function () {
        document.querySelector('.head-menu').classList.add('active');
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