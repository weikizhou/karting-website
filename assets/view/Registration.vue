<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-7 registration-form mr-4">
        <div class="row mx-2">
          <h2>Maak uw eigen account</h2>
          <hr class="m-0">

          <label>E-mailadres</label>
          <div class="form-input p-0">
            <i class="far fa-envelope fa-lg"></i>
            <input type="email" name="email" placeholder="E-mailadres">
          </div>

          <label>Volledige naam</label>
          <div class="form-input p-0">
            <i class="fas fa-id-card-alt fa-lg"></i>
            <input type="text" name="name" placeholder="Volledige naam">
          </div>

          <label>Gebruikersnaam</label>
          <div class="form-input p-0">
            <i class="fas fa-user fa-lg"></i>
            <input type="text" name="username" placeholder="Gebruikersnaam">
          </div>

          <div class="row p-0">
            <div class="col-md-12 col-lg-6">
              <label>Wachtwoord</label>
              <div class="form-input">
                <i class="fas fa-unlock-alt fa-lg"></i>
                <input type="password" name="password" placeholder="Wachtwoord">
              </div>
            </div>
            <div class="col-md-12 col-lg-6 p-0">
              <label>Herhaal wachtwoord</label>
              <div class="form-input">
                <i class="fas fa-unlock-alt fa-lg"></i>
                <input type="password" name="repeated_password" placeholder="Herhaal wachtwoord">
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
            <input type="text" name="phone" placeholder="Telefoon">
          </div>

          <label>Geboorte datum</label>
          <div class="form-input p-0">
            <i class="fas fa-calendar-alt fa-lg"></i>
            <input type="date" name="date_of_birth" placeholder="Geboorte datum">
          </div>

          <div class="row p-0">
            <div class="col-md-12 col-lg-8">
              <label>Postcode</label>
              <div class="form-input p-0">
                <i class="fas fa-map-marked-alt fa-lg"></i>
                <input id="postal_code" type="text" name="postal_code" placeholder="Postcode">
              </div>
            </div>
            <div class="col-md-12 col-lg-4 p-0">
              <label>Huis nr.</label>
              <div class="form-input p-0">
                <i class="fas fa-home fa-lg"></i>
                <input id="house_nr" type="text" name="house_nr" placeholder="Huis nr.">
              </div>
            </div>
          </div>

          <label>Adres</label>
          <div class="form-input p-0">
            <i class="fas fa-map-pin fa-lg"></i>
            <input id="address" type="text" name="address" placeholder="Adres">
          </div>

          <button class="btn btn-lg btn-blue my-3" type="submit">
            Aanmelden
          </button>
        </div>

      </div>
      <div class="col-md-12 col-lg-4 registration-card shadow"
           :style="{ 'background-image' : 'url(assets/img/registratie_image.jpg)' }">
      </div>
    </div>
  </div>
</template>

<script>
document.getElementById('postal_code').addEventListener("focusout", getPostalCode);
document.getElementById('house_nr').addEventListener("focusout", getHouseNumber);

var postalCode;
var houseNumber;
var location;
console.log(houseNumber);

function getPostalCode(){
  postalCode = document.getElementById('postal_code').value;
  console.log(postalCode);
  getAddres();
}
function getHouseNumber(){
  houseNumber = document.getElementById('house_nr').value;
  console.log(houseNumber);
  getAddres();
}
function getAddres(){
  if (postalCode && houseNumber){
    var p = "?fq="+ postalCode +'&q='+ houseNumber;
    var url = 'https://geodata.nationaalgeoregister.nl/locatieserver/v3/free'+p;
    var dataset;
    fetch(url)
        .then(response => response.json())
        .then(data => {
          dataset = data;
          logDataset();
        });

    function logDataset () {
      var location = dataset['response']['docs'][0];
      var weergaveNaam = location['weergavenaam'];

      document.getElementById('address').value = weergaveNaam;
    }
  }
}
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  jQuery(document).ready(function() {
    $('.js-datepicker').datepicker({
      changeYear: true,
      yearRange: "-80:+0",
      inline: true,
      showOtherMonths: true,
      maxDate: new Date,
      dateFormat: 'yy-mm-dd',
    });
  });
</script>

<script>
export default {
  name: "Registration"
}
</script>

<style scoped>

</style>