<!DOCTYPE html>
<html>
<head>
  <title>GEOJSON</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>

  <!-- Latest compiled and minified CSS -->
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
  integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
  crossorigin=""></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <style type="text/css">

    html,body{
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
    }
    .awesome-marker i {
          font-size: 18px;
          margin-top: 8px;
      }
    #container{
      height: 70%;
      width: 50%;
      margin: auto;
    }
    #container button{
      cursor: pointer;
    }
    #map{
      height: 100%;
      width: 100%;
      margin: auto;
    }

	/* ESTILOS PARA EL CUADRITO DEL NUMERO DE MANZANAS */

	.info {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white;
    background: rgba(255,255,255,0.8);
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    border-radius: 5px;
}
.info h4 {
    margin: 0 0 5px;
    color: #777;
}
  </style>



</head>
<body>
    <div id="map"></div>
      
  <script type="text/javascript">
    var optionsMap={
      center:[3.4516,-76.5320],
      zoom: 15,
    }

	function styleGeojson(){
		const objectStyle = {
			color : 'red'
		}
	}

    var map = L.map('map',optionsMap);
    var osmUrl = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);


	let url = "http://localhost/datos.php"

fetch(
   url
).then(
	res => res.json()
).then(
	data => {

	 var geojsonlayer =  L.geoJson(data, {

		 onEachFeature: function(feature, layer){
		
		 layer.on('mouseover', function(e) {

			 //SE LLAMA LA FUNCIÓN resaltarFeature
			 
			 resaltarFeature(layer);
			 info.update(layer.feature.properties);


			 // SE UTILIZA PARA AÑADIR UN POPUP CON EL "idmanzana" DESDE LA BASE DE DATOS AL DAR CLICK 

			 //layer.bindPopup(feature.properties['idmanzana']);

 			// SE UTILIZA PARA AÑADIR UN POPUP CON EL "idmanzana" DESDE LA BASE DE DATOS AL PASAR EL MOUSE 

			// var popup = L.popup()
			//  .setLatLng(e.latlng) 
			//  .setContent(feature.properties['idmanzana'])
			//  .openOn(map);
		  });


		  //SE UTILIZA PARA RESETEAR LOS ESTILOS DE LA CAPA GEOJSON AL QUITAR EL MOUSE
		  layer.on('mouseout', function(e) {
			geojsonlayer.resetStyle(e.target);
			  });


		//SE LLAMA LA FUNCIÓN PARA HACER ZOOM A LA MANZANA AL HACER CLICK
		layer.on('click', function(e) {
			zoomToFeature(e)
		});


 		
		 }}).addTo(map)
		 var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

// method that we will use to update the control based on feature properties passed
info.update = function (props) {
    this._div.innerHTML = '<h4>NUMERO DE MANZANA</h4>' +  (props ?
        '<b>' + props.idmanzana + '</b><br />' + '' + ''
        : 'Pase el mouse sobre una manzana');
};

info.addTo(map);

	}   
)


// FUNCIÓN PARA RESALTAR LAS MANZANAS AL PASAR EL MOUSE
function resaltarFeature(e){
		e.setStyle({
			weight:4,
			fillColor: 'red',
		});

	}

// FUNCIÓN PARA RESETEAR EL ESTILO DE LAS MANZANAS AL PASAR EL MOUSE
// function resetearStyle(e){
// 	geojsonlayer.resetStyle(e.target);
// }


//FUNCIÓN PARA HACER ZOOM A LA MANZANA CUANDO SE DA CLICK

function zoomToFeature(e) {
     map.fitBounds(e.target.getBounds());
}












  </script>
</body>
</html> 