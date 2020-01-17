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
  </style>
</head>
<body>
    <div id="map"></div>
   
  <script type="text/javascript">
    var optionsMap={
      center:[3.4516,-76.5320],
      zoom: 15,
    }
    var map = L.map('map',optionsMap);
    var osmUrl = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var manzanas = new L.geoJson();   
    $.ajax({
    dataType: "json",
    url: "http://localhost/datos.php",
    success: function(data) {
            $(data.features).each(function(key, data) {
            manzanas.addData(data);

            });
        }
    });
    manzanas.addTo(map);
    

    //var geoJsonLayer = L.geoJson(geojson).addTo(map);

    
  </script>
</body>
</html> 