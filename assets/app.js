/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)

// start the Stimulus application
// import './bootstrap';

import Vue from 'vue';
import App from './App.vue'
import router from './router';
import Notifications from 'vue-notification';
import axios from 'axios';

Vue.config.devtools = true;
Vue.use(Notifications);

new Vue({
    components: { App },
    template: "<App/>",
    router,
}).$mount("#app");