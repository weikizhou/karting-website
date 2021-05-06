<template>
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-10 m-auto" v-if="user != null">
          <form v-on:submit.prevent="handleSubmit">
            <div class="row mx-2">
              <h2>Wijzig uw account</h2>
              <hr class="m-0">

              <div class="form-group-registration" :class="{ 'form-group--error': $v.email.$error }">
                <label class="mt-3">E-mailadres*</label>
                <div class="form-input p-0">
                  <i class="far fa-envelope fa-lg"></i>
                  <input type="email" v-model.trim="$v.email.$model" name="email" placeholder="E-mailadres">
                </div>
                <div class="error" v-if="!$v.email.required && submitStatus !== 'OK'">Email is required</div>
              </div>

              <div class="form-group-registration" :class="{ 'form-group--error': $v.name.$error }">
                <label class="mt-3">Volledige naam*</label>
                <div class="form-input p-0">
                  <i class="fas fa-id-card-alt fa-lg"></i>
                  <input type="text" v-model.trim="$v.name.$model" name="name" placeholder="Volledige naam">
                </div>
                <div class="error" v-if="!$v.name.required && submitStatus !== 'OK'">Name is required</div>
                <div class="error" v-if="!$v.name.minLength && submitStatus !== 'OK'">Name must have at least
                  {{ $v.name.$params.minLength.min }} letters.
                </div>
              </div>

              <div class="form-group-registration" :class="{ 'form-group--error': $v.username.$error }">
                <label class="mt-3">Gebruikersnaam*</label>
                <div class="form-input p-0">
                  <i class="fas fa-user fa-lg"></i>
                  <input type="text" v-model.trim="$v.username.$model" name="username" placeholder="Gebruikersnaam">
                </div>
                <div class="error" v-if="!$v.username.required && submitStatus !== 'OK'">Username is required</div>
                <div class="error" v-if="!$v.username.minLength && submitStatus !== 'OK'">Username must have at least
                  {{ $v.username.$params.minLength.min }} letters.
                </div>
              </div>
            </div>

            <div class="row my-4 mx-2">
              <h2>Persoonlijke informatie</h2>
              <hr class="m-0">

              <div class="form-group-registration" :class="{ 'form-group--error': $v.phone.$error }">
                <label class="mt-3">Telefoon*</label>
                <div class="form-input p-0">
                  <i class="fas fa-phone fa-lg"></i>
                  <input type="text" v-model.trim="$v.phone.$model" name="phone" placeholder="Telefoon">
                </div>
                <div class="error" v-if="!$v.phone.required && submitStatus !== 'OK'">Phone number is required.</div>
                <div class="error" v-if="!$v.phone.minLength && submitStatus !== 'OK'">Phone must have at least
                  {{ $v.phone.$params.minLength.min }} numbers.
                </div>
              </div>

              <div class="row p-0">
                <div class="col-md-12 col-lg-8" :class="{ 'form-group--error': $v.postalCode.$error }">
                  <label class="mt-3">Postcode</label>
                  <div class="form-input p-0">
                    <i class="fas fa-map-marked-alt fa-lg"></i>
                    <input id="postal_code" type="text" v-model.trim="$v.postalCode.$model" name="postal_code"
                           placeholder="Postcode">
                  </div>
                  <div class="error" v-if="!$v.postalCode.required && submitStatus !== 'OK'">Postal code is required.
                  </div>
                  <div class="error" v-if="!$v.postalCode.minLength && submitStatus !== 'OK'">Postal code must have at
                    least {{ $v.postalCode.$params.minLength.min }} letters.
                  </div>
                </div>
                <div class="col-md-12 col-lg-4 p-0" :class="{ 'form-group--error': $v.houseNr.$error }">
                  <label class="mt-3">Huis nr.</label>
                  <div class="form-input p-0">
                    <i class="fas fa-home fa-lg"></i>
                    <input id="house_nr" type="text" v-model.trim="$v.houseNr.$model" name="house_nr"
                           placeholder="Huis nr.">
                  </div>
                  <div class="error" v-if="!$v.houseNr.required && submitStatus !== 'OK'">House number is required.
                  </div>
                </div>
              </div>

              <div class="form-group-registration" :class="{ 'form-group--error': $v.address.$error }">
                <label class="mt-3">Adres</label>
                <div class="form-input p-0">
                  <i class="fas fa-map-pin fa-lg"></i>
                  <input id="address" type="text" v-model="$v.address.$model" name="address" placeholder="Adres">
                </div>
                <div class="error" v-if="!$v.address.required && submitStatus !== 'OK'">Address is required.</div>
              </div>

              <div class="row">
                <button class="btn btn-lg btn-blue my-3 w-75 mr-4 col-md-12 col-lg-5" type="submit" v-bind:class="{ disabled: this.savingSuccessful }">
                  Opslaan
                </button>
                <router-link class="btn btn-lg btn-blue my-3 w-75 col-md-12 col-lg-5" :to="{name: 'ResetPassword'}">
                  Wijzig wachtwoord
                </router-link>
                <div  class="col-md-12 col-lg-5">
                  <p class="typo__p" v-if="submitStatus === 'OK'">Account has updated.</p>
                  <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
                  <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
                </div>

              </div>


            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import {required, sameAs, minLength} from 'vuelidate/lib/validators';

export default {
  name: "UserDetail",
  props: ['user'],
  data() {
    return {
      submitStatus: null,
      savingSuccessful: false,
      email: '',
      name: '',
      username: '',
      phone: '',
      postalCode: '',
      houseNr: '',
      address: '',
    }
  },
  validations: {
    email: {required},
    name: {required, minLength: minLength(4)},
    username: {required, minLength: minLength(6)},
    phone: {required, minLength: minLength(10)},
    postalCode: {required, minLength: minLength(6)},
    houseNr: {required},
    address: {required},
  },
  computed:{
    getUserValues() {
      this.email = this.user.email;
      this.name = this.user.name;
      this.username = this.user.username;
      this.phone = this.user.phone;
      this.postalCode = this.user.postalCode;
      this.houseNr = this.user.houseNr;
      this.address = this.user.address;
    },
  },
  methods: {
    handleSubmit() {
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
              .put('/api/users/' + this.user.id, {
                email: this.email,
                name: this.name,
                username: this.username,
                phone: this.phone,
                postalCode: this.postalCode,
                houseNr: this.houseNr,
                address: this.address,
              }).then(response => {
            // this.user = '';
            console.log(response)
            if (response.status == 201) {
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