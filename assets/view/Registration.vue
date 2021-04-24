<template>
  <div class="container">
    <div class="row">
      <div v-if="this.savingSuccessful == true">
        <div class="alert alert-success" role="alert">
          Account is aangemaakt!
          <router-link :to="{name: 'Login'}">
            Ga snel inloggen <i class="fas fa-angle-double-right"></i>
          </router-link>
        </div>
      </div>
      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>
      <div class="col-md-12 col-lg-7 registration-form mr-4">
        <form v-on:submit.prevent="handleSubmit">
          <div class="row mx-2">
            <h2>Maak uw eigen account</h2>
            <hr class="m-0">

            <div class="form-group-registration" :class="{ 'form-group--error': $v.email.$error }">
              <label>E-mailadres*</label>
              <div class="form-input p-0" >
                <i class="far fa-envelope fa-lg"></i>
                <input type="email" v-model.trim="$v.email.$model" name="email" placeholder="E-mailadres">
              </div>
              <div class="error" v-if="!$v.email.required && submitStatus !== 'OK'">Email is required</div>
            </div>

            <div class="form-group-registration" :class="{ 'form-group--error': $v.name.$error }">
              <label>Volledige naam*</label>
              <div class="form-input p-0">
                <i class="fas fa-id-card-alt fa-lg"></i>
                <input type="text" v-model.trim="$v.name.$model" name="name" placeholder="Volledige naam">
              </div>
              <div class="error" v-if="!$v.name.required && submitStatus !== 'OK'">Name is required</div>
              <div class="error" v-if="!$v.name.minLength && submitStatus !== 'OK'">Name must have at least {{$v.name.$params.minLength.min}} letters.</div>
            </div>

            <div class="form-group-registration" :class="{ 'form-group--error': $v.username.$error }">
              <label>Gebruikersnaam*</label>
              <div class="form-input p-0">
                <i class="fas fa-user fa-lg"></i>
                <input type="text" v-model.trim="$v.username.$model" name="username" placeholder="Gebruikersnaam">
              </div>
              <div class="error" v-if="!$v.username.required && submitStatus !== 'OK'">Username is required</div>
              <div class="error" v-if="!$v.username.minLength && submitStatus !== 'OK'">Username must have at least {{$v.username.$params.minLength.min}} letters.</div>
            </div>

            <div class="row p-0">
                <div class="col-md-12 col-lg-6" :class="{ 'form-group--error': $v.password.$error }">
                  <label>Wachtwoord*</label>
                  <div class="form-input">
                    <i class="fas fa-unlock-alt fa-lg"></i>
                    <input type="password" v-model.trim="$v.password.$model" name="password" placeholder="Wachtwoord">
                  </div>
                  <div class="error" v-if="!$v.password.required && submitStatus !== 'OK'">Password is required.</div>
                  <div class="error" v-if="!$v.password.minLength && submitStatus !== 'OK'">Password must have at least {{ $v.password.$params.minLength.min }} letters.</div>
                </div>

                <div class="col-md-12 col-lg-6 p-0" :class="{ 'form-group--error': $v.repeatedPassword.$error }">
                  <label>Herhaal wachtwoord*</label>
                  <div class="form-input">
                    <i class="fas fa-unlock-alt fa-lg"></i>
                    <input type="password" v-model.trim="$v.repeatedPassword.$model" name="repeated_password" placeholder="Herhaal wachtwoord">
                  </div>
                  <div class="error" v-if="!$v.repeatedPassword.sameAsPassword && submitStatus !== 'OK'">Passwords must be identical.</div>
                </div>
            </div>
          </div>

          <div class="row my-4 mx-2">
            <h2>Persoonlijke informatie</h2>
            <hr class="m-0">

            <div class="form-group-registration" :class="{ 'form-group--error': $v.phone.$error }">
              <label>Telefoon*</label>
              <div class="form-input p-0">
                <i class="fas fa-phone fa-lg"></i>
                <input type="text" v-model.trim="$v.phone.$model" name="phone" placeholder="Telefoon">
              </div>
              <div class="error" v-if="!$v.phone.required && submitStatus !== 'OK'">Phone number is required.</div>
              <div class="error" v-if="!$v.phone.minLength && submitStatus !== 'OK'">Phone must have at least {{ $v.phone.$params.minLength.min }} numbers.</div>
            </div>

            <div class="form-group-registration">
              <label>Geboorte datum</label>
              <div class="form-input p-0">
                <i class="fas fa-calendar-alt fa-lg"></i>
                <input type="date" v-model.trim="dateOfBirth" name="date_of_birth" placeholder="Geboorte datum">
              </div>
            </div>

            <div class="row p-0">
              <div class="col-md-12 col-lg-8" :class="{ 'form-group--error': $v.postalCode.$error }">
                <label>Postcode</label>
                <div class="form-input p-0">
                  <i class="fas fa-map-marked-alt fa-lg"></i>
                  <input id="postal_code" type="text" v-model.trim="$v.postalCode.$model" name="postal_code" placeholder="Postcode">
                </div>
                <div class="error" v-if="!$v.postalCode.required && submitStatus !== 'OK'">Postal code is required.</div>
                <div class="error" v-if="!$v.postalCode.minLength && submitStatus !== 'OK'">Postal code must have at least {{ $v.postalCode.$params.minLength.min }} letters.</div>
              </div>
              <div class="col-md-12 col-lg-4 p-0" :class="{ 'form-group--error': $v.houseNr.$error }">
                <label>Huis nr.</label>
                <div class="form-input p-0">
                  <i class="fas fa-home fa-lg"></i>
                  <input id="house_nr" type="text" v-model.trim="$v.houseNr.$model" name="house_nr" placeholder="Huis nr.">
                </div>
                <div class="error" v-if="!$v.houseNr.required && submitStatus !== 'OK'">House number is required.</div>
              </div>
            </div>

            <div class="form-group-registration" :class="{ 'form-group--error': $v.address.$error }">
              <label>Adres</label>
              <div class="form-input p-0">
                <i class="fas fa-map-pin fa-lg"></i>
                <input id="address" type="text" v-model="$v.address.$model" name="address" placeholder="Adres">
              </div>
              <div class="error" v-if="!$v.address.required && submitStatus !== 'OK'">Address is required.</div>
            </div>

            <button class="btn btn-lg btn-blue my-3" type="submit" v-bind:class="{ disabled: this.savingSuccessful }">
              Aanmelden
            </button>
            <p class="typo__p" v-if="submitStatus === 'OK'">Thanks for your submission!</p>
            <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
            <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>

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
import { required, sameAs, minLength } from 'vuelidate/lib/validators';

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
      savingSuccessful: false,
      submitStatus: null,
      error: '',
    }
  },
  validations: {
    email: {required},
    name: {required, minLength: minLength(4)},
    username: {required, minLength: minLength(6)},
    password: {required, minLength: minLength(6)},
    repeatedPassword: { sameAsPassword: sameAs('password')},
    phone: {required, minLength: minLength(10)},
    postalCode: {required,  minLength: minLength(6)},
    houseNr: {required},
    address: {required},
  },
  methods:{
    handleSubmit(){
      this.error = '';
      this.$v.$touch()
      if (this.$v.$invalid) {
        this.submitStatus = 'ERROR'
      } else {
        // do your submit logic here
        this.submitStatus = 'PENDING'
        setTimeout(() => {
          this.submitStatus = 'OK';
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
              }).then(response =>{
            this.email = '';
            this.name = '';
            this.username = '';
            this.password = '';
            this.password = '';
            this.repeatedPassword = '';
            this.phone = '';
            this.dateOfBirth = '';
            this.postalCode = '';
            this.houseNr = '';
            this.address = '';
            if(response.status == 201){
              this.savingSuccessful = true;
            }
          }).catch((error) => {
            console.log('registration is not correct');
          })
        }, 500)
      }

    }
  },
}
</script>

<style scoped>

</style>