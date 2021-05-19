(function (){
    const liveSearchForm = document.querySelector('#life-search');
    const inputSearch = liveSearchForm.querySelector('.search-input');

    if(!inputSearch) {
        return;
    }

    const searchResult = liveSearchForm.querySelector('.search-result');

    const i18n = {
        input: {
            uk: 'Введіть мінімум 3 літери',
            ru: 'Введите минимум 3 знака',
            en: 'Enter at least 3 characters',
        },
        notFound: {
            uk: 'За запитом нічого не знайдено',
            ru: 'По запросу ничего не найдено',
            en: 'No results found for',
        }

    };

    function localization(){
        const markup = document.documentElement;
        const localizationDocument = markup.getAttribute('lang');
        const localization = lang  => {
            const handl = {
                'ru-UA' : 'ru',
                'uk-UA' : 'uk'
            };
            return handl[lang];
        };
        return localization(localizationDocument);
    }

    function debounce(func, time = 100) {
        let timer;
        return function () {
            clearTimeout(timer);
            timer = setTimeout(func, time);
        }
    }

    function insertMark (str, pos, len) {
        return str.slice(0, pos) + '<mark>' + str.slice(pos, pos + len) + '</mark>' + str.slice(pos + len);
    }

    function mark(value) {
        const textsArray = searchResult.querySelectorAll('.m-t');
        textsArray.forEach(text => {
            if (text.innerText.search(RegExp(value, "gi")) === -1) {
                text.innerHTML = text.innerText
            } else {
                let str = text.innerText;
                text.innerHTML = insertMark(str, text.innerText.search(RegExp(value, "gi")), value.length)
            }
        });
    }

    async function xhrLiveSearch (value) {
        const xhrUrl = `${location.origin}/live-search?query=${value}`,

            response = await fetch(xhrUrl, {});

        if (response.status === 200) {
            let data = await response.text();
            searchResult.textContent = '';
            searchResult.insertAdjacentHTML('afterbegin', data);
            window.lazyLoadImg.toRun();
            let val  = liveSearchForm.querySelector('.search_error');
            console.log(i18n.notFound[localization]);
            val && val.insertAdjacentHTML('beforeend', `<p class="search-text-info">${i18n.notFound[localization()]}:<span class="text-body ml-1">"${value}"</span></p>`);
            searchResult.style.height = (searchResult.firstElementChild.scrollHeight + +1) + 'px';
            mark(value);
        }
    }

    inputSearch.oninput = function () {
        let value = this.value.trim();
        const enter = () => {
            if (value.length >= 3) {
                xhrLiveSearch(value);
            } else if (value.length == 0) {
                searchResult.textContent = '';
                searchResult.style.height = 0;
            } else {
                searchResult.textContent = '';
                console.log(i18n.input[localization]);
                searchResult.insertAdjacentHTML("beforeend", `<p class="search-text-info">${i18n.input[localization()]}</p>`);
                searchResult.style.height = (searchResult.firstElementChild.scrollHeight + +1) + 'px';
            }
        };

        debounce(enter(), 500);
  //delay(function () {}, 500);
    };

    inputSearch.onfocus = function () {
        liveSearchForm.classList.add('active');
    };

    document.addEventListener('mousedown', ({target}) => {
        const form = target.closest('#life-search');
        if(!form) {
            liveSearchForm.classList.remove('active');
        }
    }, false);

}());


