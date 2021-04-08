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
}

//to handle state
const getters = {}

//to handle actions
const actions = {
    getPages({commit}) {
        return axios.get('/api/pages')
            .then(response => {
                commit('SET_PAGES', response.data['hydra:member'])

                //get slugs of al the pages
                if (currentUrl == '/') {
                    currentUrl = '/home';
                }
                var i;
                var pages = response.data['hydra:member'];
                var slugArr = [];
                //get currentPage
                var currentPage;

                for (i = 0; i < pages.length; i++) {
                    if ('/' + pages[i].slug == currentUrl) {
                        currentPage = pages[i];
                    }
                    slugArr.push('/' + pages[i].slug);
                }
                commit('SET_SLUG', slugArr)
                commit('SET_CURRENTPAGE', currentPage);
                return currentPage;
            })
    },
    loadSection({commit}, id) {
        console.log(id);
        return axios.get('/api/sections?' + id)
            .then(response => {
                commit('SET_SECTION', response.data['hydra:member']);
                return response.data['hydra:member'];
            })
    }
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
    }


}

//export store module
export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
})