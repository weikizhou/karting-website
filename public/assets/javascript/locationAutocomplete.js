document.getElementById('registration_postal_code').addEventListener("focusout", getPostalCode);
document.getElementById('registration_house_nr').addEventListener("focusout", getHouseNumber);

var postalCode;
var houseNumber;
var location;

console.log(1221212);
function getPostalCode(){
    postalCode = document.getElementById('registration_postal_code').value;
    getAddres();
}
function getHouseNumber(){
    houseNumber = document.getElementById('registration_house_nr').value;
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

            document.getElementById('registration_address').value = weergaveNaam;
        }
    }
}