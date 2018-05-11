<?php
session_start();
require_once '../config-db.php';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if(empty($username) || empty($password)){
  $error['error'] = "Field caanot be empty. Username: $username, password: $password";
  echo json_encode($error);
  die();
}

$info = array();
$login_info=$mysqli->query("SELECT * FROM users WHERE username = '$username'");
if(!$login_info){
    $error['error'] = "Query not working";
    echo json_encode($error);
    die();
}elseif($login_info->num_rows >=1){
    if($login_info->num_rows > 1){
      $error['error'] = "There is more than 1 user with username: $username";
      echo json_encode($error);
    }
    if($row = $login_info->fetch_assoc()){
        $db_hash_password = $row['hash_password'];
        if (password_verify($password, $db_hash_password)){
            $_SESSION['logged_user'] = $username;
            $info['status'] = true;
            $info['username'] = $username;
            // echo "<p>You successfully logged in, $username!</p>";
        }else{
            $info['status'] = false;
            $info['user_error'] = "Incorrect password (╯°□°)╯︵ ┻━┻";
            // print("<p>Incorrect password</p>");
        }
    }
}else{
    $info['status'] = false;
    $info['user_error'] = "Incorrect username ┏༼ ◉ ╭╮ ◉༽┓";
    // print("<p>Incorrect username</p>");
}

echo json_encode($info);
?>
