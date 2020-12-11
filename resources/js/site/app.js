window._ = require('lodash');

// axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// popper
window.Popper = require('popper.js').default;
// jquery
window.$ = window.jQuery = require('jquery');

//bootstrap
require('bootstrap');

// template
require('./template/core.min.js');
require('./template/script');

// plugins
require('./plugins/rd-navbar');
window.owlCarousel = require('owl.carousel');
require('lightgallery.js');
require('lg-zoom.js');
require('lg-thumbnail.js');

//custom script
require('./script');
