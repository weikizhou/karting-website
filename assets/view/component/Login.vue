<template>
  <div>
    <form action="post" v-on:submit.prevent class="form-group">
      <div class="form-group row">
        <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10">
          <input type="text" value="" name="username" id="inputUsername" class="form-control" v-model="username"
                 placeholder="Gebruikersnaam" required autofocus>
        </div>
      </div>

      <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Wachtwoord</label>
        <div class="col-sm-10">
          <input type="password" value="" name="password" id="inputPassword" class="form-control" v-model="password"
                 placeholder="Wachtwoord" required autofocus>
        </div>
      </div>

      <input type="hidden" name="_csrf_token" v-model="crf_token">

      <button class="btn btn-lg btn-primary" type="submit">
        Sign in
      </button>

      <div v-if="isError === true">
        <div class="alert alert-danger" role="alert">
          {{errorMessage}}
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  props: ['csrf_token', 'last_username'],
  name: "Login",
  data() {
    return {
      username: '',
      password: '',
      isError: false,
      errorMessage: '',
    }
  },
  created() {
    console.log(this.$props);
    if (this.$props.last_username !== 'undefined') {
      this.username = this.$props.last_username;
    }
    console.log('login component: ' + this.$store.getters.isAuthenticated);

    if (this.$store.getters.isAuthenticated == true) {
      this.router.push('/')
    }

  },
  methods: {
    sendLogin() {
      console.log('send login form');
      fetch('/account', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
              'username': this.username,
              'password': this.password,
              '_csrf_token': this.$props.csrf_token
            })
          })
      .then(response => response.json())
      .then(data =>{
        if (data === 'authenticated'){
          this.$store.commit('change', true);
          console.log('user authenticated succesfully' + this.$store.getters.isAuthenticated);
          this.$router.push('/');
        }
        else{
          this.isError == true;
          this.errorMessage = data
        }
      })
    }
  }


}
</script>

<style scoped>

</style>