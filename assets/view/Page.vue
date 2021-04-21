<template>
    <div>
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
</template>

<script>
import Section from './component/Section';
import store from '../store';
import {mapMutations, mapActions, mapGetters} from 'vuex';
import axios from 'axios';

export default {
    name: "Page",
    store: store,
    components: {
        Section,
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
    },
    methods: {
      ...mapActions({
        loadPages: 'loadPages',
        loadSection: 'loadSection',
      }),
      ...mapMutations({
        setCurrentPage: 'SET_CURRENTPAGE',
        setSection: 'SET_SECTION',
      }),
      onUserAuthenticated(userUri) {
        axios
            .get(userUri)
            .then(response => (this.user = response.data));
      }
    },
    data() {
      return {
        user: null
      }
    },
    mounted() {
        if (window.user) {
          this.user = window.user;
        }
        this.loadPages().then(res => {
          this.loadSection(res)
        });
    },
    watch: {
        '$route'(newVal) {
          let slug = newVal.params.slug ? newVal.params.slug : 'home';
            const page = this.pages.find(page => page.slug === slug);
            this.setCurrentPage(page);

            if (newVal.params.slug != 'login' && newVal.params.slug != 'registratie'){
              this.loadSection(page).then(res => {
                this.setSection(res)
              });
            }
        },
    }
}
</script>

<style scoped>

</style>