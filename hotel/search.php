<?php

include '../connect.php';

$word = filterReq('word');

getAllData('hotel',"hotel_name LIKE '%$word%' OR hotel_name_ar LIKE '%$word%'");

?>