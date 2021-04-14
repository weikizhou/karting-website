import Vue from 'vue';
import Router from 'vue-router';
// import App from './App.vue';
import Page from './view/Page.vue';
import Category from './view/component/Category.vue';

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            name: "PageHome",
            path: "/",
            component: Page,
        },
        {
            name: "Page",
            path: "/:slug",
            component: Page,
        },
    ],
})