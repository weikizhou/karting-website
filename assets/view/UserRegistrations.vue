<template>
  <div v-if="user != null">
    <div class="container" v-if="user.registrations.length >= 1">
      <div class="row my-3">
        <h3 class="text-center">Uw inschrijvingen</h3>
        <div class="uk-slider-container-offset" uk-slider>
          <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
            <div v-if="user.registrations.length > 1">
              <ul class="uk-slider-items uk-grid uk-child-width-1-2@s">
                <li v-for="registration in user.registrations">
                </li>
              </ul>
            </div>
            <div v-else-if="user.registrations.length <= 1"></div>
            <ul class="uk-slider-items uk-grid uk-child-width-1">
              <li v-for="registration in user.registrations">
                <div class="uk-card uk-card-default w-50 m-auto">
                  <div class="uk-card-media-top">
                    <img class="registration-list-image"
                         :src="'../assets/uploads/category/'+ registration.moment.category.image" alt="category_image">
                  </div>
                  <div class="uk-card-body">
                    <h3 class="uk-card-title">{{ user.registration.moment.category.name }}</h3>
                    <p>{{ user.registration.moment.category.introduction|raw }}</p>
<!--                    <a class="btn btn-blue" href="{{ path('moment-detail',-->
<!--                                                    {'slug': registration[0].moment.category.slug, 'date': registration[0].moment.date|date('d-m-Y')}) }}">-->
<!--                      Meer info</a>-->
                  </div>
                </div>
              </li>
            </ul>
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
export default {
  name: "UserRegistrations",
  props: ['user'],

}
</script>

<style scoped>

</style>