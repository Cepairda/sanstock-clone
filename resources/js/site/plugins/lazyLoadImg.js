/**
 * LazyLoadingImage (with lightgallery.js)
 *
 * 1. Класс по каторому запускаеться ленивая подгрузка: "img.lazy".
 * 2. Класс контеинера в котором хранить пути: ".img-data-path"
 *          - Путь к миниатюре храниться в атрибуте: "data-exthumbimage="
 *          - Путь к большой картинка храниться в атрибуте: "data-src="
 * 3. В процессе выполнения скрипта устанавливаеться классы:
 *          - ".lazyLoading" - загрузка;
 *          - ".lazyLoaded" - успешная загрузка;
 *          - ".lazyError" - завершено, но произошла ошибка;
 * 4. Сосотояние титульной картинки (Для галлереи):
 *          - успешно - ".title-image-add";
 *          - дефолтная ("../no_img.jpg" - static) или ошибка от сервера - ".title-image-not"
 * 5. Проверка ну существование => добавление прелодера-спиннера с задержкой 250мс.
 *
 * и т.д.
 * */

(function () {

    const options = {
            noImg: 'no_img.jpg',
            defaultImg: window.location.origin + '/img/no_img.jpg', //альтернатива: 'https://b2b-sandi.com.ua/imagecache/150x150/no_img.jpg'
            defaultLargeImg: 'http://b2b-sandi.com.ua/imagecache/large/no_img.jpg',
        };

    class LazyLoadingImages {

        constructor(properteis = {}) {

            this.props = {
                imageClassName: properteis.classImage || 'lazy',
                imageLoadingClassName: properteis.imageLoadingClassName || 'lazyLoading',
                imageLoadedClassName: properteis.imageLoadedClassName || 'lazyLoaded',
                imageErrorClassName: properteis.imageErrorClassName || 'lazyError',
                dataPathsClassName: properteis.dataPathsClassName || 'img-data-path',
                exthumbImageDataAttribute: properteis.exthumbImageDataAttribute || 'data-exthumbimage',
                largeImageDataAttribute: properteis.largeImageDataAttribute || 'data-src',
                galleryTitleImgAddClassName: properteis.galleryTitleImgAddClassName || 'title-image-add',
                galleryTitleImgEmptyClassName: properteis.galleryTitleImgEmptyClassName || 'title-image-not',
                imageAnimate: {keyframes: [{opacity: 0}, {opacity: 1}], options: {duration: 500}},
                delayPreloader: properteis.delayPreloader || 250,
                coefficientAreaVisibility: properteis.coefficientAreaVisibility || 1.5,
                logging: false,
            };

            this.toRun = this.toRun.bind(this);
            this.main = this.main.bind(this);
            this.setEvents = this.setEvents.bind(this);
            this.visibilityImage = this.visibilityImage.bind(this);
            this.handlerImage = this.handlerImage.bind(this);
            this.getSrc = this.getSrc.bind(this);
            this.searchImageLazy = this.searchImageLazy.bind(this);
            this.addLightGallery = this.addLightGallery.bind(this);
            this.logging = this.logging.bind(this);

            this.defaultEvent = false;

        }

        static removeSpinnerLazy(image) {
            let spinner = image.previousElementSibling;
            if (spinner) spinner.classList.contains('preloader-spinner') && image.previousElementSibling.remove();

        }

        static getSpinnerLazy(image) {
            const parent = image.parentElement;
            let   existsPreloader = false, i = 0;

            while( i < parent.childElementCount) {
                parent.children[i].classList.contains('preloader-spinner') && (existsPreloader = true);
                if(!existsPreloader) {
                    console.log(i);
                    image.insertAdjacentHTML('beforebegin', `<div class="preloader-spinner text-success" uk-spinner="ratio: 2"></div>`);
                    return;
                }
                i++;
            }

        }

        logging(message) {
            this.props.logging && console.log(`${message}`);
        }

        addLightGallery(productImgList){
            const el = productImgList;
            const productPercent = el.parentElement.parentElement.querySelector('.product-percent');
            if (el) {
                //на клик создаем динамическую галлерею
                el.addEventListener('click', ({ target }) => {
                    //src => large
                    //exthumbimage => 150x150
                    let imgList = el.querySelectorAll('.images-list'),
                        urlImages = [];
                    imgList.forEach(element => {
                        const obj = {
                            'src': element.dataset.src,
                            'thumb': element.dataset.exthumbimage,
                        };
                        element.dataset.subHtml && (obj['subHtml'] = element.dataset.subHtml);
                        return urlImages.push(obj);
                    });
                    lightGallery(el, {
                        thumbnail: true,
                        showThumbByDefault: false,
                        dynamic: true,
                        dynamicEl: urlImages,
                    });
                });

                el.classList.add('addImgList');

                el.addEventListener('onAfterOpen', function (event) {
                    let btnZoom = document.querySelector('#lg-zoom-in'),
                        customBtm = document.createElement('button');

                    //<button type="button" aria-label="Zoom in" id="lg-zoom-in" class="lg-icon"></button>
                    customBtm.className = 'lg-icon';
                    customBtm.id = 'lg-zoom-full';

                    !document.querySelector('#lg-zoom-full') && btnZoom.after(customBtm);

                    btnZoom.hidden = true;


                    if(productPercent) {
                        const per = productPercent.cloneNode(true);
                        document.querySelector('.lg-toolbar').append(per);
                    }

                }, false);

            }
        }

        searchImageLazy() {
            return this.imagesMassiv = [...document.querySelectorAll(`img.${this.props.imageClassName}`)];
        }

        getSrc (elem, imgSize = 'default') {
            const path = {
                'small': () => elem.getAttribute(this.props.exthumbImageDataAttribute),
                'large': () => elem.getAttribute(this.props.largeImageDataAttribute),
                'default': () => console.warn("not size image, lazyLoading.js"),
            };
            return path[imgSize]();
        }

        handlerImage(image) {

            let delay = setTimeout (()=> {
                this.constructor.getSpinnerLazy(image);
            }, this.props.delayPreloader);


            const elemDataPath = image.closest(`.${this.props.dataPathsClassName}`),

                  titleImg = (imgExthumb, imgSrc) => {
                    image.classList.remove(this.props.imageClassName);
                    image.classList.add(this.props.imageLoadingClassName);

                    let showGallery =  image.dataset.gallery === 'true' || false,
                        path = showGallery ? imgExthumb : imgSrc,
                        nameImage =  path && path.split('/'),
                        imagePath = new Image();


                    if (path) {
                        imagePath.src = path;

                        //для спиннера
                        clearTimeout(delay);
                        this.constructor.removeSpinnerLazy(image);

                    } else {
                        console.warn(`no validate path in dataAttribute`);
                        image.src = options.defaultImg;
                        image.classList.remove(this.props.imageLoadingClassName);
                        image.classList.add(this.props.imageLoadedClassName);

                    }

                    imagePath.onload = () => {

                        image.src = path;

                        image.animate(this.props.imageAnimate.keyframes, this.props.imageAnimate.options);

                        if (showGallery) {
                            const parentElem = image.closest('ul.product__img--list');

                            if (nameImage[nameImage.length - 1] === options.noImg) {
                                parentElem.classList.add(this.props.galleryTitleImgEmptyClassName);
                            } else {
                                parentElem.classList.add(this.props.galleryTitleImgAddClassName);
                                this.addLightGallery(parentElem);
                            }
                        }
                        image.classList.remove(this.props.imageLoadingClassName);
                        image.classList.add(this.props.imageLoadedClassName);
                    };

                    imagePath.onerror = () => {
                        console.warn(`@BeCrutch: lazyLoading.js - no image form server: "${path}"`);
                        image.src = options.defaultImg;
                        image.classList.remove(this.props.imageLoadingClassName);
                        image.classList.add(this.props.imageErrorClassName);
                    };

                };

            if (elemDataPath) {
                let imgSrc = this.getSrc(elemDataPath, 'large');
                let imgExthumb = this.getSrc(elemDataPath, 'small');
                titleImg(imgExthumb, imgSrc);

            } else {
                console.warn(`@BeCrutch: lazyLoading.js - not data path(.${this.props.dataPathsClassName})`);
                image.src = options.defaultImg;
                this.constructor.removeSpinnerLazy(image);
            }
        }

        visibilityImage(image) {

            let imageLazy = image.classList.contains(`${this.props.imageClassName}`),
                imgTop = image.getBoundingClientRect().top,
                windowHeight = window.innerHeight,
                downloadImg = image.dataset.download === 'true',
                areaVisibility = windowHeight/ this.props.coefficientAreaVisibility;

            if ((-areaVisibility < imgTop && (imgTop - areaVisibility) < windowHeight && imageLazy) || downloadImg) {
                this.handlerImage(image);
            }
        }

        setEvents(act = 'default') {

            const action = {
                'modal': () => {
                    this.logging('setEvents() => modal');

                    document.querySelector('.modal.show') && document.querySelector('.modal.show').addEventListener("scroll", this.main, false);
                },
                'default': () => {
                    if(!this.defaultEvent) {
                        this.logging('setEvents() => default');

                        document.addEventListener("scroll", this.main,false);
                        window.addEventListener("resize", this.main,false);
                        window.addEventListener("orientationChange", this.main,false);
                        this.defaultEvent = true;
                    }
                },
            };
            return action[act]();

        }

        destroyEvents(act = 'default') {

            const action = {
                'modal': () => {
                    this.logging('destroyEvents() => modal');

                    document.querySelector('.modal.show') && document.querySelector('.modal.show').removeEventListener("scroll", this.main,false);
                },
                'default': () => {
                    if(this.defaultEvent) {
                        this.logging('destroyEvents() => default');

                        document.removeEventListener("scroll", this.main,false);

                        window.removeEventListener("resize", this.main,false);

                        window.removeEventListener("orientationChange", this.main,false);

                        this.defaultEvent = false;
                    }
                },
            };
            return action[act]();
        }

        main() {
            this.logging('main()');

            this.searchImageLazy();

            if (this.imagesMassiv.length) {
                this.imagesMassiv.forEach(image => {
                    this.visibilityImage(image);
                })
            }


        }

        toRun() {
            this.logging('toRun()');

            this.main();
            this.setEvents();
        }
    }

    window.lazyLoadImg = new LazyLoadingImages();

    document.addEventListener("DOMContentLoaded", () => {
        lazyLoadImg.toRun();
    }, false);

    $('body').on('shown.bs.modal', function (e) {
        lazyLoadImg.main();
        lazyLoadImg.setEvents('modal');
    });
    $('body').on('hidden.bs.modal', function (e) {
        lazyLoadImg.destroyEvents('modal');
    });

}());
