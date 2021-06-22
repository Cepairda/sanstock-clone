(function() {
    if (window.innerWidth < 992) {
        const navHeadMenu = document.querySelector('.head-menu--title');

        navHeadMenu.addEventListener('click', () => {
            //if(navHeadMenu.classList.contains('active')) {
            //    navHeadMenu.classList.remove('active');
            //} else {
                navHeadMenu.classList.add('active');
            //}
            backdroup.action();
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
    }
}());
