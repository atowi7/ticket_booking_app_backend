<?php
include '../connect.php';

$useremail = filterReq('email');
$userpass = sha1($_POST['pass']);

$data = array(
        'pass' => $userpass,
    );
updatedata('user',$data,"user_email= '$useremail'",true);
?>