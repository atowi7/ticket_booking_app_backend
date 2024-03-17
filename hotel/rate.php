<?php
include '../connect.php';

$id = filterReq('hotelid');
$rate = filterReq('rate');
$comment = filterReq('comment');

 $data = array(
     'hotel_rate' => $rate,
     'hotel_ratenote' => $comment
    );
 updateData('hotel',$data,"hotel_id = '$id'",true);
?>