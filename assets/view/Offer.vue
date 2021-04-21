<template>
  <div>
    <div class="container-fluid">
      <div class="row">
        <div class="uk-position-relative uk-visible-toggle uk-light moment-carousel-indicator" tabindex="-1" uk-slider>
          <ul class="uk-slider-items uk-grid">
            <li v-for="(category, index) in category" class="uk-width-4-5">
              <div class="uk-panel">
                <img class="category-lesson-image shadow"
                     :src="'../assets/uploads/category/'+ category.image" alt="category_image">
                <div class="uk-position-center-left uk-text-left">
                  <div class="content">
                    <h2 uk-slider-parallax="x: 200,-200">{{ category.name }}</h2>
                    <p uk-slider-parallax="x: 200,-200" v-html="category.introduction">{{ category.introduction }}</p>
                    <p uk-slider-parallax="x: 200,-200">
                      <i class="far fa-id-card"></i> {{ category.minimumAge }}<br>
                      <i class="fas fa-hourglass-half"></i> {{ formatTime(category.time) }}<br>
                      <i class="fas fa-ticket-alt"></i> &euro;{{ parseFloat(category.price/100).toFixed(2) }}
                    </p>

                    <router-link uk-slider-parallax="x: 200,-200" class="btn btn-blue"
                                 :to="{name: 'CategoryDetail', params: {category: category.slug}}">
                      Meer info
                    </router-link>
                  </div>
                </div>
              </div>
            </li>
          </ul>
          <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous
             uk-slider-item="previous"></a>
          <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
        </div>
      </div>
    </div>
    <div class="container-fluid offer-container">
      <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <h2 class="text-center text-white pt-3">Beschikbare race</h2>
          </div>
          <hr>
          <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>
            <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
              <li v-for="(lesson, index) in moments">
                <div class="uk-panel">
                  <!--                  {{lesson}}-->
                  <img class="offer-image"
                       :src="'../assets/uploads/category/'+ lesson.Category.image"
                       alt="">
                  <div class="uk-position-center uk-text-center">
                    <div class="content">
                      <h3>{{ lesson.Category.name }}</h3>
                      <i class="fas fa-users"></i>
                      {{ lesson.maxParticipants }}
                    </div>
                  </div>
                </div>
                <p class="text-center">
                  <i class="far fa-calendar-alt"></i>
                  {{ formatDate(lesson.date) }} / {{ formatTime(lesson.time) }}
                </p>
              </li>

            </ul>

            <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
  name: "Offer",
  methods: {
    formatTime(time){
      var hours = new Date(time).getHours();
      var minutes = new Date(time).getMinutes();
      minutes = minutes < 10 ? '0'+minutes : minutes;
      return hours + ':' + minutes;
    },
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
    ...mapActions({
      loadCategory: 'loadCategory',
      loadMoments: 'loadMoments',
    }),
  },
  computed: {
    category() {
      return this.$store.state.category
    },
    moments() {
      return this.$store.state.moments
    },
  },
  mounted() {
    this.loadCategory();
    this.loadMoments();
  },

}
</script>

<style scoped>

</style>