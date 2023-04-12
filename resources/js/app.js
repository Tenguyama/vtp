import './bootstrap';
import { createApp } from 'vue'

window.axios = axios0;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Vue = createApp;

import axios0 from "axios";

const app = Vue({},{
    el: '#app',
    created() {
        let url = window.location.pathname
        let slug = url.substring(url.lastIndexOf('/') + 1)
    }
});
