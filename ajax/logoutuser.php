<?php
session_start();

if (isset($_SESSION['logged_user'])) {
    $logout['status'] = true;
    $logout['user'] = $_SESSION['logged_user'];
    unset($_SESSION[ 'logged_user' ]);
} else {
    $logout['status'] = false;
}

echo json_encode($logout);
?>
