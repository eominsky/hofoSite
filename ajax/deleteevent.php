<?php
session_start();
require_once '../config-db.php';

//Check input
$id = intval($_POST["id"]);
if (empty($id)) {
  $error['error'] = 'Missing id';
  echo json_encode($error);
  die();
}

//Set up return
$error['error'] = array();

//Execute sql
$query = 'DELETE FROM events WHERE id = :id';
$stmt = $db->prepare($query);
$executed = $stmt->execute(array(':id' => $id));
if(!$executed){
  $error['error'][] = "SQL query $query not executed";
  echo json_encode($error);
  exit();
}

// Send back the array as json
echo json_encode($error);
?>
