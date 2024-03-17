<?php
include '../connect.php';

$id= filterReq('id');
$name = filterReq('name');
// $lat = filterReq('lat');
// $long = filterReq('long');
$street = filterReq('street');
$city = filterReq('city');
$userid = filterReq('userid');

$data = array(
        // 'address_lat' => $lat,
        // 'address_long' => $long,
        'address_name' => $name,
        'address_street' => $street,
        'address_city' => $city,
    );
    
 updateData('address',$data,"address_id = '$id' AND address_userid = '$userid'",true);
?>