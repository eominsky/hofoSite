<?php
session_start();
//Set up return
$error['error'] = array();

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])){
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $message = htmlentities($_POST['message']);
    if (isset($_POST['subject'])){
        $subject = htmlentities($_POST['subject']);
    } else {
        $subject = 'no subject';
    }

    if (preg_match("/[a-zA-Z' -]/", $name) && preg_match("/[a-zA-Z'?!.;:()0-9,\-\/ ]/", $message) && preg_match("/[a-zA-Z'?!.;:()0-9,\-\/ ]/", $subject)){
        $header = "FROM: $email";
        if (isset($_POST['listserve'])){
            $message = $message . "\r\n" . "Add me to the list-serve.";
            $success = mail('jisoo413@gmail.com,', $subject, $message, $header);
            if ($success != FALSE){
                $error['status'] = true;
            } else {
                $error['status'] = false;
            }
        } else {
            $success = mail('jisoo413@gmail.com', $subject, $message, $header);
            if ($success != FALSE){
              $error['status'] = true;
            } else {
              $error['status'] = false;
            }
        }
        echo json_encode($error);
    }
}
?>
