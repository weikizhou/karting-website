<template>
  <div>
    <div class="container-fluid">
      <div class="row">
        <div class="uk-position-relative uk-visible-toggle uk-light moment-carousel-indicator" tabindex="-1" uk-slider>
          <ul class="uk-slider-items uk-grid">
            <li v-for="(category, index) in parentData" class="uk-width-4-5">
              <div class="uk-panel">
                <img class="category-lesson-image shadow"
                     :src="'assets/uploads/category/'+ category.image" alt="category_image">
                <div class="uk-position-center-left uk-text-left">
                  <div class="content">
                    <h2 uk-slider-parallax="x: 200,-200">{{ category.name }}</h2>
                    <p uk-slider-parallax="x: 200,-200" v-html="category.introduction">{{ category.introduction }}</p>
                    <p uk-slider-parallax="x: 200,-200">
                      <i class="far fa-id-card"></i> {{ category.minimumAge }}<br>
                      <i class="fas fa-hourglass-half"></i> {{ formatTime(category.time) }}<br>
                      <i class="fas fa-ticket-alt"></i> &euro;{{ parseFloat(category.price/100).toFixed(2) }}
                    </p>
                    <a uk-slider-parallax="x: 200,-200" class="btn btn-blue" :href="'/categorie/'+category.slug">
                      Meer info</a>
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
  </div>


</template>

<script>
// import CategoryDetail from '../CategoryDetail';

export default {
  name: "Category",
  props: ['parentData'],
  methods: {
    formatTime(time){
      var hours = new Date(time).getHours();
      var minutes = new Date(time).getMinutes();
      minutes = minutes < 10 ? '0'+minutes : minutes;
      return hours + ':' + minutes;
    }
  }
}
</script>

<style scoped>

</style>