window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

window.jQuery = require('jquery')

import 'bootstrap'
import 'jquery.scrollto'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const spinner = `<div class="d-flex justify-content-center align-items-center h-100">
<div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
<span class="visually-hidden">Loading...</span>
</div>
</div>
`;

const miniSpinner = `<div class="d-flex justify-content-center align-items-center">
<div class="spinner-border" role="status" style="width: 1rem; height: 1rem;">
<span class="visually-hidden">Loading...</span>
</div>
</div>
`;

const fullSpinner = `<div class="position-fixed top-0 bottom-0 start-0 end-0 bg-white bg-opacity-25">
    ${spinner}
</div>`

window.spinner = spinner;
window.miniSpinner = miniSpinner;
window.fullSpinner = fullSpinner;
