(function() {
    window.addEventListener('resize', function(event) {
        mobileMenu();
    });

    mobileMenu();
}());

function mobileMenu() {
    const navHeadMenuWrapper = document.querySelector('.nav-head-menu');
    const navHeadMenu = document.querySelector('.head-menu--title');

    if (window.innerWidth < 992) {
        navHeadMenu.addEventListener('click', () => {
            navHeadMenu.classList.add('active');
            //backdroup.action();
        })

        const menuItemLinks = document.querySelectorAll('.box-list__link a');
        menuItemLinks.forEach(element => {
            element.addEventListener('click', function (e) {
                const boxListInner = element.parentElement.parentElement;
                boxListInner.classList.toggle('active');
                const box = boxListInner.querySelector('.box');
                const boxList = box.querySelector('.box-list__link');

                if(boxList) {
                    e.preventDefault();
                }
            });
        });

        const closeHeadMenu = document.querySelector('.box-list__close');
        closeHeadMenu.addEventListener('click', () => {
            navHeadMenu.classList.remove('active');
        });
    } else {
        navHeadMenu.classList.remove('active');

        const boxListInnerActive = navHeadMenuWrapper.querySelectorAll('.box-list__inner');

        boxListInnerActive.forEach(e => e.classList.remove('active'));
    }
}