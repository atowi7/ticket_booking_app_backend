<?php
include '../connect.php';

$id = filterReq('id');
//$userid = filterReq('userid');

deleteData('address',"address_id = '$id'");
?>
