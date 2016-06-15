<?php
/*
header('Content-type: application/json');
//$url = "http://127.0.0.1/wine/getjson.php?url=http://maps.googleapis.com/maps/api/distancematrix/json?origins=".$_GET['lat1'].",".$_GET['lng1']."&destinations=".$_GET['lat2'].",".$_GET['lng2']."&mode=driving&language=pl-PL"
$url = "http://127.0.0.1/wine/getjson.php?url=maps.googleapis.com/maps/api/distancematrix/json?origins=39.3557667,-75.064105&destinations=40.896229,-74.087443&mode=driving&language=pl-PL";
//$url=$_GET['url'];
*/
$json=GetDrivingDistance($_GET['lat1'],$_GET['lat2'],$_GET['lng1'],$_GET['lng2']);
echo floor(str_replace(" ", "",str_replace("km", "", $json)))/1.61;


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
    sleep(1);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
    return $dist;
    //return array('distance' => $dist, 'time' => $time);
    }
?>