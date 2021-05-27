(function(){

    const container = document.querySelector('.tabs-products');

    if(!container) {
        return false;
    }

    container.addEventListener('click', ({target}) => {
        const btn = target.closest('.btn-item');
        if(btn) {
            const btns = container.querySelectorAll('.btn-item');
            const tabs = container.querySelectorAll('.container-item');
            const containerActive = container.querySelector(`${btn.dataset.toggle}`);
            btns.forEach(item => {
                item.classList.remove('active');
            });
            tabs.forEach(item => {
                item.classList.remove('active');
            });
            btn.classList.add('active');
            containerActive.classList.add('active');

        }
    }, false)


}());