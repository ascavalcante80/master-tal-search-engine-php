<?php

// Connexion à MySQL

$username = "root";
$password = "20060907jl";
$dbname = "coogle";
$servername = "localhost";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>


