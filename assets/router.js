import Vue from 'vue';
import Router from 'vue-router';
import Page from './view/Page.vue';
import Offer from './view/Offer.vue';
import CategoryDetail from './view/CategoryDetail.vue';
import Registration from './view/Registration.vue';
import Login from './view/Login.vue';
import MomentDetail from './view/MomentDetail.vue';
import User from './view/User.vue';

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
            name: "Offer",
            path: "/aanbod",
            component: Offer,
        },
        {
            name: "Login",
            path: "/login",
            component: Login,
        },
        {
            name: "Registration",
            path: "/registratie",
            component: Registration,
        },
        {
            name: "CategoryDetail",
            path: "/:category",
            component: CategoryDetail,
        },
        {
            name: "User",
            path: "/gebruiker",
            component: User,
        },
        {
            name: "UserDetail",
            path: "/gebruiker/gegevens",
            component: User,
        },
        {
            name: "UserRegistrations",
            path: "/gebruiker/inschrijvingen",
            component: User,
        },
        {
            name: "Page",
            path: "/:slug",
            component: Page,
        },
        {
            name: "MomentDetail",
            path: "/:category/:date",
            component: MomentDetail,
        },
    ],
})