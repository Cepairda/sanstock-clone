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

window.delay = (() => {
    let timer = 0;
    return (callback, ms) => {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();



//favorites
(function(){
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    window.favoriteSelected = () => {
        let favorites = getCookie('favorites'),
            favoritesMass = favorites === '' ? '' : favorites.split(','),
            leng = favoritesMass.length;
        favoriteLink.textContent = leng;
        if (leng) {
            favoritesMass.forEach(sku => {
                document.querySelector(`[data-add="favorite"][data-sku="${sku}"]`) && document.querySelector(`[data-add="favorite"][data-sku="${sku}"]`).classList.add('selected');
            });
        }
    }
    let favoriteLink = document.querySelector('.header-favorites-count'),
        favorites = document.querySelectorAll('[data-add="favorite"]'),
        addRemoveFavorite = favorite => {
            let date = new Date(),
                sku = favorite.dataset.sku,
                cookies = getCookie('favorites');
            date.setDate(date.getDate() + 365);

            if(!cookies){
                document.cookie = 'favorites' + "=" + sku + "; path=/; expires=" + date.toUTCString();
                favorite.classList.add('selected');
                document.querySelector('.header-favorites-count').textContent = 1;
            } else {
                let favorites = getCookie('favorites'),
                    favoritesMass = favorites.split(','),
                    indexSku = favoritesMass.indexOf(sku);

                if(indexSku < 0) {
                    favoritesMass.push(sku);
                    favorite.classList.add('selected');
                } else {
                    favoritesMass.splice(indexSku, 1);
                    favorite.classList.remove('selected');
                }
                document.querySelector('.header-favorites-count').textContent = favoritesMass.length;
                document.cookie = 'favorites' + "=" + favoritesMass.join(',') + "; path=/; expires=" + date.toUTCString();
            }
        };
        document.addEventListener('click', function(e) {
            let t = e.target,
                favorite =  t.closest('[data-add="favorite"]');
            favorite && addRemoveFavorite(favorite);
        }, false);
    window.addEventListener('load', favoriteSelected(), false);
}());

//liveSearch
(function (){
    const inputSearch = document.querySelector('#rd-navbar-search-form-input'),
          searchResult = document.querySelector('.rd-search-results-live');
    async function xhrLiveSearch (value) {
        const xhrUrl = `${location.origin}/search/?query=${value}`,
            response = await fetch(xhrUrl, {});
        if (response.status === 200) {
            let data = await response.text();
            searchResult.textContent = '';
            searchResult.insertAdjacentHTML('afterbegin', data);
            favoriteSelected();

            let val  = document.querySelector('.search_error .search');
            val ? val.textContent = value : undefined;
        }
    }

    inputSearch.oninput = function () {
        let value = this.value.trim();

        delay(function () {
            if (value.length >= 3) {
                xhrLiveSearch(value)
            }
        }, 500);

        //if(value.trim()){}
    }
}());
