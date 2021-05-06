<template>
  <div class="container-fluid height-s">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-10 m-auto">
          <div class="row">
            <h2>Wijzig uw account</h2>
            <hr class="m-0">

            <div class="form-group-registration">
              <label class="mt-3">Oude wachtwoord</label>
              <div class="form-input">
                <i class="fas fa-unlock-alt fa-lg"></i>
                <input type="password" v-model.trim="$v.oldPassword.$model" name="oldPassword" placeholder="Wachtwoord">
              </div>
              <div class="error" v-if="!$v.password.required && submitStatus !== 'OK'">Password is required.</div>
              <div class="error" v-if="!$v.password.minLength && submitStatus !== 'OK'">Password must have at least {{ $v.password.$params.minLength.min }} letters.</div>
            </div>

            <div class="row mt-5 pr-0">
              <div class="col-md-12 col-lg-6 pl-0" :class="{ 'form-group--error': $v.password.$error }">
                <label>Nieuw wachtwoord</label>
                <div class="form-input">
                  <i class="fas fa-unlock-alt fa-lg"></i>
                  <input type="password" v-model.trim="$v.password.$model" name="password" placeholder="Wachtwoord">
                </div>
                <div class="error" v-if="!$v.password.required && submitStatus !== 'OK'">Password is required.</div>
                <div class="error" v-if="!$v.password.minLength && submitStatus !== 'OK'">Password must have at least {{ $v.password.$params.minLength.min }} letters.</div>
              </div>
              <div class="col-md-12 col-lg-6 p-0" :class="{ 'form-group--error': $v.repeatedPassword.$error }">
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
      oldPassword: '',
      password: '',
      repeatedPassword: '',
      savingSuccessful: false,
      submitStatus: null,
      error: '',
    }
  },
  validations: {
    oldPassword: {required, minLength: minLength(6)},
    password: {required, minLength: minLength(6)},
    repeatedPassword: { sameAsPassword: sameAs('password')},
  },
}
</script>

<style scoped>

</style>