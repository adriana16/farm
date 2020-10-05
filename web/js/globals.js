import 'bootstrap';
import 'bootstrap/dist/js/bootstrap.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-datepicker';
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css';
import 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min';
// import 'moment/min/moment.min.js';
// import 'eonasdan-bootstrap-datetimepicker';
// import 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';
// import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css';
import 'vue';
import 'axios';

global.$ = global.jQuery = $;
window.axios = require('axios');

$(function() {
    $('.datepicker').datepicker();
});

// export {
//     setCookie,
//     getCookie
// }