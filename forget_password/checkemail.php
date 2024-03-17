<?php
include '../connect.php';

$useremail = filterReq('email');

$verifyCode = rand(100000,999999);

$statement = $connect->prepare("SELECT * FROM user WHERE user_email = ?");
$statement->execute(array($useremail));

$count = $statement->rowCount();
if ($count > 0) {
     $data = array(
        'user_verifycode' => $verifyCode,
    );
     updateData('user',$data,"user_email = '$useremail'",true);
    sendEmail($useremail,'E-Commerce App : Verify Code','Verify Code : '. $verifyCode);
} else {
    echo json_encode(array('status' => 'failure', 'message' => 'EMAIL DOES NOT EXIST'));
}
?>
