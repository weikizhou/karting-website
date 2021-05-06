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
                    <div v-if="page.slug == 'aanbod'">
                      <router-link class="nav-link" v-if="page.inNavigation == 1"
                                   :to="{name: 'Offer'}">
                        {{ page.navTitle }}
                      </router-link>
                    </div>
                    <div v-else>
                      <router-link class="nav-link" v-if="page.inNavigation == 1"
                                   :to="{name: 'Page', params: {slug: page.slug}}">
                        {{ page.navTitle }}
                      </router-link>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="flex items-center">
                <ul v-if="user">
                  <div class="dropdown show">
                    <button class="btn dropdown-toggle mt-4" type="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-user-circle fa-lg"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <router-link class="dropdown-item" :to="{name: 'UserDetail'}"><i class="fas fa-user"></i>  Profiel</router-link>
                      <router-link class="dropdown-item" :to="{name: 'User'}"><i class="far fa-clock"></i>  Aanbevolen racen</router-link>
                      <router-link class="dropdown-item" :to="{name: 'UserRegistrations'}"><i class="far fa-address-book"></i>  Inschrijvingen</router-link>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="/api/logout"><i class="fas fa-unlock-alt"></i>  Uitloggen</a>
                    </div>
                  </div>
                </ul>
                <ul v-else class="navbar-nav">
                  <li class="nav-item">
                    <router-link class="nav-link" :to="{name: 'Login'}">
                      <i class="fas fa-lock"></i> Inloggen
                    </router-link>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
      </div>
        <router-view :user="user"></router-view>
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

import {mapActions, mapMutations} from "vuex";
import store from "./store";

export default {
    name: "App",
    store: store,
    data() {
      return {
        user: null
      }
    },
    methods: {
      ...mapActions({
        loadPages: 'loadPages',
      }),
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
    },
    mounted() {
      if (window.user) {
        this.user = window.user;
      }
      this.loadPages();
    },
}
</script>

<style scoped>

</style>