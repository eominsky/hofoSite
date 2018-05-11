<?php
session_start();
require_once '../config-db.php';

//Set up SQL
$query = "INSERT INTO events (title, start_date, start_time, end_date, end_time, place, description, file_path, file_name)
          VALUES (:title, :start_date, :start_time, :end_date, :end_time, :place, :description, :file_path, :file_name)";
$fields = array('title', 'start_date', 'start_time', 'end_date', 'end_time', 'place', 'description', 'file_path', 'file_name');
$stmt = $db->prepare($query);

//Set up return
$error['error'] = array();

//N2SELF: N2Do DATA VALIDATION
if($_FILES['file']['error'] === 0){
  $image=$_FILES['file'];
  $file_name=$_FILES['file']['name'];
  $image_tmp =$_FILES['file']['tmp_name'];
  if($_FILES['file']['error'] === 0){
    $file_path = "../images/";
    $move_successfully = move_uploaded_file($image_tmp, $file_path.$file_name);
    if(!$move_successfully){
      $error['error'][] = "$image_tmp was not moved successfully";
    }else{
      $_SESSION['photos'][] = $file_name;
      $error['error'] = "file_name is $file_name";
    }
  }
}

foreach($fields as $field){
  if($field === 'title' || $field === 'start_date' || $field === 'start_time'){
    if(empty($_POST[$field])){
      $error['error'][] = "No value for required field: $field";
    }
  }

  if($field === 'title'){
    $value = (!empty($_POST[$field])) ? htmlentities($_POST[$field]) : "Untitled";
  }elseif($field === 'start_date'){
    $value = (!empty($_POST[$field])) ? $_POST[$field] : "NO DATE";
  }
  elseif($field === 'start_time'){
    $value = (!empty($_POST[$field])) ? $_POST[$field] : "NO TIME";
  }elseif($field === 'file_path'){
    $value = ($_FILES['file']['error'] === 0) ? "images/" : NULL;
  }elseif($field === 'file_name'){
    $value = ($_FILES['file']['error'] === 0) ? $_FILES['file']['name'] : NULL;
  }else{
    $value = (!empty($_POST[$field])) ? htmlentities($_POST[$field]) : NULL;
  }

  $parameter = ":$field";
  $paramToValues[$parameter] = $value;
}

$executed = $stmt->execute($paramToValues);
if(!$executed){
  $error['error'][] = "SQL query $query not executed";
  $info['error'][] = $stmt->errorInfo();
  echo json_encode($error);
  exit();
}

echo json_encode($error);
?>
