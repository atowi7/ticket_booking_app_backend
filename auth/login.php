<?php
include "../conncect.php";
$email = filterReq('email');
$pass = sha1($_POST['pass']);

$data = array($email,$pass);

getAllData('user',"user_email = ? AND user_pass = ?",data);
?>