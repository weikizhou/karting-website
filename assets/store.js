import axios from 'axios'
import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);

var currentUrl = window.location.pathname;

const state = {
    pages: [],
    slug: [],
    currentPage: [],
    section: [],
    category: [],
    moments: [],
    currentMoment: [],
    currentCategory: [],
    currentUrl: '',
}

//to handle state
const getters = {
    getCurrentUrl(state) {
        return state.currentUrl;
    }
}

//to handle actions
const actions = {
    loadPages({commit}) {
        return axios.get('/api/pages')
            .then(response => {
                commit('SET_PAGES', response.data['hydra:member'])

                //get slugs of al the pages
                var i;
                var pages = response.data['hydra:member'];
                var slugArr = [];
                //get currentPage
                var currentPage;
                for (i = 0; i < pages.length; i++) {
                    if ('/' + pages[i].slug == window.location.pathname) {
                        currentPage = pages[i];
                    }
                    else if ('/' + pages[i].slug == '/home'){
                        currentPage = pages[i];
                    }
                    slugArr.push('/' + pages[i].slug);
                }

                commit('SET_SLUG', slugArr);
                commit('SET_CURRENTPAGE', currentPage);
                return currentPage;
            })
    },
    loadSection({commit}, res) {
        var i;
        var api;
        var sectionArr = [];
        if (res != 'user'){
            for (i = 0; i < res.section.length; i++) {
                api = res.section[i];
                axios.get(api)
                    .then(response => {
                        sectionArr.push(response.data)
                        commit('SET_SECTION', sectionArr);
                    })
            }
        }
    },
    loadCategory({commit}){
        axios.get('/api/categories')
            .then(response => {
                commit('SET_CATEGORY', response.data['hydra:member']);

                var i;
                var category = response.data['hydra:member'];
                var currentCategory;
                for (i = 0; i < category.length; i++) {
                    if ('/categorie/' + category[i].slug == window.location.pathname) {
                        currentCategory = category[i];
                        commit('SET_CURRENT_CATEGORY', currentCategory);
                    }
                }
            })
    },
    loadMoments({commit}){
        return axios.get('/api/dates')
            .then(response => {
                commit('SET_MOMENTS', response.data);

                var i;
                var moments = response.data;

                var currentMoment;
                var momentDate;
                var currentCategory;
                var momentDetailUrl;
                for (i = 0; i < moments.length; i++) {
                    momentDate = moments[i].date.slice(0, 10);
                    currentCategory = moments[i].Category.slug;
                    momentDetailUrl = '/gebruiker/'+currentCategory +'/'+ momentDate;
                    if (momentDetailUrl == window.location.pathname) {
                        if (moments[i].Category != null){
                            currentMoment = moments[i];
                            currentCategory = moments[i].Category;
                            commit('SET_CURRENT_MOMENT', currentMoment);
                            commit('SET_CURRENT_CATEGORY', currentCategory);
                        }
                    }
                }
                return currentMoment;
            });
    },
}

//to handle mutations
const mutations = {
    SET_PAGES(state, pages) {
        state.pages = pages
    },
    SET_SLUG(state, slug) {
        state.slug = slug
    },
    SET_CURRENTPAGE(state, currentPage) {
        state.currentPage = currentPage
    },
    SET_SECTION(state, section) {
        state.section = section
    },
    SET_CATEGORY(state, category) {
        state.category = category
    },
    SET_MOMENTS(state, moments) {
        state.moments = moments
    },
    SET_CURRENT_MOMENT(state, currentMoment){
        state.currentMoment = currentMoment
    },
    SET_CURRENT_CATEGORY(state, currentCategory){
        state.currentCategory = currentCategory
    },
}

//export store module
export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
})