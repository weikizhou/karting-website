<template>
  <div>
    <div class="container py-3">
      <div class="row">
        <div class="col-md-12 col-lg-10 m-auto">
          <nav class="navbar navbar-expand-lg navbar-light flex items-center justify-between">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="flex items-center">
              <a class="text-decoration-none text-dark" href="/">
                <h2 class="mx-4 my-0">Kartcentrum Max</h2>
              </a>
              <ul class="navbar-nav">
                <router-link :to="'/'+slug"></router-link>
                <li class="nav-item" v-for="(page, index) in pages">
                  <a class="nav-link" :href="'/' + page.slug" v-if="page.inNavigation == 1">{{ page.navTitle }}</a>
                </li>
              </ul>
            </div>
            <div class="flex items-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="/login/kartcentrum"><i class="fas fa-lock"></i> Inloggen</a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>

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

    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-10 m-auto">
            <div class="row">
              <div class="col-sm-12 col-md-9">
                <h2>Over Kartcentrum Max</h2>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                  industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                  and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
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
import axios from 'axios';
import Section from './component/Section';

var currentUrl = window.location.pathname;

export default {
  name: "Page",
  data() {
    return {
      pages: {},
      currentPage: {},
      section: {},
      slug: [],
    };
  },
  components: {
    Section
  },
  methods: {
    getSection(){
      const requestTwo = axios.get('http://localhost:8000/api/sections?page='+ this.currentPage.id);
      axios.all([requestTwo]).then(axios.spread((...responses) => {
        this.section = responses[0].data['hydra:member']
      })).catch(errors => {
        console.log('error section')
      })
    }
  },
  mounted () {
    //First i get the pages
    const requestOne = axios.get('http://localhost:8000/api/pages');
    axios.all([requestOne]).then(axios.spread((...responses) => {
      this.pages = responses[0].data['hydra:member'];
      if (currentUrl == '/'){
        currentUrl = '/home';
      }
      //Then we have to get the currentPage
      var i;
      for (i = 0; i < this.pages.length; i++) {
        if ('/'+this.pages[i].slug == currentUrl){
          this.currentPage = this.pages[i];
        }
        this.slug.push(this.pages[i].slug);
      }
      //After that we can call our api to get the sections of this page in methods()
      if (this.currentPage){
        this.getSection();
      }
    })).catch(errors => {
      console.log('error page')
    });
  },

}
</script>

<style scoped>

</style>