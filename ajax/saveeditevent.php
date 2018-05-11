<?php
session_start();
require_once '../config-db.php';

//Set up return
$error['error'] = array();

//Check input
$num = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$id = intval($num);
if (empty($id)) {
  $error['error'][] = 'Missing id';
  echo json_encode($error);
  die();
}

//get old file_path & file_name
$query= "SELECT file_path, file_name FROM events WHERE id = :id";
$stmt = $db->prepare($query);
$executed = $stmt->execute(array(":id" => $id));
if(!$executed){
  $error['error'][] = "SQL query $query not executed";
  $error['error'][] = $stmt->errorInfo();
  echo json_encode($error);
  exit();
}

$num_results = $stmt->rowCount();
if($num_results > 1){
  $error['error'][] = "More than 1 result with same id: $id";
}

$file = array();
if($row =  $stmt->fetch(PDO::FETCH_ASSOC)){
  $file['file_path'] = $row['file_path'];
  $file['file_name'] = $row['file_name'];
}

//Set up SQL
$query = "UPDATE events
          SET title = :title, start_date = :start_date, start_time = :start_time,
          end_date = :end_date, end_time = :end_time, place = :place,
          description = :description,
          file_path = :file_path, file_name = :file_name
          WHERE id = :id";
$fields = array('title', 'start_date', 'start_time', 'end_date', 'end_time', 'place', 'description', 'file_path', 'file_name');
$stmt = $db->prepare($query);

//Upload file if there is one
if($_FILES['file']['error'] === 0){
  $image=$_FILES['file'];
  $file_name=$_FILES['file']['name'];
  $image_tmp =$_FILES['file']['tmp_name'];
  if($_FILES['file']['error'] === 0){
    $file_path = "../images/";
    if(empty($file['file_name']) || empty($file['file_path']) || $file['file_name'] !== $file_name){
      $move_successfully = move_uploaded_file($image_tmp, $file_path.$file_name);
      if(!$move_successfully){
        $error['error'][] = "$image_tmp was not moved successfully";
      }else{
        $_SESSION['photos'][] = $file_name;
      }
    }
  }
}

//Prepare sql query

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
    $value = ($_FILES['file']['error'] === 0) ? "images/" : (($_POST['delete-file'] === true) ? NULL : $file['file_path']);
  }elseif($field === 'file_name'){
    $value = ($_FILES['file']['error'] === 0) ? $_FILES['file']['name'] : (($_POST['delete-file'] === true) ? NULL : $file['file_name']);
  }else{
    $value = (!empty($_POST[$field])) ? htmlentities($_POST[$field]) : NULL;
  }

  $parameter = ":$field";
  $paramToValues[$parameter] = $value;
}
$paramToValues[":id"] = $id;

//Save edits
$executed = $stmt->execute($paramToValues);
if(!$executed){
  $error['error'][] = "SQL query $query not executed";
  $error['error'][] = $stmt->errorInfo();
  echo json_encode($error);
  exit();
}

echo json_encode($error);
?>
