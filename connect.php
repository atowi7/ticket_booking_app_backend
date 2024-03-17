<?php
$dsn = 'mysql:host=localhost;dbname=u101772973_ticketapp;'; 
$username='u101772973_atowi7';
$password='123Vhjhfds';
$options=array(
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'
);

try {
    $connect = new PDO($dsn,$username,$password,$options); 
    // $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
    header("Access-Control-Allow-Methods: POST, OPTIONS, GET");
    
    include 'function.php';

    checkAuthenticate();
    
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
