<template>
  <div>
    <div class="uk-position-relative uk-visible-toggle uk-light detal-carousel-indicator" tabindex="-1" uk-slideshow="animation: push">
      <ul class="uk-slideshow-items">
        <li>
          <img class="carousel-image" v-if="currentCategory.image != null"
               :src="'../assets/uploads/category/'+ currentCategory.image" alt="" uk-cover>
          <div class="uk-position-center uk-text-left">
            <div class="container m-auto">
              <h1 uk-slideshow-parallax="x: 200,-200">{{ currentCategory.name }}</h1>
              <p v-html="currentCategory.introduction" uk-slideshow-parallax="x: 200,-200">{{ currentCategory.introduction }}</p>
              <p uk-slider-parallax="x: 200,-200">
                <i class="far fa-id-card"></i> {{ currentCategory.minimumAge }}<br>
                <i class="fas fa-hourglass-half"></i> {{ formatTime(currentCategory.time) }}<br>
                <i class="fas fa-ticket-alt"></i> &euro;{{ parseFloat(currentCategory.price/100).toFixed(2) }}
              </p>
            </div>

          </div>
        </li>
      </ul>
    </div>
    <div class="container my-4">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <h2>{{ currentCategory.name }}</h2>
          <p v-html="currentCategory.description">
            {{ currentCategory.description }}
          </p>
        </div>
        <div class="col-md-12 col-lg-4 register-sidebar">
          <h3 class="m-0 shadow">Meer info</h3>
          <ul class="shadow m-0">
            <li><i class="fas fa-clock"></i> <span>Tijdsduur: </span>{{ formatTime(currentCategory.time) }}</li>
            <li><i class="far fa-id-card"></i><span> Minumum leeftijd: {{ currentCategory.minimumAge }}</span>
            </li>
            <li><i class="fas fa-ticket-alt"></i> <span> Prijs: </span>
              &euro;{{ parseFloat(currentCategory.price/100).toFixed(2) }}</li>
          </ul>
<!--          {% if is_granted('ROLE_USER') %}-->
<!--          <a class="btn btn-lg btn-blue w-100"-->
<!--             href="{{ path('register-activity',-->
<!--                           {'slug': categorySlug, 'date': lesson.date|date('d-m-Y')}) }}">-->
<!--            Inschrijven-->
<!--          </a>-->
<!--          {% endif %}-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
  name: "CategoryDetail",
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
    currentCategory() {
      return this.$store.state.currentCategory
    },
  },
  mounted() {
    this.loadCategory();
  },
}
</script>

<style scoped>

</style>