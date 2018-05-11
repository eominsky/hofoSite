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

//Execute sql
  //Set up SQL
$query = "SELECT * FROM events WHERE id = :id";
$fields = array('title', 'start_date', 'start_time', 'end_date', 'end_time', 'place', 'description', 'file_name');

$stmt = $db->prepare($query);
$executed = $stmt->execute(array(":id" => $id));
if(!$executed){
  $info['error'][] = "SQL query $query not executed";
  $info['error'][] = $stmt->errorInfo();
  echo json_encode($info);
  exit();
}

$num_results = $stmt->rowCount();
if($num_results > 1){
  $info['error'][] = "More than 1 result with same id: $id";
}

if($row =  $stmt->fetch(PDO::FETCH_ASSOC)){
  foreach ($fields as $field) {
    $value = $row[$field];
    $info[$field] = $value;
  }
}

$info['fields'] = $fields;

// Send back the array as json
echo json_encode($info);
?>
