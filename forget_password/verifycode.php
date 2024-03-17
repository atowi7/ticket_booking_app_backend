<?php

try{
    include '../connect.php';

    $useremail = filterReq('email');
    
    $verifyCode = filterReq('verifycode');
    
    
    $statement = $connect->prepare("SELECT * FROM user WHERE user_email = ? AND user_verifycode = ?");
    $statement->execute(array($useremail,$verifyCode));
    
    $count = $statement->rowCount();
    if ($count > 0) {
         echo json_encode(array('status' => 'sucess'));
    
    } else {
        echo json_encode(array('status' => 'failure', 'message' => 'VCODE ERROR'));
    }
}catch(Exception $e){
    echo $e->getMessage();
}
?>
