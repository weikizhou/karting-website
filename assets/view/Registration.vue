<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-7 registration-form mr-4">
        <form v-on:submit.prevent="handleSubmit">
          <div class="row mx-2">
            <h2>Maak uw eigen account</h2>
            <hr class="m-0">

            <label>E-mailadres</label>
            <div class="form-input p-0">
              <i class="far fa-envelope fa-lg"></i>
              <input type="email" v-model="email" name="email" placeholder="E-mailadres">
            </div>

            <label>Volledige naam</label>
            <div class="form-input p-0">
              <i class="fas fa-id-card-alt fa-lg"></i>
              <input type="text" v-model="name" name="name" placeholder="Volledige naam">
            </div>

            <label>Gebruikersnaam</label>
            <div class="form-input p-0">
              <i class="fas fa-user fa-lg"></i>
              <input type="text" v-model="username" name="username" placeholder="Gebruikersnaam">
            </div>

            <div class="row p-0">
              <div class="col-md-12 col-lg-6">
                <label>Wachtwoord</label>
                <div class="form-input">
                  <i class="fas fa-unlock-alt fa-lg"></i>
                  <input type="password" v-model="password" name="password" placeholder="Wachtwoord">
                </div>
              </div>
              <div class="col-md-12 col-lg-6 p-0">
                <label>Herhaal wachtwoord</label>
                <div class="form-input">
                  <i class="fas fa-unlock-alt fa-lg"></i>
                  <input type="password" v-model="repeatedPassword" name="repeated_password" placeholder="Herhaal wachtwoord">
                </div>
              </div>
            </div>
          </div>

          <div class="row my-4 mx-2">
            <h2>Persoonlijke informatie</h2>
            <hr class="m-0">
            <label>Telefoon</label>
            <div class="form-input p-0">
              <i class="fas fa-phone fa-lg"></i>
              <input type="text" v-model="phone" name="phone" placeholder="Telefoon">
            </div>

            <label>Geboorte datum</label>
            <div class="form-input p-0">
              <i class="fas fa-calendar-alt fa-lg"></i>
              <input type="date" v-model="dateOfBirth" name="date_of_birth" placeholder="Geboorte datum">
            </div>

            <div class="row p-0">
              <div class="col-md-12 col-lg-8">
                <label>Postcode</label>
                <div class="form-input p-0">
                  <i class="fas fa-map-marked-alt fa-lg"></i>
                  <input id="postal_code" type="text" v-model="postalCode" name="postal_code" placeholder="Postcode">
                </div>
              </div>
              <div class="col-md-12 col-lg-4 p-0">
                <label>Huis nr.</label>
                <div class="form-input p-0">
                  <i class="fas fa-home fa-lg"></i>
                  <input id="house_nr" type="text" v-model="houseNr" name="house_nr" placeholder="Huis nr.">
                </div>
              </div>
            </div>

            <label>Adres</label>
            <div class="form-input p-0">
              <i class="fas fa-map-pin fa-lg"></i>
              <input id="address" type="text" v-model="address" name="address" placeholder="Adres">
            </div>

            <button class="btn btn-lg btn-blue my-3" type="submit">
              Aanmelden
            </button>
          </div>
        </form>
      </div>
      <div class="col-md-12 col-lg-4 registration-card shadow"
           :style="{ 'background-image' : 'url(assets/img/registratie_image.jpg)' }">
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "Registration",
  data() {
    return {
      email: '',
      name: '',
      username: '',
      password: '',
      repeatedPassword: '',
      phone: '',
      dateOfBirth: '',
      postalCode: '',
      houseNr: '',
      address: '',
    }
  },
  methods:{
    handleSubmit(){
      axios
          .post('/api/users', {
            email: this.email,
            name: this.name,
            username: this.username,
            password: this.password,
            oldPassword: this.password,
            repeatedPassword: this.repeatedPassword,
            phone: this.phone,
            dateOfBirth: this.dateOfBirth,
            postalCode: this.postalCode,
            houseNr: this.houseNr,
            address: this.address,
            roles: ["ROLE_USER"],
            registration: [""],
          }).then()
    }
  },
}
</script>

<style scoped>

</style>