<template>
  <div class="container-fluid offer-container">
    <div class="container">
      <div class="row mt-5">
        <div class="col-md-12">
          <h2 class="text-center text-white pt-3">Beschikbare race</h2>
        </div>
        <hr>
        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>
          <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
              <li v-for="(lesson, index) in parentData">
                <div class="uk-panel">
<!--                  {{lesson}}-->
                  <img class="offer-image"
                       :src="'assets/uploads/category/'+ lesson.Category.image"
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
</template>

<script>
export default {
  name: "Moment",
  props: ['parentData'],
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
    }
  }
}
</script>

<style scoped>

</style>