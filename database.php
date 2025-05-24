<?php
$db_server = "localhost";
$db_user = "";
$db_pass = "";
$db_name = "lms";

$password = getenv("DB_PASSWORD"); // or from config
$conn = new mysqli("localhost", "root", $password, "lms");


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>