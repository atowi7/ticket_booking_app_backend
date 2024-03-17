<?php
include "../conncect.php";
$email = filterReq('email');

$data = array($email,$pass);
$verifycode = rand(1000,9999);

$data = array(
       "user_verifycode"=> $verifycode
    );

updateData('user',$data,"user_email = '$email'");
sendEmail($email,"VerifyCode ECommerce App","VerifyCode : $verifycode")
?>