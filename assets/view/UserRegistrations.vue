<template>
  <div v-if="user != null">
    <div class="container" v-if="user.registrations.length >= 1">
      <div class="row my-2">
        <h3 class="text-center">Uw inschrijvingen</h3>
        <div class="uk-slider-container-offset" uk-slider>
          <hr>
          <div class="uk-position-relative uk-visible-toggle uk-light user-registration-list" tabindex="-1">
            <div v-if="user.registrations.length > 1">
              <ul class="uk-slider-items uk-grid uk-child-width-1-2@s">
                <li v-for="registration in user.registrations">
                  <div class="uk-card uk-card-default">
                    <div class="uk-card-media-top">
                      <div v-for="moment in moments">
                        <div v-if="registration.moment == '/api/moments/'+ moment.id">
                          <img class="registration-list-image"
                               :src="'../assets/uploads/category/'+ moment.Category.image" alt="category_image">
                          <div class="uk-card-body">
                            <h3 class="uk-card-title">{{ moment.Category.name }}</h3>
                            <p v-html="moment.Category.introduction">{{ moment.Category.introduction }}</p>
                            <router-link :to="{name: 'MomentDetail',
                                          params: {category: moment.Category.slug, date: formatDate(moment.date)}}">
                              <span class="btn btn-lg btn-blue">Meer info</span>
                            </router-link>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div v-else-if="user.registrations.length == 1">
              <ul class="uk-slider-items uk-grid uk-child-width-1">
                <li v-for="registration in user.registrations">
                  <div class="uk-card uk-card-default w-50 m-auto">
                    <div class="uk-card-media-top">
                      <div v-for="moment in moments">
                        <div v-if="registration.moment == '/api/moments/'+ moment.id">
                          <img class="registration-list-image"
                               :src="'../assets/uploads/category/'+ moment.Category.image" alt="category_image">
                          <div class="uk-card-body">
                            <h3 class="uk-card-title">{{ moment.Category.name }}</h3>
                            <p v-html="moment.Category.introduction">{{ moment.Category.introduction }}</p>
                            <router-link :to="{name: 'MomentDetail',
                                          params: {category: moment.Category.slug, date: formatDate(moment.date)}}">
                              <span class="btn btn-lg btn-blue">Meer info</span>
                            </router-link>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
          </div>
          <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="container height-s">
        <div class="row">
          <div class="col-md-12 col-lg-6 empty-registration-list">
            <i class="fas fa-history fa-4x"></i>
            <p class="text-center">Er zijn geen inschrijvingen van u.</p>
            <router-link class="nav-link" :to="{name: 'User'}">
              <span class="btn btn-lg btn-blue">Schrijf je nu in</span>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
  name: "UserRegistrations",
  props: ['user'],
  computed: {
    category() {
      return this.$store.state.category
    },
    moments() {
      return this.$store.state.moments
    },
  },
  methods: {
    ...mapActions({
      loadCategory: 'loadCategory',
      loadMoments: 'loadMoments',
    }),
    formatDate(date){
      var d = new Date(date),
          month = '' + (d.getMonth() + 1),
          day = '' + d.getDate(),
          year = d.getFullYear();

      if (month.length < 2)
        month = '0' + month;
      if (day.length < 2)
        day = '0' + day;

      return [year, month, day].join('-');
    },
  },
  mounted(){
    this.loadMoments();
    this.loadCategory();
  }
}
</script>

<style scoped>

</style>