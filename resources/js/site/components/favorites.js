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
            favoritesMass = (favorites === undefined || favorites === "") ? '' : favorites.split(','),
            leng = favoritesMass.length;
        favoriteLink.textContent = leng;
        if (leng) {
            favoritesMass.forEach(sku => {
                document.querySelector(`[data-add="favorite"][data-sku="${sku}"]`) && document.querySelector(`[data-add="favorite"][data-sku="${sku}"]`).classList.add('selected');
            });
        }
    };
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
                    if(document.body.classList.contains('favorites')) {
                        let card = favorite.closest('.product.product-grid');
                        card.parentElement.classList.add('hideBock')
                        setTimeout(() => card.parentElement.remove(), 355);

                        !favoritesMass.length && location.reload();
                    } else {
                        favorite.classList.remove('selected');
                    }
                }

                document.querySelector('.header-favorites-count').textContent = favoritesMass.length;
                document.cookie = 'favorites' + "=" + favoritesMass.join(',') + "; path=/; expires=" + date.toUTCString();
            }
        };
    document.addEventListener('click', function(e) {
        //console.log('we here');
        let t = e.target,
            favorite =  t.closest('[data-add="favorite"]');
        favorite && addRemoveFavorite(favorite);
    }, false);
    window.addEventListener('load', favoriteSelected(), false);
}());