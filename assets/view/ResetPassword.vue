<template>
  <div class="container-fluid height-s">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-10 m-auto">
          <form v-on:submit.prevent="handleSubmit">
            <div class="row">
              <div v-if="this.savingSuccessful == true">
                <div class="alert alert-success" role="alert">
                  <span>Wachtwoord is geupdate</span>
                </div>
              </div>
              <h2>Wijzig uw account</h2>
              <hr class="m-0">
              <div class="row mt-5 pr-0 mx-auto">
                <div class="col-md-12 col-lg-5 pl-0" :class="{ 'form-group--error': $v.password.$error }">
                  <label>Nieuw wachtwoord</label>
                  <div class="form-input">
                    <i class="fas fa-unlock-alt fa-lg"></i>
                    <input type="password" v-model.trim="$v.password.$model" name="password" placeholder="Wachtwoord">
                  </div>
                  <div class="error" v-if="!$v.password.required && submitStatus !== 'OK'">Password is required.</div>
                  <div class="error" v-if="!$v.password.minLength && submitStatus !== 'OK'">Password must have at least {{ $v.password.$params.minLength.min }} letters.</div>
                </div>
                <div class="col-md-12 col-lg-5 p-0" :class="{ 'form-group--error': $v.repeatedPassword.$error }">
                  <label>Herhaal wachtwoord</label>
                  <div class="form-input">
                    <i class="fas fa-unlock-alt fa-lg"></i>
                    <input type="password" v-model.trim="$v.repeatedPassword.$model" name="repeated_password" placeholder="Herhaal wachtwoord">
                  </div>
                  <div class="error" v-if="!$v.repeatedPassword.sameAsPassword && submitStatus !== 'OK'">Passwords must be identical.</div>
                </div>
              </div>

            </div>
            <button class="btn btn-lg btn-blue my-3" type="submit">
              Opslaan
            </button>
            <div  class="col-md-12 col-lg-5 p-0">
              <p class="typo__p" v-if="submitStatus === 'OK'">Password has updated.</p>
              <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
              <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
            </div>
          </form>
        </div>


      </div>
    </div>
  </div>

</template>

<script>
import {minLength, required, sameAs} from "vuelidate/lib/validators";
import axios from 'axios';

export default {
  name: "ResetPassword",
  props: ['user'],
  data() {
    return {
      password: '',
      repeatedPassword: '',
      savingSuccessful: false,
      submitStatus: null,
      error: '',
    }
  },
  validations: {
    password: {required, minLength: minLength(6)},
    repeatedPassword: { sameAsPassword: sameAs('password')},
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
                oldPassword: this.password,
                password: this.password,
                repeatedPassword: this.repeatedPassword,
              }).then(response => {
            console.log(response)
            if (response.status == 200) {
              this.savingSuccessful = true;
            }
          }).catch((error) => {
            console.log('registration is not correct');
          })

        }, 500)
      }

    }
  }
}
</script>

<style scoped>

</style>