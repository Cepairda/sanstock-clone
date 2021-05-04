(function (){
    "use strict";

    let infoBlockName = document.querySelectorAll('.info-block--name'),
        infoBlockValue = document.querySelectorAll('.info-block--value'),
        dropDownAction = element => {
            let dropdown = element.parentNode.getAttribute('data-dropdown');
            if (dropdown === 'true') {
                if (element.parentNode.classList.contains('show')) {
                    element.parentElement.classList.add('info-block--collapsing');
                    element.parentNode.classList.remove('show');
                    element.parentNode.style.height = null;
                    setTimeout(()=>{
                        element.parentElement.classList.remove('info-block--collapsing');
                        element.parentElement.style.minHeight = null;
                    }, 250);


                } else {
                    element.parentElement.style.minHeight = element.parentElement.offsetHeight + 'px';
                    element.parentElement.classList.add('show');
                    element.parentElement.classList.add('info-block--collapsing');
                    element.parentElement.style.height = element.parentElement.scrollHeight + 'px';
                    setTimeout(()=>{element.parentElement.classList.remove('info-block--collapsing')}, 250)
                }
            }
        };
    document.addEventListener('click', e => {
        const t = e.target,
            name = t.closest('.info-block--name'),
            value = t.closest('.info-block--value'),
            icon = t.closest('.info-block--icon'),
            abc = el => {
                !el.parentElement.classList.contains('show') && dropDownAction(value)
            };

        name && dropDownAction(name);
        value && abc(value);
        icon && dropDownAction(icon);

    });
}());


window.showHideCharacteristic = () => {
    const chevronDown = `<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="chevron-down"><polyline fill="none" stroke="#000" stroke-width="1.03" points="16 7 10 13 4 7"></polyline></svg>`;
    const infoBlock = document.querySelectorAll('.info-block');
    const infoBlockName = document.querySelectorAll('.info-block--name');
    const infoBlockValue = document.querySelectorAll('.info-block--value');

    const isOverflowed = ({scrollWidth, offsetWidth}) => (scrollWidth > offsetWidth);
    const dropDown = item => {
            let parent = item.parentNode,
                overflow = isOverflowed(item);
            if (overflow) {
                parent.setAttribute('data-dropdown', true);
                if (!parent.lastElementChild.classList.contains('info-block--icon')) {
                    let spanIcon = document.createElement('span');
                    spanIcon.className = 'info-block--icon';
                    spanIcon.insertAdjacentHTML('afterbegin', chevronDown);
                    parent.append(spanIcon);
                }
            } else {
                // parent.setAttribute('data-dropdown', false);
                // if (parent.lastElementChild.classList.contains('info-block--icon')) {
                //     parent.lastElementChild.remove();
                // }
            }
        };

    infoBlockName.forEach(dropDown);
    infoBlockValue.forEach(dropDown);
    window.addEventListener('resize', () => {
        if(infoBlockName) {
            infoBlockName.forEach(dropDown);
            infoBlockValue.forEach(dropDown);
        }
    }, false);
};

showHideCharacteristic();
