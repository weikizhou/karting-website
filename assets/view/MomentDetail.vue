<template>
  <div>
    <div class="uk-position-relative uk-visible-toggle uk-light detal-carousel-indicator" tabindex="-1" uk-slideshow="animation: push">
      <ul class="uk-slideshow-items">
        <li>
          <img class="carousel-image" v-if="currentCategory.image != null"
               :src="'../../assets/uploads/category/'+ currentCategory.image" alt="category_image" uk-cover>
          <div class="uk-position-center uk-text-left">
            <div class="container m-auto">
              <h1 uk-slideshow-parallax="x: 200,-200">{{ currentCategory.name }}</h1>
              <p class="text-white" v-html="currentCategory.introduction" uk-slideshow-parallax="x: 200,-200">{{ currentCategory.introduction }}</p>
              <br>
              <p class="text-white" uk-slideshow-parallax="x: 200,-200">
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
        <div v-if="this.savingSuccessful == true">
          <div class="alert alert-success" role="alert">
            <span>U bent ingeschreven in de {{currentCategory.name}}.</span>
          </div>
        </div>
        <div v-else-if="this.underage == true">
          <div class="alert alert-warning" role="alert">
            <span>U moet {{currentCategory.minimumAge}} jaar zijn om hieraan deel te nemen.</span>
          </div>
        </div>
        <div v-else-if="this.deleteRegistration == true">
          <div class="alert alert-danger" role="alert">
            <span>U bent uitgeschreven uit deze race.</span>
          </div>
        </div>
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

            <div v-if="currentMoment.registrations != null">
              <li v-if="currentMoment.registrations.length < currentMoment.maxParticipants">
                  <i class="fas fa-user-plus"></i>
                  <span>Beschikbare plekken over: {{currentMoment.maxParticipants - currentMoment.registrations.length}}</span>
              </li>
            </div>


            <li><i class="far fa-id-card"></i><span>
              Minumum leeftijd: {{ currentCategory.minimumAge }}</span>
            </li>
            <li><i class="fas fa-ticket-alt"></i> <span> Prijs: </span>
              &euro;{{ parseFloat(currentCategory.price/100).toFixed(2) }}</li>
          </ul>
          <div v-if="isRegistrated == false">
            <div v-if="registerStatus == false">
              <form v-on:submit.prevent="handleAddRegistration">
                <button class="btn btn-lg btn-blue w-100" type="submit">
                  Inschrijven
                </button>
              </form>
            </div>
            <div v-else-if="registerStatus == true">
              <span class="btn btn-lg btn-blue w-100">
                {{ currentCategory.name }} <span>zit vol!</span>
              </span>
            </div>
          </div>
          <div v-else-if="isRegistrated == true">
            <form v-on:submit.prevent="handleRemoveRegistration(user)">
              <button class="btn btn-lg btn-blue w-100" type="submit">
                Uitschrijven
              </button>
            </form>
          </div>
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
  props: ['user'],
  store: store,
  data() {
    return {
      isRegistrated: false,
      registerStatus: false,
      savingSuccessful: false,
      underage: false,
      momentIsFull: false,
      deleteRegistration: false,
    }
  },
  computed: {
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
      var d = new Date(date), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
      if (month.length < 2)
        month = '0' + month;
      if (day.length < 2)
        day = '0' + day;

      return [year, month, day].join('-');
    },
    handleAddRegistration(){
      //First we check whether the age limit has been reached
      var date = new Date(this.user.dateOfBirth);
      var month_diff = Date.now() - date.getTime();
      var age_dt = new Date(month_diff);
      var year = age_dt.getUTCFullYear();
      var age = Math.abs(year - 1970);
      if (age >= this.currentCategory.minimumAge){
        //Then we check whether there is still room
        var currentRegistrations = this.currentMoment.registrations;
        if (currentRegistrations.length < this.currentMoment.maxParticipants){
          axios
              .post('/api/registrations', {
                createdAt: new Date(),
                moment: '/api/moments/'+this.currentMoment.id,
                user: '/api/users/'+this.user.id,
              }).then(response =>{
              this.user.registrations.push(response.data);
              this.isRegistrated = true;
              if(response.status == 201){
                this.savingSuccessful = true;
              }
              this.loadMoments();
          }).catch((error) => {
            console.log('registration is not correct');
          })
        }
        else{
          this.momentIsFull = true;
        }
      }
      else{
        this.underage = true;
      }
    },
    handleRemoveRegistration(user){
      if (this.isRegistrated == true){
        var i;
        for (i = 0; i < this.currentMoment.registrations.length; i++) {
          axios
              .get(this.currentMoment.registrations[i])
              .then(response => {
                var x = 0;
                for (x = 0; x <= user.registrations.length; x++){
                  if(response.data.id == user.registrations[x].id){
                    axios
                        .delete("/api/registrations/"+response.data.id)
                        .then(response => {
                          this.loadMoments().then(response => {
                            this.loadRegistrated(response);
                            this.momentFull();
                          });
                          this.isRegistrated = false;
                          this.savingSuccessful = false;
                          this.deleteRegistration = true;
                          user.registrations.splice(x - 1, 1);
                        })
                        .catch((error) => {
                          console.log('registration is niet goed verwijdert');
                        });
                  }
                }

              })
              .catch((error) => {
                console.log('registration is aan het verwijderen');
              });
        }
      }
    },
    loadRegistrated(currentMoment){
        if (currentMoment.registrations != null){
            //Checks if the user is already registrated on this moment.
            var i;
            var registrations = currentMoment.registrations;
            for (i = 0; i < registrations.length; i++) {
                axios
                    .get(registrations[i])
                    .then(response => {
                      if (response.data.user.id == this.user.id){
                          this.isRegistrated = true;
                        }
                    })
            }
        }
    },
    momentFull(){
      if (this.currentMoment.registrations.length >= this.currentMoment.maxParticipants){
        this.registerStatus = true;
      }
      else{
        this.registerStatus = false;
      }
    }
  },
  mounted() {
    this.loadMoments().then(res => {
      this.loadRegistrated(res);
      this.momentFull();
    });
    // this.loadMoments();
    this.loadCategory();
  },

}
</script>

<style scoped>

</style>