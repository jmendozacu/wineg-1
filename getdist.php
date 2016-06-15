<?php


        $address = urldecode($_GET["address"]);
        $output = GetGApi($address);
       
   
        //echo "<pre>"; print_r($output); 
        $lat1 = $output["results"][0]["geometry"]["location"]["lat"];
        $long1 = $output["results"][0]["geometry"]["location"]["lng"];
        //Mage::log($url.$lat1.$long1, null, 'mylogfile1.log');
        //$location = current($location);
        $lat2 = $_GET["lat2"];
        $long2 = $_GET["long2"];
        //echo GetDrivingDistance($lat1, $lat2, $long1, $long2);
        $output = distance($lat1, $long1, $lat2, $long2,"M").",".$lat1.",".$long1;
        echo $output;
        die;


    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);

      if ($unit == "K") {
        return ($miles * 1.609344);
      } else if ($unit == "N") {
          return ($miles * 0.8684);
        } else {
            return $miles;
          }
    }    
    
    function GetGApi($data)
    {
    //$url = 'http://maps.google.com/maps/api/geocode/json?address=''47+Warbird+Dr.,+Millville,+New%20Jersey,+US,+08332''&sensor=false';
    $data = str_replace(" ", "+", $data);
    $url = 'http://maps.google.com/maps/api/geocode/json?address='.$data.'&sensor=false';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
  
    $response_a = json_decode($response, true);
    
    return  $response_a;
    //return array('distance' => $dist, 'time' => $time);
    }


    function GetDrivingDistance($lat1, $lat2, $long1, $long2)
    {
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    //return $response;
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
    return floor(str_replace(" ", "",str_replace("km", "", $dist)))/1.61;
    //return $dist;
    //return array('distance' => $dist, 'time' => $time);
    }
        ?>

