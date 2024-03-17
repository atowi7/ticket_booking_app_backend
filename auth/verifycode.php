<?php
include "../conncect.php";
$email = filterReq("name");
$verifycode = filterReq("verifycode");

$statment = $connect->prepare("SELECT * FROM user WHERE user_email = ? AND user_verifycode = ?");
$statment->execute(array($email,$verifycode));

$count = $statment->rowCount();

if($count > 0){
    $data = array("user_approval" => "1");
        
        updateData("user",$data,"user_email = $email");
}else{
    echo json_encode(array('status' => 'VerifyCode is not correct'));
}

?>