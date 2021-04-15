<template>
    <div>
        <div class="container py-3">
            <div class="row">
                <div class="col-md-12 col-lg-10 m-auto">
                    <nav class="navbar navbar-expand-lg navbar-light flex items-center justify-between">
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent"
                                aria-controls="navbarSupportedContent" aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="flex items-center">
                            <a class="text-decoration-none text-dark" href="/">
                                <h2 class="mx-4 my-0">Kartcentrum Max</h2>
                            </a>
                            <ul class="navbar-nav">
                                <router-link :to="{name: 'Page', params: {slug: slug}}"></router-link>
                                <li class="nav-item" v-for="(page, index) in pages">
                                    <router-link class="nav-link" v-if="page.inNavigation == 1"
                                                 :to="{name: 'Page', params: {slug: page.slug}}">
                                        {{ page.navTitle }}
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                        <div class="flex items-center">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="/login/kartcentrum"><i class="fas fa-lock"></i>
                                        Inloggen</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
      <div v-if="currentPage.slug != 'aanbod' && currentPage.slug != 'login' ">
        <div class="container-fluid header-container">
          <div class="row">
            <img class="introduction-image shadow p-0" v-if="currentPage.introductionImage != undefined "
                 :src="'assets/uploads/page/'+ currentPage.introductionImage" alt="introduction image">
            <div class="introduction-content shadow">
              <h2>{{ currentPage.introductionTitle }}</h2>
              <p v-html="currentPage.introduction">{{ currentPage.introduction }}</p>
            </div>
          </div>
        </div>

        <Section :parentData="section"></Section>
      </div>
      <div v-else>
        <div v-if="currentPage.slug == 'aanbod'">
          <Category :parentData="category"></Category>
          <Moment :parentData="moments"></Moment>
        </div>
        <div v-else>
          <Login></Login>
        </div>
      </div>

        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-sm-12 col-md-9">
                                <h2>Over Kartcentrum Max</h2>
                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has been the
                                    industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                    galley of type
                                    and scrambled it to make a type specimen book. It has survived not only five
                                    centuries, but also the
                                    leap into electronic typesetting, remaining essentially unchanged.
                                </p>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <h2>Pagina's</h2>
                                <ul class="footer-links">
                                    <li v-for="(page, index) in pages">
                                        <a :href="'/' + page.slug" v-if="page.inNavigation == 1">{{ page.navTitle }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <p class="copyright-text">Copyright &copy; All Rights Reserved by
                                    <a href="/">Kartcentrum Max</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import Section from './component/Section';
import Category from './component/Category';
import store from '../store';
import {mapMutations, mapActions, mapGetters} from 'vuex';
import Moment from "./component/Moment";
import Login from "./component/Login";

// var currentUrl = window.location.pathname;

// console.log(currentUrl)
export default {
    name: "Page",
    store: store,
    components: {
        Section,
        Category,
        Moment,
        Login,
    },
    computed: {
        // ...mapGetters({
        //   currentUrl: 'getCurrentUrl'
        // }),
        pages() {
            return this.$store.state.pages
        },
        slug() {
            return this.$store.state.slug
        },
        currentPage() {
            return this.$store.state.currentPage
        },
        section() {
            return this.$store.state.section
        },
        category() {
          return this.$store.state.category
        },
        moments() {
          return this.$store.state.moments
        },
    },
    methods: {
      ...mapActions({
        loadPages: 'loadPages',
        loadSection: 'loadSection',
        loadCategory: 'loadCategory',
        loadMoments: 'loadMoments',
      }),
      ...mapMutations({
        setCurrentPage: 'SET_CURRENTPAGE',
        setSection: 'SET_SECTION',
      })
    },
    mounted() {
        this.loadPages().then(res => {
          this.loadSection(res)
        });
        this.loadCategory();
        this.loadMoments();
    },
    watch: {
        '$route'(newVal) {
            let slug = newVal.params.slug ? newVal.params.slug : 'home';
            const page = this.pages.find(page => page.slug === slug);
            this.setCurrentPage(page);
            this.loadSection(page).then(res => {
              this.setSection(res)
            });
        }
    }
}
</script>

<style scoped>

</style>