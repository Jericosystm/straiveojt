<?php
$host = "localhost";
$user = "root";      // Default XAMPP/WAMP user
$pass = "";          // Default password is empty
$dbname = "straivefl";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>