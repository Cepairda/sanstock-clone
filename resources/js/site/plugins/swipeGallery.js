/**
 * slider v.3
 *
 * */
(function () {

    "use strict";

    const
        galleryContainerClassName = 'gallery-container',
        galleryImgContainerClassName = 'gallery-images-container',
        titleGalleryImagesClassName = 'gallery-images',
        galleryImageItemClassName = 'gallery-item',
        gallerySideWaysClassName = 'gallery-sideways',
        galleryClassName = 'gallery',
        galleryViewClassName = 'gallery-view',
        galleryLineClassName = 'gallery-line',
        gallerySlideClassName = 'gallery-slide',
        galleryBtnPrevClassName = 'gallery-btn-prev',
        galleryBtnNextClassName = 'gallery-btn-next',
        galleryBtnDisabledClassName = 'gallery-btn-disabled',
        galleryDraggableClassName = 'gallery-draggable',
        galleryPointerClassName = 'gallery-pointer',

        srcNoImg = window.location.origin + '/images/no_img.jpg';

    window.Gallery1 = class Gallery {

        constructor(element, options = {}) {
            this.containerNode = element;
            this.containerGallery = this.containerNode.parentElement; //gallery-container
            this.titleImagesContainer = this.containerGallery.querySelector(`.${galleryImgContainerClassName}`);
            this.titleGalleryImages = this.containerGallery.querySelector(`.${titleGalleryImagesClassName}`);
            this.size = element.childElementCount;
            this.currentSlide = 0; // активный слай
            this.settings = {
                margin: options.margin || 0,
                sizeThumbnail: options.sizeThumbnail || this.containerNode.getBoundingClientRect().width,
                widthButtonNav: 20, //надо переименовать
                axis: options.axis || 'x',
                centerTitleImage: options.centerTitleImage || false, //иконки слева, главная картинка по центру(для sideways)
                lightGallery: options.lightGallery || false, //добавление lightGallery
                titleWidth: options.titleWidth || false, //ширина главаной картинки
            };
            this.directions = {
                x: {
                    page: 'pageX',
                    axis: 'width',
                    transform: c => `translate3d(${c}px, 0, 0)`,
                    marginThumbnail: `0 ${this.settings.margin / 2}px`,
                },
                y: {
                    page: 'pageY',
                    axis: 'height',
                    transform: c => `translate3d(0, ${c}px, 0)`,
                    marginThumbnail: `${this.settings.margin / 2}px 0`,
                }
            };

            this.startDragPoint = false;
            this.slideDragging = false;
            this.slideSwipe = false;
            this.tests = false;


            this.preloader = this.preloader.bind(this);
            this.removePreloader = this.removePreloader.bind(this);
            this.managerHTML = this.managerHTML.bind(this);
            this.centerTitleImage = this.centerTitleImage.bind(this);
            this.createTitle = this.createTitle.bind(this);
            this.createLightGallery = this.createLightGallery.bind(this);
            this.setParameters = this.setParameters.bind(this);
            this.setEvents = this.setEvents.bind(this);
            this.resizeGallery = this.resizeGallery.bind(this);
            this.startDrag = this.startDrag.bind(this);
            this.stopDrag = this.stopDrag.bind(this);
            this.dragging = this.dragging.bind(this);
            this.changeSlides = this.changeSlides.bind(this);
            this.getSelectTitleImg = this.getSelectTitleImg.bind(this);
            this.selectSlide = this.selectSlide.bind(this);
            this.addButtons = this.addButtons.bind(this);
            this.deleteButtons = this.deleteButtons.bind(this);
            this.changeDisabledBtn = this.changeDisabledBtn.bind(this);
            this.setStylePosition = this.setStylePosition.bind(this);
            this.setStyleTransition = this.setStyleTransition.bind(this);

            this.preloader();
            this.managerHTML();
            this.createTitle();
            this.setParameters();
            this.setEvents();

            if (this.tests) {
                this.forTest();
            }

        }

        preloader() {

            this.test = setTimeout(() => {

                this.containerGallery.insertAdjacentHTML('beforeend', `<div class="preloader-spinner" style="opacity: 1" uk-spinner="ratio: 2"></div>`);

            }, 250);

        }

        removePreloader() {

            clearTimeout(this.test);


            const preloader = this.containerGallery.lastElementChild;

            preloader.classList.contains('preloader-spinner') && preloader.remove();

            this.containerGallery.removeAttribute('data-lazy');
        }

        //создаем оболочку
        managerHTML() {

            this.containerNode.classList.add(galleryClassName);  //задем класс главному контаниеру

            this.size < 2 && (this.containerNode.hidden = true);

            this.containerNode.innerHTML = `<div class="${galleryViewClassName}"><div class="${galleryLineClassName}">${this.containerNode.innerHTML}</div></div>`;

            this.viewNode = this.containerNode.querySelector(`.${galleryViewClassName}`);

            this.lineNode = this.containerNode.querySelector(`.${galleryLineClassName}`);

            this.slideNodes = [...this.lineNode.children].map((childNode, index) =>
                wrapElementByDiv({
                    index: index,
                    element: childNode,
                    className: gallerySlideClassName
                })
            );
        }

        //Дополнительная обвертка для центровки (sideways)
        centerTitleImage() {
            const wrapperNode = document.createElement('div');
            wrapperNode.style.display = 'flex';
            wrapperNode.style.justifyContent = 'center';
            wrapperNode.style.flexGrow = '1';
            wrapperNode.appendChild(this.containerGallery.querySelector(`.${galleryImgContainerClassName}`));
            this.containerGallery.prepend(wrapperNode);
        }

        //оформление галлереи больших изображений
        createTitle() {

            const addImg = index => {
                let div = document.createElement('div'),
                    img = document.createElement('img');

                const cursorPointerImage = this.settings.lightGallery ? `${galleryImageItemClassName} ${galleryPointerClassName}` : `${galleryImageItemClassName}`;

                div.className = cursorPointerImage;
                div.setAttribute('data-downloaded', 'false');
                div.setAttribute('data-index', index);

                if (index === 0) {
                    this.lineNode.querySelector(`[data-index="${index}"]`).classList.add('active');
                    img.src = this.lineNode.querySelector(`[data-index="${index}"]`).dataset.src;
                } else {
                    img.src = this.lineNode.querySelector(`[data-index="${index}"] img`).src;//window.location.origin + '/img/b2b/white_fone_150x150.jpg';
                }

                div.append(img);

                return div;
            };
            for (let i = 0; this.size > i; i++) {
                this.titleGalleryImages.append(addImg(i));
            }

            if (this.settings.centerTitleImage) {
                this.centerTitleImage();
            }
        }

        createLightGallery() {
            let lgl = this.lineNode;
            lightGallery(lgl, {
                share: false,
                actualSize: false,
                download: true,
                zoom: true,
                fullScreen: true,
                thumbnail: true,
                showThumbByDefault: true,
                //subHtmlSelectorRelative: true,
            });
            lgl.addEventListener('onAfterOpen', function () {
                const zoom = false;
                if (zoom) {
                    let btnZoom = document.querySelector('#lg-zoom-in'),
                        customBtm = document.createElement('button');
                    customBtm.className = 'lg-icon';
                    customBtm.id = 'lg-zoom-full';
                    !document.querySelector('#lg-zoom-full') && btnZoom.after(customBtm);
                    btnZoom.hidden = true;
                }
            }, false);


            lgl.addEventListener('onCloseAfter', function (event) {
                if (window.lgData[lgl.getAttribute('lg-uid')]) {
                    window.lgData[lgl.getAttribute('lg-uid')].destroy(true);
                }

            }, false);
            this.lineNode.querySelector('.gallery-slide.active').click();
        }

        addButtons() {

            const classNameChevron = {
                'x': {
                    'positive': 'chevron-left',
                    'negative': 'chevron-right'
                },
                'y': {
                    'positive': 'chevron-up',
                    'negative': 'chevron-down'
                }
            };

            let setStyleParam = this.settings.axis === 'x' ? `width: ${this.settings.widthButtonNav}px;` : `height: ${this.settings.widthButtonNav}px;`;


            if (!(this.btnPrev && this.btnNext)) {
                this.viewNode.insertAdjacentHTML('beforebegin', `<button class="${galleryBtnPrevClassName}" style="${setStyleParam}"><i class="${classNameChevron[this.settings.axis].positive}"></i></button>`);
                this.viewNode.insertAdjacentHTML('afterend', `<button class="${galleryBtnNextClassName}" style="${setStyleParam}"><i class="${classNameChevron[this.settings.axis].negative}"></i></button>`);

                this.btnPrev = this.containerNode.querySelector(`.${galleryBtnPrevClassName}`);
                this.btnNext = this.containerNode.querySelector(`.${galleryBtnNextClassName}`);


                this.changeDisabledBtn();
            }
        }

        deleteButtons() {
            if (this.btnPrev && this.btnNext) {
                this.btnPrev.remove();
                this.btnNext.remove();
            }
        }

        //задаем всех параметров
        setParameters() {

            const containerNode = this.containerNode.getBoundingClientRect();

            this.sizeContainerView = containerNode[this.directions[this.settings.axis].axis] > 450 ? containerNode[this.directions[this.settings.axis].axis] : 450;
            this.forTest({
                'sizeContainerView': this.sizeContainerView,
            });

            this.sizeThumbnail  = this.settings.sizeThumbnail + this.settings.margin; //получаем размер иконки

            //Функция для выбора направления (по вертикали | по горизонтали)
            const direction = (direct) => {

                const action = {
                    'x': () => {},
                    'y': () => {
                        this.containerGallery.classList.add(gallerySideWaysClassName); //добавление класса к контеинеру галлери (для отображения ее с боку)
                    }
                };

                return action[direct]();
            };

            direction(this.settings.axis);

            this.coordinate = -this.currentSlide * this.sizeThumbnail; //выставляем смещение от активного слайда

            this.resetStyleTransition(); //обнуляем transition

            const sizeLineNode = this.size * this.sizeThumbnail; //ширина/высота блока с картинками

            this.lineNode.style[this.directions[this.settings.axis].axis] = `${sizeLineNode}px`; //задаем ширину/высоту .gallery-line

            this.viewCountSlide = Math.floor((this.sizeContainerView - this.settings.widthButtonNav * 2) / this.sizeThumbnail);

            const sizeViewNode = this.sizeThumbnail * this.viewCountSlide; //видимая ширина

            this.viewNode.style[this.directions[this.settings.axis].axis] = `${sizeViewNode}px`;

            this.maximum = -(this.size - this.viewCountSlide) * this.sizeThumbnail; // максимальна ширина движущигося блока

            this.slideSwipe = sizeViewNode < sizeLineNode;

            if (this.slideSwipe) {

                this.addButtons();

                this.widthHeightViewNode = sizeViewNode + this.settings.widthButtonNav * 2;

            } else {

                this.deleteButtons();

                this.widthHeightViewNode = 450;
            }

            this.setStylePosition();

            [...this.slideNodes].forEach((slideNode) => {
                slideNode.style.height = `${this.settings.sizeThumbnail}px`;
                slideNode.style.width = `${this.settings.sizeThumbnail}px`;
                slideNode.style.margin = `${this.directions[this.settings.axis].marginThumbnail}`;
            });


            {

                let width = this.settings.titleWidth ? this.settings.titleWidth : this.widthHeightViewNode; //this.containerGallery.offsetWidth

                width > 450 ? width = 450 : width;

                this.settings.centerTitleImage && (() => {

                    width = this.containerGallery.offsetWidth - 72 - 16 > width ? width : this.containerGallery.offsetWidth - 72 - 16;

                })();

                this.titleImagesContainer.style.width = width + 'px';
                this.titleImagesContainer.style.height = width + 'px';


                let gi = this.titleGalleryImages.querySelectorAll(`.${galleryImageItemClassName}`);
                if (gi) {
                    const h = this.titleImagesContainer.offsetWidth;
                    gi.forEach(el => {
                        el.style.minWidth = h + 'px';
                    });
                    this.titleGalleryImages.style.width = `${h * this.size}px`;
                    this.selectSlide(this.currentSlide);
                }


            }

        }

        //работа с событиями
        setEvents() {

            this.debouncedResizeGallery = debounce(this.resizeGallery);

            window.addEventListener('resize', this.debouncedResizeGallery, false);

            if (this.slideSwipe) {
                this.lineNode.addEventListener('pointerdown', this.startDrag, false);
                if (this.btnPrev && this.btnNext) {
                    this.btnNext.addEventListener('click', () => {
                        if (this.currentSlide < this.size - this.viewCountSlide) {
                            this.currentSlide = this.currentSlide + 1;
                            this.setStyleTransition();
                            this.coordinate = -this.currentSlide * this.sizeThumbnail;
                            this.setStylePosition();
                            this.changeDisabledBtn();
                        }
                    }, false);
                    this.btnPrev.addEventListener('click', () => {
                        if (this.currentSlide > 0) {
                            this.currentSlide = Number(this.currentSlide) - 1;
                            this.setStyleTransition();
                            this.coordinate = -this.currentSlide * this.sizeThumbnail;
                            this.setStylePosition();
                            this.changeDisabledBtn();
                        }
                    }, false);
                }
                window.addEventListener('pointerup', this.stopDrag, false);
                window.addEventListener('pointercancel', this.stopDrag, false);
            }

            this.lineNode.addEventListener('click', this.getSelectTitleImg, false);
            this.settings.lightGallery && this.titleGalleryImages.addEventListener('click', this.createLightGallery, false);

            //this.titleGalleryImages.addEventListener('pointerdown', this.startDrag, false)
        }

        destroyEvents() {
            window.removeEventListener('resize', this.debouncedResizeGallery, false);
            this.lineNode.removeEventListener('pointerdown', this.startDrag, false);
            window.removeEventListener('pointerup', this.stopDrag, false);
            window.removeEventListener('pointercancel', this.stopDrag, false);

            this.lineNode.removeEventListener('mouseup', this.getSelectTitleImg, false);

            this.lineNode.removeEventListener('click', this.getSelectTitleImg, false);

            this.titleGalleryImages.removeEventListener('click', this.createLightGallery, false)
        }

        //ресайз галлереи
        resizeGallery() {
            this.setParameters();
        }

        startDrag(evt) {

            this.startDragPoint = true;

            this.click = evt[this.directions[this.settings.axis].page];
            this.start = this.coordinate;


            this.forTest({
                'startDragPoint': this.startDragPoint,
                'click': this.click,
                'start': this.coordinate,
            });

            this.resetStyleTransition();

            window.addEventListener('pointermove', this.dragging, false);
        }

        dragging(evt) {
            this.slideDragging = true;
            this.drag = evt[this.directions[this.settings.axis].page];
            this.dragShift = this.drag - this.click;
            const easing = this.dragShift / 5;
            this.coordinate = Math.max(Math.min(this.start + this.dragShift, easing), this.maximum + easing);

            this.forTest({
                'slideDragging': this.slideDragging,
                'drag': this.drag,
                'dragShift': this.dragShift,
                'coordinate': this.coordinate,
            });

            document.body.classList.add(galleryDraggableClassName);
            this.setStylePosition();
        }

        stopDrag() {
            if (this.startDragPoint) {
                window.removeEventListener('pointermove', this.dragging, false);
                this.changeSlides();
                this.coordinate = -this.currentSlide * this.sizeThumbnail;
                this.setStylePosition();
                this.setStyleTransition();
                document.body.classList.remove(galleryDraggableClassName);
                this.changeDisabledBtn();

            }
        }


        changeSlides() {
            if (!this.slideDragging) {
                return;
            }

            const step = Math.abs(Math.round(this.dragShift / this.sizeThumbnail));

            //влево
            //вверх
            if (
                this.dragShift > 20 &&
                this.dragShift > 0 &&
                this.currentSlide > 0) {
                this.currentSlide = (this.currentSlide - step) >= 0 ? this.currentSlide - step : 0;
            }
            //вправо
            //вниз
            if (
                this.dragShift < -20 &&
                this.dragShift < 0 &&
                this.currentSlide < this.size - this.viewCountSlide) {
                this.currentSlide = (this.currentSlide + step) >= this.size - this.viewCountSlide ? this.size - this.viewCountSlide : this.currentSlide + step;
            }

            this.startDragPoint = false;
            this.slideDragging = false;

            this.forTest({
                'step': step,
                'currentSlide': this.currentSlide,
                'startDragPoint': this.startDragPoint,
                'slideDragging': this.slideDragging,
            });

        }

        getSelectTitleImg({target}) {
            const slide = target.closest('.gallery-slide');
            if (!slide) {
                return;
            }
            const index = slide.dataset.index;
            this.selectSlide(index);
        }

        selectSlide(index) {
            this.startDragPoint = false;
            this.forTest({
                'startDragPoint': this.startDragPoint,
            });
            const slide = this.lineNode.querySelector(`[data-index="${index}"]`);
            const titleImg = this.titleGalleryImages.querySelector(`[data-index="${index}"]`);
            const titleImgItem = titleImg.lastElementChild;

            if (titleImg.dataset.downloaded === 'false') {
                let addSpinner = setTimeout(() => {
                        titleImg.insertAdjacentHTML('afterbegin', `<div class="preloader-spinner text-success" uk-spinner="ratio: 2"></div>`)
                    }, 250),
                    removePreloaderSpinner = () => {
                        clearTimeout(addSpinner);
                        let spinner = titleImgItem.previousElementSibling;
                        if (spinner) titleImgItem.previousElementSibling.classList.contains('preloader-spinner') && titleImgItem.previousElementSibling.remove();
                        titleImg.dataset.downloaded = 'true';
                        this.removePreloader();
                    };

                titleImgItem.src = slide.dataset.src;

                titleImgItem.onload = function () {
                    removePreloaderSpinner();

                };

                titleImgItem.onerror = function () {
                    removePreloaderSpinner();
                    titleImgItem.src = srcNoImg;

                };
            }


            this.titleGalleryImages.style.setProperty('transition-duration', `400ms`);
            this.titleGalleryImages.style.setProperty('transform', `translate3d(-${titleImgItem.parentElement.offsetLeft}px, 0, 0)`);
            setTimeout(() => this.titleGalleryImages.style.setProperty('transition-duration', null), 450);

            this.lineNode.querySelectorAll('.gallery-slide').forEach((item) => item.classList.remove('active'));
            slide.classList.add('active');

        }

        changeDisabledBtn() {
            if (this.btnPrev && this.btnNext) {
                if (this.currentSlide <= 0) {
                    this.btnPrev.classList.add(galleryBtnDisabledClassName);
                } else {
                    this.btnPrev.classList.remove(galleryBtnDisabledClassName);
                }

                if (this.currentSlide >= this.size - this.viewCountSlide) {
                    this.btnNext.classList.add(galleryBtnDisabledClassName);
                } else {
                    this.btnNext.classList.remove(galleryBtnDisabledClassName);
                }
            }
        }

        setStylePosition() {
            this.lineNode.style.transform = this.directions[this.settings.axis].transform(this.coordinate);
        }

        setStyleTransition() {
            this.lineNode.style.transition = `all 0.25s ease 0s`
        }

        resetStyleTransition() {
            this.lineNode.style.transition = `all 0s ease 0s`
        }

        forTest(obj = undefined) {

            if (this.tests) {

                const tG = document.getElementById('testG');

                if (!tG) {
                    const container = document.createElement('div'),
                        setStyleProps = {
                            position: 'absolute',
                            top: '0',
                            right: '0',
                            minWidth: '500px',
                            minHeight: '300px',
                            padding: '5px',
                            border: '1px solid #ccc',
                            background: '#fff',
                            zIndex: 100000
                        };

                    container.id = 'testG';

                    for (let key in setStyleProps) {
                        container.style[key] = setStyleProps[key];
                    }
                    document.body.append(container);
                } else {
                    if (obj) {
                        for (let key in obj) {

                            const lLine = tG.querySelector(`.${key}`);

                            if (lLine) {

                                lLine.querySelector('.props').innerHTML = obj[key];

                            } else {

                                const line = document.createElement('div');

                                const name = document.createElement('span');

                                const props = document.createElement('span');

                                line.className = `${key}`;
                                name.className = 'name';
                                props.className = 'props';

                                name.innerHTML = key;

                                props.innerHTML = obj[key];

                                props.style.marginLeft = '10px';

                                line.appendChild(name);
                                line.appendChild(props);
                                tG.appendChild(line);
                            }
                        }
                    }
                }
            }
        }
    };

    function wrapElementByDiv({index, element, className}) {

        const wrapperNode = document.createElement('div'); //создаем контейнер обвертка div

        wrapperNode.classList.add(className, 'img-data-path'); //добавлем класс контейнеру

        wrapperNode.setAttribute('data-src', element.dataset.src);
        element.removeAttribute('data-src');
        wrapperNode.setAttribute('data-thumbnail', element.dataset.thumbnail);
        element.removeAttribute('data-thumbnail');
        wrapperNode.setAttribute('data-full', element.dataset.full);
        element.removeAttribute('data-full');
        //wrapperNode.setAttribute('data-sub-html', element.dataset.subHtml);
        //element.removeAttribute('data-sub-html');

        wrapperNode.setAttribute(`data-index`, index);

        element.parentNode.insertBefore(wrapperNode, element); //обращаясь к радилею елемента, добавляем новый контейнер перед елементом

        wrapperNode.appendChild(element); //вкладываем елемент в контеинер (Если данный дочерний элемент является ссылкой на существующий узел в документе, то функция appendChild() перемещает его из текущей позиции в новую позицию)

        return wrapperNode; //возращаем контейнер обвертка с вложенным елементом
    }

    function debounce(func, time = 100) {
        let timer;
        return function () {
            clearTimeout(timer);
            timer = setTimeout(func, time);
        }
    }

    if (document.querySelector('#gallery')) {
        new Gallery1(document.getElementById('gallery'), {
            lightGallery: true,
            axis: 'y',
            margin: 8,
            sizeThumbnail: 72,
        });
    }
})();
