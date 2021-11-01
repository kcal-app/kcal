// Load Lodash.
window._ = require('lodash');

// Load Axios.
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Load AlpineJS.
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
