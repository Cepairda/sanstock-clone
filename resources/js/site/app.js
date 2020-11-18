window._ = require('lodash');

// axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// popper
window.Popper = require('popper.js').default;
// jquery
window.$ = window.jQuery = require('jquery');

// template
require('./template/core.min.js');
require('./template/script');

// plugins
require('./plugins/rd-navbar');
window.owlCarousel = require('owl.carousel');

//custom script
require('./script')