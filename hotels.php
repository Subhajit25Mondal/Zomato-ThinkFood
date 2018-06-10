<html>
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Hotels Nearby</title> 
  <script src="http://maps.google.com/maps/api/js?key=&callback=initMap"				<!--GOOGLE_MAP API KEY HERE--> 
          type="text/javascript"></script>
     <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    
</head>
<body>
<div id="map"></div>

<script type="text/javascript">
    
<?php
//error_reporting(0);
    
if(isset($_POST['search'])){    


    $cunt=6;
    $latt=$_POST['user_query1'];
    $longi=$_POST['user_query2'];
   // $radi=20000;
    $ul="   ";									//API KEY HEREE
   

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ul);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$headers = array(
  "Accept: application/json",
  "User-Key:   "                                                //USER KEY HERE
  );
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);




 $json_data = json_decode($result);



$index=0;
                                                                        //MAP SCRIPT
    
 
 echo "var locations = [";   

                                                                        //MAP SCRIPT LOOP

     
   for ($index = 0; $index < $cunt; $index++) {
       
   
       
       
     $na=$json_data->nearby_restaurants[$index]->restaurant->name;  
     $ad=$json_data->nearby_restaurants[$index]->restaurant->location->address;  
     $la=$json_data->nearby_restaurants[$index]->restaurant->location->latitude;  
     $lo=$json_data->nearby_restaurants[$index]->restaurant->location->longitude;
     $price=$json_data->nearby_restaurants[$index]->restaurant->average_cost_for_two;
     $li=$json_data->nearby_restaurants[$index]->restaurant->url;  
       
       
       echo "['$na', $la, $lo, $index, '$ad', $price, '$li'],";
      

   
   
   
   
   
   } 
     
    

                                                                                           //MAP SCRIPT LOOP END
    
    echo "[' ', , , $index, ' ']";
    echo "];";


   







}









?>
    
    
    
    
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      <?php  echo "center: new google.maps.LatLng($latt, $longi),"  ?>
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent('<center><b>'+locations[i][0]+'</b><br>'+locations[i][4]+'<br> <b>Price of Two: Rs.'+locations[i][5]+'&nbsp;&nbsp;<a href="'+locations[i][6]+'"> Book Now </a></b></center>');
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>
    
    
    
    
    
    </body>
</html>
