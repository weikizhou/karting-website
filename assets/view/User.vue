<template>
  <div class="container-fluid">
    <div class="row">
      <div class="uk-position-relative uk-visible-toggle uk-light moment-carousel-indicator" tabindex="-1" uk-slider>
        <ul class="uk-slider-items uk-grid">
          <!--          {% set categorySlug = lesson.category.slug %}-->
          <li class="uk-width-4-5" v-for="(lesson, index) in moments">
            <div class="uk-panel">
              <img class="lesson-image shadow" :src="'assets/uploads/category/'+ lesson.Category.image" alt="lesson_image">
              <div class="uk-position-center-left uk-text-left">
                <div class="content">
                  <h2 uk-slider-parallax="x: 200,-200">{{ lesson.Category.name }}</h2>
                  <p v-html="lesson.Category.introduction" uk-slider-parallax="x: 200,-200">{{ lesson.Category.introduction }}</p>
                  <p uk-slider-parallax="x: 200,-200">
                    <i class="far fa-calendar-alt"></i>
                    {{ formatDate(lesson.date) }} / {{ formatTime(lesson.time) }}
                    <br>
                    <i class="fas fa-users"></i>
                    {{ lesson.maxParticipants }}
                  </p>
                  <router-link uk-slider-parallax="x: 200,-200" class="btn btn-blue"
                               :to="{name: 'MomentDetail', params: {category: lesson.Category.slug, date: formatDate(lesson.date)} }">
                    Meer info
                  </router-link>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
      </div>
    </div>
  </div>
</template>

<script src="https://cdn.jsdelivr.net/npm/uikit@3.6.18/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.6.18/dist/js/uikit-icons.min.js"></script>
<script>
import {mapActions} from "vuex";

export default {
  name: "User",
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
      loadMoments: 'loadMoments',
    }),
  },
  computed: {
    moments() {
      return this.$store.state.moments
    },
  },
  mounted() {
    this.loadMoments();
  },
}
</script>

<style scoped>

</style>