<?php
include "../conncect.php";
$name = filterReq("name");
$email = filterReq("email");
$pass = sha1($_POST['pass']);
$phone = filterReq("phone");
$verifycode = rand(1000,9999);

$statment = $connect->prepare("SELECT * FROM user WHERE user_email = ? OR user_phone = ?");
$statment->execute(array($email,$phone));

$count = $statment->rowCount();

if($count > 0){
     echo json_encode(array('status' => 'Email or Phone exist'));
}else{
    
    $data = array(
        "user_name" => $name,
        "user_email" => $email,
        "user_pass" => $pass,
        "user_pass" => $phone,
        "user_verifycode" => $verifycode,
        );
        
        sendEmail($email,"VerifyCode ECommerce App","VerifyCode : $verifycode");
        inserData("user",$data);
}

?>