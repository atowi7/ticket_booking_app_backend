<?php
define('MB', 1048576);

function checkAuthenticate()
{
  if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
    if ($_SERVER['PHP_AUTH_USER'] != 'atowi7' || $_SERVER['PHP_AUTH_PW'] != 'ecommerece123') {
      header('WWW-Authenticate : Basic realm="my realm"');
      header('HTTP/1.0 401 Unauthorized');

      echo 'Page not found';

      exit;
    } else {
      exit;
    }
  }
}

function filterReq($reqName)
{
  return htmlspecialchars(strip_tags($_POST[$reqName]));
}

function getData($table, $where = null, $values = null,$json = true)
{

  global $connect;

  $statment = $connect->prepare("SELECT * FROM $table WHERE $where");
  $statment->execute($values);

  $data = $statment->fetch(PDO::FETCH_ASSOC);

  $rowcount = $statment->rowCount();

  

   if($json == true){
   if ($rowcount > 0) {
    echo json_encode(array('status' => 'sucess', 'data' => $data));
  } else {
    echo json_encode(array('status' => 'failure'));
  }

  }
  
   return $rowcount;
  
}

function getAllData($table, $where = null, $values = null,$json = true)
{

  global $connect;
  
  if($where == null){
       $statment = $connect->prepare("SELECT * FROM $table");
       $statment->execute();
  }else{
       $statment = $connect->prepare("SELECT * FROM $table WHERE $where"); 
       $statment->execute($values);
  }
  
 

  $data = $statment->fetchAll(PDO::FETCH_ASSOC);

  $rowcount = $statment->rowCount();
  
  if($json == true){
    if ($rowcount > 0) {
     echo json_encode(array('status' => 'sucess', 'data' => $data));
    } else {
     echo json_encode(array('status' => 'failure'));
    }

  }else{
  if ($rowcount > 0) {
     return $data;
    } else {
     return $rowcount;
    }
  }
 return $rowcount;
 
}

function insertData($table, $data, $json = true)
{
  global $connect;

  $columns = implode(',', array_keys($data));

  $valp = array();

  foreach ($data as $k => $v)
    $valp[] = ':' . $k;

  $valp = implode(',', $valp);
  $statment = $connect->prepare("INSERT INTO $table ($columns) VALUES ($valp)");

  foreach ($data as $k => $v)
    $statment->bindValue(':' . $k, $v);

  $statment->execute();

  $rowCount = $statment->rowCount();

  if ($json == true) {
    if ($rowCount > 0) {
      echo json_encode(array('status' => 'sucess'));
    } else {
      echo json_encode(array('status' => 'failure'));
    }
  }

  return $rowCount;
}

function updateData($table, $data, $where, $json=true)
{
    try{
        $columns = array();
  $values = array();

  foreach ($data as $k => $v) {
    $columns[] = $k . '=?';
    $values[] = $v;
  }

  global $connect;

  $statment = $connect->prepare("UPDATE $table SET " . implode(',', $columns) . " WHERE $where");

  $statment->execute($values);

  $rowCount = $statment->rowCount();

  if ($json == true) {
    if ($rowCount > 0) {
      echo json_encode(array('status' => 'sucess'));
    } else {
      echo json_encode(array('status' => 'failure'));
    }
  }
    }catch(Exception $e){
         echo json_encode(array('status' => 'failure'));
    }
  
  return $rowCount;
}

function deleteData($table, $where, $json = true)
{
  global $connect;

  $statment = $connect->prepare("DELETE FROM $table WHERE $where");

  $statment->execute();

  $rowCount = $statment->rowCount();

  if ($json == true) {
    if ($rowCount > 0) {
      echo json_encode(array('status' => 'sucess'));
    } else {
      echo json_encode(array('status' => 'failure'));
    }
  }
  return $rowCount;
}

function imageUpload($dir, $imgReq)
{
  $imgErorr = array();
  
  if(isset($_FILES[$imgReq])){
       $imgName = rand(0, 1000) . $_FILES[$imgReq]['name'];
  $imgTmp = $_FILES[$imgReq]['tmp_name'];
  $imgSize = $_FILES[$imgReq]['size'];

  $extAllow = array('png', 'jpg', 'gif', 'svg', 'mp3', 'pdf');

  $ext = strtolower(end(explode('.', $imgName)));

  if (empty($imgName)) {
    $imgErorr[] = 'No Image';
  }
  if (!in_array($ext, $extAllow)) {
    $imgErorr = 'Extension Error';
  }
  if ($imgSize > 2 * MB) {
    $imgErorr[] = 'Size Error';
  }

  if (empty($imgErorr)) {
    move_uploaded_file($imgTmp,$dir . '/' . $imgName);
    return $imgName;
  }
  
  return 'fail';
  
  }else{
    
  return 'empty';
  }

}

function deleteFile($dir, $imgName)
{
  if (file_exists($dir . '/' . $imgName)) {
    unlink($dir . '/' . $imgName);
  }
}

//need hosting to work like hostanger web
function sendEmail($to, $subject, $message)
{
  $header = array(
    'From' => 'dhoom.not@gmail.com',
    'CC' => 'dhoom.sedge@gmail.com'

  );
  // $header='From: dhoom.not@gmail.com' . '\n' . 'CC: dhoom.sedge@gmail.com';
  mail($to, $subject, $message, $header);
}

function sendFCM($title, $body, $topic, $pagename){
  $url = 'https://fcm.googleapis.com/fcm/send';
  $fields = array(
      'to' => '/topics/'.$topic,
      'priority' => 'high',
      'content-available' => true,
      
      'notification' => array(
          'title' => $title,
          'body' => $body,
          'click_actoin' => 'FLUTTER_NOTIFICATION_CLICK',
          'sound' => 'default'
          ),
       'data' => array(
          'pagename' => $pagename,
          ),  
      );
      
      $hfeilds = json_encode($fields);
      
      $header = array(
          'Authorization:key='.'AAAAHZhfZo0:APA91bE8byUrlh6an85aYgzi6tEj9cp_pYrV3zbIRF9PfOCYLSVsoRWb5l8TC22XQvC4JuBngTgHAYj3aJ5EyNn0miT2bWlaiJcAicA03oXDnClU2qP4dYXWFCBUK5GAwBh2SUd1ZXNl',
          'Content-Type:application/json'
          );
          
          $curl = curl_init();
          curl_setopt($curl,CURLOPT_URL,$url);
          curl_setopt($curl,CURLOPT_POST,true);
          curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
          curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
          curl_setopt($curl,CURLOPT_POSTFIELDS,$hfeilds);
          
          $res = curl_exec($curl);
          return $res;
          curl_close($curl);
}

function sendSMS(){}

function insertnotify($title, $body, $adminid, $userid){
     global $connect;
     $statment = $connect->prepare("INSERT INTO `notification`(`notification_title`, `notification_body`, `notification_adminid`, `notification_userid`) VALUES (?,?,?,?)");
     $statment->execute(array($title,$body,$adminid,$userid));
     
     //sendFCM($title,$body,$topic,$pagename);
     
     $rowCount = $statment->rowCount();
     
     return $rowCount;
}

?>
