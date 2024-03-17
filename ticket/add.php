<?php
include '../connect.php';

$name = filterReq('name');
$lat = filterReq('lat');
$long = filterReq('long');
$street = filterReq('street');
$city = filterReq('city');
$userid = filterReq('userid');

$data = array(
        'address_name' => $name,
        'address_lat' => $lat,
        'address_long' => $long,
        'address_street' => $street,
        'address_city' => $city,
        'address_userid' => $userid,
    );
    
insertData('address', $data);
?>
