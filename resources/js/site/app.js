//window._ = require('lodash');

// axios
//window.axios = require('axios');
//window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// popper
window.Popper = require('popper.js').default;
// jquery
window.$ = window.jQuery = require('jquery');

//bootstrap
require('bootstrap');


//require('lazysizes');
// import a plugin
//require('lazysizes/plugins/parent-fit/ls.parent-fit')

//plugin
require('./plugins/bootstrap-slider.min');
require('lightgallery.js');
require('lg-zoom.js');
require('lg-fullscreen.js');
require('lg-thumbnail.js');
require('./plugins/swipeGallery');
require('./plugins/characteristicsLists');

//components
require('./components/addToCart');

//custom script
require('./script');
