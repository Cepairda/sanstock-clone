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

// template
require('./template/core.min.js');
require('./template/script');

// plugins
require('./plugins/rd-navbar');
//require('./plugins/jquery.filer');
window.owlCarousel = require('owl.carousel');

require('lazysizes');
// import a plugin
//require('lazysizes/plugins/parent-fit/ls.parent-fit')


//custom script
require('./script');
