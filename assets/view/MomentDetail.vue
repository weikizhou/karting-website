<template>
  <div>
    <div class="uk-position-relative uk-visible-toggle uk-light detal-carousel-indicator" tabindex="-1" uk-slideshow="animation: push">
      <ul class="uk-slideshow-items">
        <li>
          <img class="carousel-image" v-if="currentCategory.image != null"
               :src="'../assets/uploads/category/'+ currentCategory.image" alt="category_image" uk-cover>
          <div class="uk-position-center uk-text-left">
            <div class="container m-auto">
              <h1 uk-slideshow-parallax="x: 200,-200">{{ currentCategory.name }}</h1>
              <p v-html="currentCategory.introduction" uk-slideshow-parallax="x: 200,-200">{{ currentCategory.introduction }}</p>
              <br>
              <p uk-slideshow-parallax="x: 200,-200">
                <i class="far fa-calendar-alt"></i>
                {{ formatDate(currentMoment.date) }} / {{ formatTime(currentMoment.time) }}
                <br>
                <i class="fas fa-users"></i>
                {{ currentMoment.maxParticipants }}
              </p>
            </div>

          </div>
        </li>
      </ul>
    </div>

    <div class="container my-4">
      <div class="row">
<!--        {% set categorySlug = lesson.category.slug %}-->
        <div class="col-md-12 col-lg-8">
          <h2>{{ currentCategory.name }}</h2>
          <div v-html="currentCategory.description">
            {{ currentCategory.description }}
          </div>
        </div>
        <div class="col-md-12 col-lg-4 register-sidebar">
          <h3 class="m-0 shadow">Meer info</h3>
          <ul class="shadow m-0">
            <li>
              <i class="far fa-calendar-alt"></i> <span>Datum: </span>
              {{ formatDate(currentMoment.date) }} / {{ formatTime(currentMoment.time) }}
            </li>
            <li><i class="fas fa-clock"></i> <span>Tijdsduur: </span>{{ formatTime(currentCategory.time) }}</li>
            <li><i class="fas fa-users"></i> <span>Max aantal: </span>{{ currentMoment.maxParticipants }}</li>

<!--            {% if availablePlaces is not empty %}-->
<!--            <li>-->
<!--              <i class="fas fa-user-plus"></i>-->
<!--              <span>Beschikbare plekken over: {{ availablePlaces }}</span>-->
<!--            </li>-->
<!--            {% endif %}-->
            <li><i class="far fa-id-card"></i><span> Minumum leeftijd: {{ currentCategory.minimumAge }}</span>
            </li>
            <li><i class="fas fa-ticket-alt"></i> <span> Prijs: </span>
              &euro;{{ parseFloat(currentCategory.price/100).toFixed(2) }}</li>
          </ul>
<!--          {% if registrationFull == true %}-->
<!--          <a class="btn btn-lg btn-blue w-100"-->
<!--             href="{{ path('moment-detail',-->
<!--                           {'slug': categorySlug, 'date': lesson.date|date('d-m-Y')}) }}">-->
<!--            {{ lesson.category.name }} <span>zit vol!</span>-->
<!--          </a>-->
<!--          {% else %}-->
<!--          {% if registration is empty %}-->
<!--          <a class="btn btn-lg btn-blue w-100"-->
<!--             href="{{ path('register-activity',-->
<!--                               {'slug': categorySlug, 'date': lesson.date|date('d-m-Y')}) }}">-->
<!--            Inschrijven-->
<!--          </a>-->
<!--          {% else %}-->
<!--          <a class="btn btn-lg btn-blue w-100"-->
<!--             href="{{ path('delete-register', {'slug': registration[0].moment.category.slug, 'date': lesson.date|date('d-m-Y')}) }}">-->
<!--            Uitschrijven-->
<!--          </a>-->
<!--          {% endif %}-->
<!--          {% endif %}-->
        </div>
      </div>
    </div>



  </div>
</template>

<script>
import store from "../store";
import {mapActions, mapMutations} from "vuex";
import axios from "axios";

export default {
  name: "MomentDetail",
  store: store,
  components: {
  },
  computed: {
    // ...mapGetters({
    //   currentUrl: 'getCurrentUrl'
    // }),
    category() {
      return this.$store.state.category
    },
    moments() {
      return this.$store.state.moments
    },
    currentMoment() {
      return this.$store.state.currentMoment
    },
    currentCategory() {
      return this.$store.state.currentCategory
    },
  },
  methods: {
    ...mapActions({
      loadCategory: 'loadCategory',
      loadMoments: 'loadMoments',
    }),
    ...mapMutations({
      setCurrentMoment: 'SET_CURRENT_MOMENT',
    }),
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
    onUserAuthenticated(userUri) {
      axios
          .get(userUri)
          .then(response => (this.user = response.data));
    }
  },
  data() {
    return {
      user: null,
    }
  },
  mounted() {
    if (window.user) {
      this.user = window.user;
    }
    this.loadMoments();
    this.loadCategory();
  },

}
</script>

<style scoped>

</style>