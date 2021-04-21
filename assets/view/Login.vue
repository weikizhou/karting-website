<template>
  <div class="container height-s">
    <div class="row">
      <div class="col-md-12 col-lg-6 inlog-form px-5">
        <h2>Inloggen</h2>
        <form v-on:submit.prevent="handleSubmit" class="form-group">
          <div v-if="error" class="alert alert-danger">
            {{ error }}
          </div>
          <input type="text" v-model="username" class="form-control"
                 id="inputUsername" placeholder="Gebruikersnaam">
          <input type="password" v-model="password" class="form-control"
                 id="inputPassword" placeholder="Wachtwoord">
<!--          <button type="submit" class="btn btn-primary" v-bind:class="{ disabled: this.user }">Log in</button>-->
          <button type="submit" class="btn btn-primary">Log in</button>
        </form>
        <router-link :to="{name: 'Registration'}">
          Nog geen account? Meld je aan!
        </router-link>
      </div>
      <div class="col-md-12 col-lg-6 px-5">
        <img class="img-fluid" src="assets/img/login_image.jpg" alt="login_image">
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "Login",
  data() {
    return {
      username: '',
      password: '',
      error: '',
    }
  },
  methods: {
    handleSubmit() {
      this.error = '';
      axios
          .post('/api/login',{
            username: this.username,
            password: this.password,
          })
          .then(response => {
            this.$emit('user-authenticated', response.headers.location);
            this.username = '';
            this.password = '';
            this.$router.push('/gebruiker');
          }).catch(error => {
        if (error.response.data.error) {
          this.error = error.response.data.error;
        } else {
          this.error = 'Unknown error';
        }
      }).finally(() => {
        this.isLoading = false;
      })
    },
  },
  mounted() {
    if (window.user) {
      this.user = window.user;
    }
  }
}
</script>

<style scoped>

</style>