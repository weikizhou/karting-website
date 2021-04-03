import Vue from 'vue';
import Router from 'vue-router';
// import App from './App.vue';
import Page from './view/Page.vue';
import Section from './view/component/Section.vue';

Vue.use(Router);

export default new Router({
    routes: [
        {
            name: "Page",
            path: "/",
            component: Page,
        },
    ],
})