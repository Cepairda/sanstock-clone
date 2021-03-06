//window._ = require('lodash');
//axios
//window.axios = require('axios');
//window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// popper
window.Popper = require('popper.js').default;
// jquery
window.$ = window.jQuery = require('jquery');

//bootstrap
require('bootstrap');

// Scrollbar
require('overlayscrollbars');

//require('lazysizes');
// import a plugin
//require('lazysizes/plugins/parent-fit/ls.parent-fit')

//plugin
require('./plugins/bootstrap-slider.min');
require('lightgallery.js');
require('lg-zoom.js');
require('lg-fullscreen.js');
require('lg-thumbnail.js');
require('owl.carousel');
require('./plugins/swipeGallery');
require('./plugins/characteristicsLists');
require('./plugins/lazyLoadImg');
require('./plugins/jquery.mask');

//components
require('./components/backdrop');
require('./components/liveSearch');
require('./components/cart');
require('./components/tabsProducs');
require('./components/updatePriceBalance');
require('./components/menu');
require('./components/category-menu');

//page
require('./page/cardProduct');
require('./page/category');

//custom script
require('./script');
