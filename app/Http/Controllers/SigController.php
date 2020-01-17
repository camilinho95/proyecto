<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SigController extends Controller
{

    public function index(){

      return  view('sig');
 
    }     

    public function datos_sig(){
      
            
        function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
            $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
            $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
            $result = str_replace($escapers, $replacements, $value);
            return $result;
        }
        
        
        # Connect to PostgreSQL database
        $conn = $conn = pg_connect("dbname='sistema_central' user='postgres' password='123' host='localhost' port='5000'");
        if (!$conn) {
            echo "Not connected : " . pg_error();
            exit;
        }
        
        # Build SQL SELECT statement and return the geometry as a GeoJSON element in EPSG: 4326
        
        $sql = "select *,st_asgeojson(geom) AS geojson from manzanaswgs84";
        
        # Try query or error
        $rs = pg_query($conn, $sql);
        if (!$rs) {
            echo "An SQL error occured.\n";
            exit;
        }
        
        # Build GeoJSON
        $output    = '';
        $rowOutput = '';
        
        while ($row = pg_fetch_assoc($rs)) {
            $rowOutput = (strlen($rowOutput) > 0 ? ',' : '') . '{"type": "Feature", "geometry": ' . $row['geojson'] . ', "properties": {';
            $props = '';
            $id    = '';
            foreach ($row as $key => $val) {
                if ($key != "geojson") {
                    $props .= (strlen($props) > 0 ? ',' : '') . '"' . $key . '":"' . escapeJsonString($val) . '"';
                }
                if ($key == "id") {
                    $id .= ',"id":"' . escapeJsonString($val) . '"';
                }
            }
            
            $rowOutput .= $props . '}';
            $rowOutput .= $id;
            $rowOutput .= '}';
            $output .= $rowOutput;
        }
        
        $output = '{ "type": "FeatureCollection", "features": [ ' . $output . ' ]}';
        echo $output;


      return ($output);
    }
}
