@extends('layouts.app')

@section('content_sig')
 <div>    
   
    <div id="map" >
          
    </div>
    <script>
    
    </script>
    <script>

    // const optionMap = {
    //     center: [3.4516, -76.5320],
    //     zoom: 12
    // }

    // //  function styleGeojson(){
    // //     const objectStyle =  {
    // //         color:'purple',
    // //         fillcolor: 'orange',
    // //         weight:1,
    // //         fillOpacity: 0.5

    // //     }

    // //     return objectStyle;
    // // }
    //  const map = L.map('map');
    //  var osm = new L.TileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);



        const map = L.map('map', { center: [3.396, -76.5227], zoom: 15 })
        const osm = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);
        const esri = new L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}');

        // function addLayer(layer) {
        //     if (map.hasLayer(layer)) {
        //         map.removeLayer(layer)

        //     } else {
        //         map.addLayer(layer)
        //     }
        // }
       
        // function styleGeojson(){
        //         const objectStyle =  {
        //             color:'purple',
        //             fillcolor: 'orange',
        //             weight:1,
        //             fillOpacity: 0.5

        //         }
        //     }

           
           let marker = L.marker( [3.396, -76.5227]).addTo(map);
            var datos;
            fetch('/datos_sig')
            .then(res => res.json())
            .then(data => {
            
               // console.log(datos);
              let geojsonLayer = L.geoJson(data,{
                onEachFeature: function(feature, layer){
                    layer.bindPopup(feature.properties['idmanzana'])
                }

              }).addTo(map);
            })


            //const geoJsonLayer = L.geoJSON(datos,{style:styleGeojson}).addTo(map);
          //  const bounds = geoJsonLayer.getBounds();
           //    console.log(bounds);
            
           // map.fitBounds(bounds);
     
    </script>
 </div>
@endsection