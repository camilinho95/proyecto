@extends('layouts.app')

@section('content_sig')
 <div>    
  
    <div id="map" >
          
    </div>
    
    
    <script>
        const map = L.map('map', { center: [3.396, -76.5227], zoom: 20 })
        const osm = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);
        const esri = new L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}');

        function addLayer(layer) {
            if (map.hasLayer(layer)) {
                map.removeLayer(layer)

            } else {
                map.addLayer(layer)
            }
        }

        function styleGeojson(){
                const objectStyle =  {
                    color:'purple',
                    fillcolor: 'orange',
                    weight:1,
                    fillOpacity: 0.5

                }
            }


            const geojsonLayer = L.geoJson(manzanasur,{style:styleGeojson}).addTo(map);

            const bounds = geojsonLayer.getBounds();
            console.log(bounds);
            map.fitBounds(bounds);

    </script>
 </div>
@endsection