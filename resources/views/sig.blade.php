<!DOCTYPE html>
<html>
<head>
  <title>GEOJSON</title>



  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>

  <!-- Latest compiled and minified CSS -->
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
  integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
  crossorigin=""></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  

  <!-- SE AGREGAN LAS LINEAS DE CODIGO PARA HACER USO DEL Plugin para medir distancias de líneas -->

<link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
<script src="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js"></script>


<!-- SE AGREGAN LAS LINEAS DE CODIGO PARA HACER USO DEL Plugin para OPTENER LA LOCALIZACIÓN -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />

<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>



<!-- SE AGREGAN PARA OPTENER LAS COORDENADAS AL PASAR EL MOUSE -->

<script type="text/javascript" src="http://mrmufflon.github.io/Leaflet.Coordinates/dist/Leaflet.Coordinates-0.1.3.min.js"></script>
<link rel="stylesheet" href="http://mrmufflon.github.io/Leaflet.Coordinates/dist/Leaflet.Coordinates-0.1.3.css"/>


<!-- SE AGREGAN PARA OPTENER LOS MAPAS BASE -->
<link rel="stylesheet" href="http://consbio.github.io/Leaflet.Basemaps/L.Control.Basemaps.css" />
<script src="http://consbio.github.io/Leaflet.Basemaps/L.Control.Basemaps.js"></script>



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

#was
{ 
    text-align:center;
    border-radius:5px;
    background: rgba(255,255,0,0.7);
    position:absolute;
    top:10px;
    left:calc(50% - 300px);
    margin:auto;
        z-index: 2000;
    display: inline-block;
}

.input.maps input {
    padding: 0 35px;
}

#places {
    float: left;
    
    width: 500px;
    border: 3px solid #d5eff6;
    -webkit-border-radius: 6px;
    border-radius: 6px;
    background-color: #fff;
  
}

  </style>



</head>
<body>

<div id="was">
	
	 <div class="left-inner-addon">
        <i class="fa fa-map-marker" style="left:calc(50% - 250px);"></i>
        <input  id="places" type="text"
               class="form-control" 
               placeholder="Vul provincie, gemeente, plaatsnaam of postcode in" />
    </div>
</div>



    <div id="map"></div>


<script type="text/javascript">
  


  
  // PARA DAR LA POSICIÓN INICIAL Y EL ZOOM DEL MAPA
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
			 //HACE USO DE LA FUNCIÓN info.update
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


// METODO UTILIZADO PARA MOSTRAR EL NUMERO DE LA MANZANA AL PASAR EL MOUSE

		 var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

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


			// CODIGO UTILIZADO PARA MOSTRAR LA BARRA DE ESCALA EN EL MAPA 
			L.control.scale ({maxWidth:240, metric:true, imperial:false, position: 'bottomright'}).addTo (map);
           
		   
		    // CODIGO UTILIZADO PARA HACER USO DEL Plugin de folleto para medir distancias 
			let polylineMeasure = L.control.polylineMeasure ({position:'topleft', unit:'metres', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: true})
            polylineMeasure.addTo (map);

            function debugevent(e) { console.debug(e.type, e, polylineMeasure._currentLine) }

            map.on('polylinemeasure:toggle', debugevent);
            map.on('polylinemeasure:start', debugevent);
            map.on('polylinemeasure:resume', debugevent);
            map.on('polylinemeasure:finish', debugevent);
            map.on('polylinemeasure:clear', debugevent);
            map.on('polylinemeasure:add', debugevent);
            map.on('polylinemeasure:insert', debugevent);
            map.on('polylinemeasure:move', debugevent);
            map.on('polylinemeasure:remove', debugevent);


// CODIGO UTILIZADO PARA HACER USO DEL Plugin PARA MOSTRAR LA UBICACIÓN EN TIEMPO REAL 
			
var lc = L.control.locate({
    position: 'topleft',
    strings: {
        title: "Mostrar posición actual"
    }
}).addTo(map);




// SE OPTIENEN LAS COORDENADAS AL PASAR EL MOUSE

		L.control.coordinates({
			position:"bottomright",
			decimals:3,
			decimalSeperator:",",
			labelTemplateLat:"Latitude: {y}",
			labelTemplateLng:"Longitude: {x}"
		}).addTo(map);



// SE OPTIENEN LOS LAYERS DE CON LOS MAPAS BASE
var basemaps = [ 
                L.tileLayer("https://mt1.google.com/vt/lyrs=r&x={x}&y={y}&z={z}", {
                    subdomains: "abcd",
                    maxZoom: 20,
                    minZoom: 0,
                    label: "Google Maps"
                }),
                L.tileLayer("http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}", {
                     subdomains: "abcd",
                    maxZoom: 20,
                    minZoom: 0,
                    label: "Google Satellite"
                }),
                L.tileLayer("http://a.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    subdomains: "abcd",
                    maxZoom: 16,
                    minZoom: 1,
                    label: "OpenStreetMap Standard"
                })
            ];
            map.addControl(
                L.control.basemaps({
					position:"bottomleft",
                    basemaps: basemaps,
                    tileX: 0,
                    tileY: 0,
                    tileZ: 1
                })
            );








  </script>
</body>
</html> 