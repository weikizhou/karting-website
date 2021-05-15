import Vue from 'vue';
import Router from 'vue-router';
import Page from './view/Page.vue';
import Offer from './view/Offer.vue';
import CategoryDetail from './view/CategoryDetail.vue';
import Registration from './view/Registration.vue';
import Login from './view/Login.vue';
import MomentDetail from './view/MomentDetail.vue';
import User from './view/User.vue';
import UserDetail from './view/UserDetail.vue';
import UserRegistrations from './view/UserRegistrations.vue';
import ResetPassword from './view/ResetPassword.vue';

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
            path: "/categorie/:category",
            component: CategoryDetail,
        },
        {
            name: "UserDetail",
            path: "/gebruiker/gegevens",
            component: UserDetail,
        },
        {
            name: "ResetPassword",
            path: "/gebruiker/wijzig/wachtwoord",
            component: ResetPassword,
        },
        {
            name: "UserRegistrations",
            path: "/gebruiker/inschrijvingen",
            component: UserRegistrations,
        },
        {
            name: "User",
            path: "/gebruiker",
            component: User,
        },
        {
            name: "Page",
            path: "/:slug",
            component: Page,
        },
        {
            name: "MomentDetail",
            path: "/gebruiker/:category/:date",
            component: MomentDetail,
        },
    ],
})