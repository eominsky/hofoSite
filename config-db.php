<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'info230_SP17_fp_flower');
define('DB_USER', 'fp_flower');
define('DB_PASSWORD', 'info2300FP');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$db = new pdo( 'mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
?>
