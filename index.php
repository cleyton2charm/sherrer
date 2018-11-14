<!DOCTYPE html> <html>

  <head>
    <meta name="description" content="Ferramenta Geocoder da Google Maps API" />
    <title>Ferramenta Geocoder da Google Maps API</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  </head>
  <body>
    
    <?php //include_once("notificacao.php"); ?>
    <script>
    // Call Geocode
    geocode();
    geocode2();
    // Get location form
    //var locationForm = document.getElementById('location-form');
    // Listen for submiot
    //locationForm.addEventListener('submit', geocode);
    function geocode(){
      $.ajax({
        url: 'https://www.receitaws.com.br/v1/cnpj/23327924000100', type: 'GET', crossDomain: true, dataType: 'jsonp', success: function(data) { console.log(data); console.log(data.nome); console.log(data.email); }, error: function(e) { console.error(e); },beforeSend: function(xhr) {
        xhr.setRequestHeader('Access-Control-Allow-origin', 'true');
      }});
      // Prevent actual submit
      //e.preventDefault();
      //var location = document.getElementById('location-input').value;
      /*
      var location = 'Rua Limites 1896'; 
      axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
        params:{
          address:location,
          key:'AIzaSyADoArgfgf0BYq0tcAW4Y1hmyMbtm1Xa10'
        }
      })
      .then(function(response){
        // Log full response
        console.log(response);
        // Formatted Address
        //var formattedAddress = response.data.results[0].formatted_address;
        /*
        var formattedAddressOutput = `
          <ul class="list-group">
            <li class="list-group-item">${formattedAddress}</li>
          </ul>
        `;

        // Address Components
        var addressComponents = response.data.results[0].address_components;
        var addressComponentsOutput = '<ul class="list-group">';
        for(var i = 0;i < addressComponents.length;i++){
          addressComponentsOutput += `
            <li class="list-group-item"><strong>${addressComponents[i].types[0]}</strong>: ${addressComponents[i].long_name}</li>
          `;
        }
        addressComponentsOutput += '</ul>';
        // Geometry
        var lat = response.data.results[0].geometry.location.lat;
        var lng = response.data.results[0].geometry.location.lng;
        var geometryOutput = `
          <ul class="list-group">
            <li class="list-group-item"><strong>Latitude</strong>: ${lat}</li>
            <li class="list-group-item"><strong>Longitude</strong>: ${lng}</li>
          </ul>
        `;
        // Output to app
        document.getElementById('formatted-address').innerHTML = formattedAddressOutput;
        document.getElementById('address-components').innerHTML = addressComponentsOutput;
        document.getElementById('geometry').innerHTML = geometryOutput;
        
      })
      
      .catch(function(error){
        console.log(error);
      });
      */
    }
    function geocode2(){
      var service = new google.maps.DistanceMatrixService();
      service.getDistanceMatrix(
        {
          origins: ['Rua limites 1896', 'avenida santa cruz 555'],
          destinations: ['avenida santa cruz 555', 'Rua limites 1896'],
          travelMode: 'DRIVING'
        }, callback);

      function callback(response, status) {
        console.log(response);
        // See Parsing the Results for
        // the basics of a callback function.
      }
    }  
  </script>
  <script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMXICDxVwaJlDZ_dYidRbRM_fwdt51dcg&callback=geocode2">
</script>
  </body>
</html>
